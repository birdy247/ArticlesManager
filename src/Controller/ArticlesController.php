<?php

namespace ArticlesManager\Controller;

use ArticlesManager\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

/**
 * Articles Controller
 *
 * @property \ArticlesManager\Model\Table\ArticlesTable $Articles
 */
class ArticlesController extends AppController {

    public $paginate = [
        'limit' => 5,
    ];

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['view']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index($sectionId = null, $tagId = false) {
        $this->viewBuilder()->layout('news');

        if (!$sectionId) {
            throw new NotFoundException('Could not find section');
        }

        $section = $this->Articles->Sections->get($sectionId, [
            'contain' => ['Formations']
        ]);

        $extension = "Common/" . $section->formation->directory . "_index";

        $articles = $this->Articles
                ->find('active')
                ->contain(['Creators']);

        if ($sectionId) {
            $articles->find('section', ['section_id' => $sectionId]);
        }

        if ($tagId) {
            $articles->matching('Tags', function ($q) use($tagId) {
                return $q->where(['Tags.id' => $tagId]);
            });
        }

        $articles->contain('Tags');
        $articles->order(['Articles.created' => 'DESC']);
        $articles = $this->paginate($articles);

        $this->set(compact('articles', 'section', 'extension'));
        $this->set('_serialize', ['articles', 'section']);
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($slug = null) {

        if (!$slug) {
            throw new NotFoundException('Could not find content');
        }

        $preview = false;

        if ($this->Auth->user()) {
            $preview = true;
        }

        $this->viewBuilder()->layout('news');

        $article = $this->Articles->find('slug', ['slug' => $slug])
                ->contain(['Tags'])
                ->contain(['Sections.Formations'])
                ->contain(['Creators'])
                ->firstOrFail();

        $extension = "Common/" . $article->section->formation->directory . "_view";

        $articles = $this->Articles->find('list', ['limit' => 5, 'order' => ['Articles.created DESC']]);

        $this->set(compact('article', 'articles', 'extension', 'preview'));
        $this->set('_serialize', ['article']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $this->viewBuilder()->layout('admin');

        $preview = false;

        $article = $this->Articles->newEntity();

        if ($this->request->is('post')) {

            $redirect = ['action' => 'admin'];

            //If previewing, force this to be an un-published article
            if ($this->request->data['preview']) {
                $this->request->data['active'] = 0;
                $this->request->data['preview'] = 1;
                $preview = true;
            }

            $article = $this->Articles->patchEntity($article, $this->request->data, ['reference' => false]);

            //Pass in an option of publish.  If this is set to true, then unpublish all other versions of this article
            if ($this->Articles->save($article, ['publish' => $this->request->data['active']])) {
                $this->Flash->success(__('The article has been saved.'));
                return $this->redirect($preview ? ['controller' => 'Articles', 'action' => 'view', $article->id, '?' => ['preview' => true]] : $redirect);
            } else {
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
            }
        }

        $tags = $this->Articles->Tags->find('list', ['limit' => 200]);
        $sections = $this->Articles->Sections->find('list', ['limit' => 200]);
        $this->set(compact('article', 'tags', 'sections'));
        $this->set('_serialize', ['article']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $this->viewBuilder()->layout('admin');

        //If this has a uuid, pass it back to the add

        $preview = false;

        $article = $this->Articles->get($id, [
            'contain' => ['Tags']
        ]);

        unset($article->id);
        unset($article->modified);
        unset($article->modified_by);
        $article->isNew(true);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $redirect = ['action' => 'admin'];

            //If previewing, force this to be an un-published article
            if ($this->request->data['preview']) {
                $this->request->data['active'] = 0;
                $preview = true;
            }

            $article = $this->Articles->patchEntity($article, $this->request->data, ['reference' => $article->reference]);

            if ($this->Articles->save($article, ['publish' => $this->request->data['active']])) {
                $this->Flash->success(__('The article has been saved.'));
                return $this->redirect($preview ? ['controller' => 'Articles', 'action' => 'view', $article->id, '?' => ['preview' => true]] : $redirect);
            } else {
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
            }
        }
        $tags = $this->Articles->Tags->find('list', ['limit' => 200]);
        $sections = $this->Articles->Sections->find('list', ['limit' => 200]);
        $this->set(compact('article', 'tags', 'sections'));
        $this->set('_serialize', ['article']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article has been deleted.'));
        } else {
            $this->Flash->error(__('The article could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'admin']);
    }

    public function admin() {
        $this->viewBuilder()->layout('admin');

        $article = $this->Articles->find('all');

        $articles = $this->Articles->find('all')
                ->where(function ($exp, $q) use ($article) {
                    return $exp->in('Articles.id', $this->Articles->find()->select([
                                        'id' => $article->func()->max('id'),
                                    ])
                                    ->distinct(['Articles.reference'])
                    );
                })
                ->contain(['Creators']);

        $articles = $this->paginate($articles);

        $this->set('articles', $articles);
        $this->set('_serialize', ['articles']);
    }

    public function imageUpload() {
        $this->viewBuilder()->layout(false);

        //Check if image has been uploaded
        if (!empty($this->request->data['upload']['name'])) {

            $v = $this->Articles->validator('image');
            if (!$v->errors($this->request->data)) {
                $file = $this->request->data['upload'];
                $fileName = time();

                $upload = WWW_ROOT . 'uploads/' . $fileName;
                $uploadPath = Configure::read('Environment.base') . "uploads/" . $fileName;

                move_uploaded_file($file['tmp_name'], $upload);

                $this->set('url', $uploadPath);
                $this->set('func', $this->request->query['CKEditorFuncNum']);
                $this->set('message', '');
            } else {
                $this->set('url', false);
                $this->set('func', $this->request->query['CKEditorFuncNum']);
                $this->set('message', 'The image could not be uploaded.  Please ensure it is of type jpg, png or gif and is no larger than 500kb');
            }
        }
    }

}
