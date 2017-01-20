<?php

namespace ArticlesManager\Controller;

use ArticlesManager\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\Collection\Collection;

/**
 * Articles Controller
 *
 * @property \ArticlesManager\Model\Table\ArticlesTable $Articles
 */
class ArticlesController extends AppController
{

    public $paginate = [
        'limit' => 20,
    ];

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->deny(['add', 'edit', 'delete', 'admin', 'imageUpload']);
    }

    public function isAuthorized($user)
    {
        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index($sectionId = null, $tagId = false)
    {
        //$this->viewBuilder()->layout('news');

        if (!$sectionId) {
            throw new NotFoundException('Could not find section');
        }

        $section = $this->Articles->Sections->get($sectionId, [
            'contain' => ['Formations']
        ]);

        $extension = "Common/" . $section->formation->directory . "_index";

        $articles = $this->Articles
            ->find('active')
            ->contain(['Creators', 'ArticleImages']);

        if ($sectionId) {
            $articles->find('section', ['section_id' => $sectionId]);
        }

        if ($tagId) {
            $articles->matching('Tags', function ($q) use ($tagId) {
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
    public function view($slug = null, $id = null)
    {

        if (!$slug) {
            throw new NotFoundException('Could not find content');
        }

        $preview = false;

        if ($this->Auth->user()) {
            $preview = true;
        }

        //$this->viewBuilder()->layout('news');

        $article = $this->Articles->find();
        if ($id) {
            $article->where(['Articles.id' => $id]);
        } else {
            $article->find('slug', ['slug' => $slug])->find('active');
        }
        $article = $article
            ->contain(['Tags'])
            ->contain(['Additions'])
            ->contain(['ArticleImages'])
            ->contain(['Sections.Formations'])
            ->contain(['Creators'])
            ->firstOrFail();

        $additions = (new Collection($article->additions))->combine(
            'name',
            function ($entity) {
                return $entity;
            }
        )->toArray();

        $article->additions = $additions;

        $extension = "Common/" . $article->section->formation->directory . "_view";

        $articles = $this->Articles->find('list')->where(['Articles.id <>' => $article->id])->contain(['ArticleImages'])->limit(5)->order(['Articles.created DESC']);

        $this->set(compact('article', 'articles', 'extension', 'preview'));
        $this->set('_serialize', ['article']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($sectionId = null)
    {
        $this->viewBuilder()->layout('admin');

        $preview = false;

        $article = $this->Articles->newEntity([
            'section_id' => $sectionId
        ], [
            'validate' => false
        ]);

        if ($this->request->is('post')) {

            $article = $this->Articles->patchEntity($article, $this->request->data, ['reference' => false, 'associated' => [
                'ArticleImages', 'Additions', 'Tags'
            ]]);

            //Pass in an option of publish.  If this is set to true, then unpublish all other versions of this article
            if ($this->Articles->save($article, ['publish' => $this->request->data['active'], 'associated' => [
                'ArticleImages', 'Additions', 'Tags'
            ]])
            ) {
                $this->Flash->success(__('The article has been saved.'));
                return $this->redirect(['controller' => 'Articles', 'action' => 'view', $article->slug, $article->id, '?' => ['preview' => true]]);
            } else {

                $this->Flash->error(__('The article could not be saved. Please, try again.'));
            }
        }

        $tags = $this->Articles->Tags->find('list', ['limit' => 200]);
        $section = $this->Articles->Sections->get($sectionId, [
            'contain' => [
                'Additions'
            ]
        ]);
        $this->set(compact('article', 'tags', 'section'));
        $this->set('_serialize', ['article']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->layout('admin');

//If this has a uuid, pass it back to the add

        $preview = false;

        $article = $this->Articles->get($id, [
            'contain' => ['Tags', 'Sections.Additions', 'Additions', 'ArticleImages']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $redirect = ['action' => 'admin'];

            //If previewing, force this to be an un-published article
            if ($this->request->data['preview']) {
                $preview = true;
            }

            $article = $this->Articles->patchEntity($article, $this->request->data, ['associated' => [
                'Additions', 'ArticleImages', 'Tags'
            ]]);

            if ($this->Articles->save($article, ['publish' => $this->request->data['active'], 'associated' => [
                'Additions', 'ArticleImages', 'Tags'
            ]])
            ) {
                $this->Flash->success(__('The article has been saved.'));
                return $this->redirect($preview ? ['controller' => 'Articles', 'action' => 'view', $article->slug, $article->id, '?' => ['preview' => true]] : $redirect);
            } else {
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
            }
        }

        $tags = $this->Articles->Tags->find('list', ['limit' => 200]);

        $this->set(compact('article', 'tags', 'sections', 'articles'));
        $this->set('_serialize', ['article']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article has been deleted.'));
        } else {
            $this->Flash->error(__('The article could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'admin']);
    }

    public function admin()
    {
        $this->viewBuilder()->layout('admin');

        $articles = $this->Articles->find('all')->contain(['Creators']);

        $articles = $this->paginate($articles);

        $this->set('articles', $articles);
        $this->set('_serialize', ['articles']);
    }

    public function imageUpload()
    {
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
