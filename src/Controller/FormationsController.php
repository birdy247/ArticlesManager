<?php
namespace ArticlesManager\Controller;

use ArticlesManager\Controller\AppController;

/**
 * Formations Controller
 *
 * @property \ArticlesManager\Model\Table\FormationsTable $Formations
 */
class FormationsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('formations', $this->paginate($this->Formations));
        $this->set('_serialize', ['formations']);
    }

    /**
     * View method
     *
     * @param string|null $id Formation id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $formation = $this->Formations->get($id, [
            'contain' => ['Sections']
        ]);
        $this->set('formation', $formation);
        $this->set('_serialize', ['formation']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $formation = $this->Formations->newEntity();
        if ($this->request->is('post')) {
            $formation = $this->Formations->patchEntity($formation, $this->request->data);
            if ($this->Formations->save($formation)) {
                $this->Flash->success(__('The formation has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The formation could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('formation'));
        $this->set('_serialize', ['formation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Formation id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $formation = $this->Formations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formation = $this->Formations->patchEntity($formation, $this->request->data);
            if ($this->Formations->save($formation)) {
                $this->Flash->success(__('The formation has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The formation could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('formation'));
        $this->set('_serialize', ['formation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Formation id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $formation = $this->Formations->get($id);
        if ($this->Formations->delete($formation)) {
            $this->Flash->success(__('The formation has been deleted.'));
        } else {
            $this->Flash->error(__('The formation could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
