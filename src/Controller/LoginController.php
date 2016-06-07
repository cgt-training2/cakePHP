<?php

namespace App\Controller;
use Cake\ORM\TableRegistry;
use Cake\Core\App;
use Cake\Controller\Controller;
  
class LoginController extends AppController {

	public function initialize() {

        parent::initialize();

       // $this->loadComponent('RequestHandler');

        $this->viewBuilder()->layout('frontend');

    }

    public function login(){

    }

    public function search() {

        // $postsupdate = $this->Postsupdate->find('all');

        // $this->set(compact('postsupdate'));
        
        // $this->set('_serialize', array( 'postsupdate' ) );

       // echo $this->Html->link('Add a User', array('controller'=>'Postsupdate', 'action'=>'index'));

    	return $this->redirect([ 

               'controller' => 'Postsupdate',
    		   'action' => 'index'
               
		]);

    }

}