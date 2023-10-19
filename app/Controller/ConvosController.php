<?php

class ConvosController extends AppController {
	public function index($messageId) {
		if (!$messageId) {
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$this->loadModel('Message');
		$message = $this->Message->findById($messageId);
		if (!$message) {
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}

		$convos = $this->Convo->find('all', array(
			'conditions' => array(
				'message_id' => $messageId
			),
			'order' => ['Convo.created ASC'],
			'limit' => 4
		));
		$userId = $message['Message']['user_id'];
		$receiverId = $message['Message']['receiver_id'];
		$messageId = $message['Message']['id'];
		$messageData = array(
			'user_id' => $userId,
			'receiver_id' => $receiverId,
			'message_id' => $messageId
		);
		$this->set(compact('convos', 'messageData'));
	}

	public function reply() {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			$senderId = $this->Auth->user('id');
			$ajaxData = $this->request->data;

			if (empty($ajaxData['reply'])) {
				$this->Session->setFlash('Invalid reply.', 'default', array(), 'error');
			} else {
				$this->Convo->create();
				if (!$this->Convo->save($ajaxData)) {
					$this->Session->setFlash('Something went wrong.', 'default', array(), 'error');
				}
			}
			echo json_encode(array(
				'url' => '/messageboard/convos/index/' // send url to redirect
			));
		}
	}
	public function delete($convoId) {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			$this->Convo->delete($convoId);
			echo json_encode(array(
				'success' => true
			));
		}
	}

	public function showMore () {
		$this->autoRender = false;
		$offset = $this->request->query('offset');
		$messageId = $this->request->query('messageId');
		$convos = $this->Convo->find('all', array(
			'conditions' => array(
				'message_id' => $messageId
			),
			'order' => ['Convo.created ASC'],
			'limit' => 4,
			'offset' => $offset
		));

		echo json_encode($convos);
	}
}