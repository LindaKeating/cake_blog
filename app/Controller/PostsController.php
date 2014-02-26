<?php

class PostsController extends AppController {

    public $helpers = array('Html', 'Form');
	
	public function index() {
		//finding all the records in the Post table and handing the response to the index.ctp view //
        $this->set('posts', $this->Post->find('all'));
    }
	
	
	public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('post', $post);
    }
    
	
	// This function will allow us to add to the posts database //
    public function add() {
		//Checking if this is a HTTP post request //
        if ($this->request->is('post')) {
			//initialising the Post Model //
            $this->Post->create();
			//handing the request object data to be saved by the Post model //
            if ($this->Post->save($this->request->data)) {
				//flashing a success message //
                $this->Session->setFlash(__('Your post has been saved.'));
				//redirecting the the Posts index action //
                return $this->redirect(array('action' => 'index'));
            }
			//flash a message saying we weren't able to do it //
            $this->Session->setFlash(__('Unable to add your post.'));
        }
    }

	// function will allow us to edit an existing post //
	public function edit($id = null) {
    if (!$id) {
        throw new NotFoundException(__('Invalid post'));
    }

    $post = $this->Post->findById($id);
    if (!$post) {
        throw new NotFoundException(__('Invalid post'));
    }
	
    if ($this->request->is(array('post', 'put'))) {
       
	   $this->Post->id = $id;
        if ($this->Post->save($this->request->data)) {
            $this->Session->setFlash(__('Your post has been updated.'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Unable to update your post.'));
    }

    if (!$this->request->data) {
        $this->request->data = $post;
    }
}
	
	
	public function delete($id) {
    if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    }

    if ($this->Post->delete($id)) {
        $this->Session->setFlash(
            __('The post with id: %s has been deleted.', h($id))
        );
        return $this->redirect(array('action' => 'index'));
    }
}
}

?>