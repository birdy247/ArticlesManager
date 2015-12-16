<?php

namespace ArticlesManager\Controller;

use ArticlesManager\Controller\AppController;

/**
 * Occasions Controller
 *
 * @property \ArticlesManager\Model\Table\OccasionsTable $Occasions
 */
class OccasionsController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function admin() {
        $this->viewBuilder()->layout('admin');
        $this->set('occasions', $this->paginate($this->Occasions));
        $this->set('_serialize', ['occasions']);
    }

    /**
     * View method
     *
     * @param string|null $id Occasion id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $occasion = $this->Occasions->get($id, [
            'contain' => []
        ]);
        $this->set('occasion', $occasion);
        $this->set('_serialize', ['occasion']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $this->viewBuilder()->layout('admin');
        $occasion = $this->Occasions->newEntity();
        if ($this->request->is('post')) {
            $occasion = $this->Occasions->patchEntity($occasion, $this->request->data);
            if ($this->Occasions->save($occasion)) {
                $this->Flash->success(__('The occasion has been saved.'));
                return $this->redirect(['action' => 'admin']);
            } else {
                $this->Flash->error(__('The occasion could not be saved. Please, try again.'));
            }
        }

        $articles = $this->Occasions->Articles->getArticlesList(true);

        $this->set(compact('occasion', 'articles'));
        $this->set('_serialize', ['occasion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Occasion id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $this->viewBuilder()->layout('admin');
        $occasion = $this->Occasions->get($id, [
            'contain' => []
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $occasion = $this->Occasions->patchEntity($occasion, $this->request->data);
            if ($this->Occasions->save($occasion)) {
                $this->Flash->success(__('The occasion has been saved.'));
                return $this->redirect(['action' => 'admin']);
            } else {
                $this->Flash->error(__('The occasion could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('occasion'));
        $this->set('_serialize', ['occasion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Occasion id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $occasion = $this->Occasions->get($id);
        if ($this->Occasions->delete($occasion)) {
            $this->Flash->success(__('The occasion has been deleted.'));
        } else {
            $this->Flash->error(__('The occasion could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'admin']);
    }

}
