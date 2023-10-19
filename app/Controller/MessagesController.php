<?php
class MessagesController extends AppController {
  
	public function index() {
		$this->redirect(array('controller' => 'users', 'action' => 'index'));
	}
	public function new() {
		$this->set('title_for_layout', 'New Message');
		$this->loadModel('User');
		// create
		if ($this->request->is(array('post', 'put'))) {
			
			$receiver_id = is_int((int)$this->request->data['Message']['receiver']) 
				? $this->request->data['Message']['receiver'] 
				: 0;

			$receiver = $this->User->findById($receiver_id);
			if (!$receiver) {
				$this->setFlash('Please provide receiver.', 'error');
			} else {
				$this->Message->create();
				$this->request->data['Message']['user_id'] = $this->Auth->user('id');
				$this->request->data['Message']['receiver_id'] = $receiver_id;

				if ($this->Message->save($this->request->data)) {
					$this->redirect(array('controller' => 'users','action' => 'index'));
				} else {
					$this->setFlash('Message creation failed. Please try again.', 'error');
				}
			}
		}

		$users = $this->User->find('all', array(
			'fields' => array(
				'User.id',
				'User.name',
				'User.photo_url'
			),
			'recursive' => -1
		));
		$this->set('users', $users);
	}

	public function delete($messageId) {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			$this->Message->delete($messageId);
			echo json_encode(array(
				'success' => true
			));
		}
	}
	public function setFlash($text, $type = 'error') {
		$this->Session->setFlash($text, 'default', array(), $type);
	}
}