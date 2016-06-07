<?php

namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;

use Cake\Cache\Cache;

class UsersController extends AppController {


  // initializes the controller.

  public function initialize() {

    parent::initialize();

    $this->viewBuilder()->layout('frontendflook');

  }

  // called before every action.

  public function beforeFilter(Event $event) {

    parent::beforeFilter($event);

    // Allow users to register and logout.
    // pr($this->Session->read('Auth'));

    $this->Auth->allow(['add', 'logout','login']);
    

  }

  public function index() {

    $this->set('users', $this->Users->find('all'));

  }


  public function view($id) {

    $user = $this->Users->get($id);
    $this->set(compact('user'));

  }


/*                                                       Older Login                                                                    */


  // Login action contains the code related to the login.

  public function login() {

    // if user not logged out then redirect him/her to the last visited page.
         
    if ($this->Auth->User('id') > 0) {

      $this->redirect($this->Auth->redirectUrl());

    }

    $this->loadModel('Users');

    $user = $this->Users->newEntity();
          
    if ($this->request->is('POST')) {

      $data = $this->Users->newEntity($this->request->data());
      $user = $this->Auth->identify();
                
      // echo '<pre>';
      //    print_r($user['role']);
      // exit;

      if ($user['role'] == 'author') {

        $this->Auth->setUser($user);

        return $this->redirect($this->Auth->redirectUrl());

      } else{

            $this->Flash->error(__('you are not authorized'));

      }

        $this->Flash->error(__('Incorrect UserName or PassWord'));
              
    }

      $this->set('user', $user);
          
  }
      

  // LogOut action contains the code related to the logOut.

  public function logout() {

    $this->Flash->success('You are now logged out.');

    return $this->redirect($this->Auth->logout());

  }

  // add action used to add a new user to the users table.

  public function add() {

    $user = $this->Users->newEntity();

    if ($this->request->is('post')) {

      $user = $this->Users->patchEntity($user, $this->request->data);

        if ($this->Users->save($user)) {

          $this->Flash->success(__('The user has been saved.'));

          return $this->redirect(['action' => 'add']);

        }

      $this->Flash->error(__('Unable to add the user.'));

    }

    $this->set('user', $user);

  }

}