<?php

namespace ArticlesManager\Controller;

use ArticlesManager\Controller\AppController;
use Cake\Event\Event;

/**
 * Sections Controller
 *
 * @property \ArticlesManager\Model\Table\SectionsTable $Sections
 */
class SectionsController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->deny();
    }

    public function admin() {
        $this->viewBuilder()->layout('admin');
        $this->set('sections', $this->paginate($this->Sections));
        $this->set('_serialize', ['sections']);
    }

    /**
     * View method
     *
     * @param string|null $id Section id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $section = $this->Sections->get($id, [
            'contain' => ['Formations']
        ]);
        $this->set('section', $section);
        $this->set('_serialize', ['section']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $this->viewBuilder()->layout('admin');
        $section = $this->Sections->newEntity();
        if ($this->request->is('post')) {
            $section = $this->Sections->patchEntity($section, $this->request->data);
            if ($this->Sections->save($section)) {
                $this->Flash->success(__('The section has been saved.'));
                return $this->redirect(['action' => 'admin']);
            } else {
                $this->Flash->error(__('The section could not be saved. Please, try again.'));
            }
        }
        $formations = $this->Sections->Formations->find('list', ['limit' => 200]);
        $this->set(compact('section', 'formations'));
        $this->set('_serialize', ['section']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Section id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $this->viewBuilder()->layout('admin');
        $section = $this->Sections->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $section = $this->Sections->patchEntity($section, $this->request->data);
            if ($this->Sections->save($section)) {
                $this->Flash->success(__('The section has been saved.'));
                return $this->redirect(['action' => 'admin']);
            } else {
                $this->Flash->error(__('The section could not be saved. Please, try again.'));
            }
        }
        $formations = $this->Sections->Formations->find('list', ['limit' => 200]);
        $this->set(compact('section', 'formations'));
        $this->set('_serialize', ['section']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Section id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $section = $this->Sections->get($id);
        if ($this->Sections->delete($section)) {
            $this->Flash->success(__('The section has been deleted.'));
        } else {
            $this->Flash->error(__('Sections with associated content cannot be delete.  Please first remove any content within this section.'));
        }
        return $this->redirect(['action' => 'admin']);
    }

}
