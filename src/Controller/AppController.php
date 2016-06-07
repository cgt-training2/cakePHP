<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Cache\Cache;
use Cake\ORM\TableRegistry;

// namespace App\Network\Session;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */

    // public $components = array(

    //     'DebugKit.Toolbar',

    //     'Session'

    //     );
   
    // public $components = [
    //     'Auth' => [
    //         'loginRedirect' => [
    //             'controller' => 'Postsupdate',
    //             'action' => 'index'
    //         ],
    //         'logoutRedirect' => [
    //             'controller' => 'Users',
    //             'action' => 'login',
    //         ]
    //     ]
    // ];

   // public $components = array('Session');

    // if(isset($this->request->prefix) && ($this->request->prefix == 'admin')){
    //         if($this->Auth->loggedIn()){
    //             $this->Auth->allow();
    //             $this->layout = 'admin';
    //         }else{
    //             $this->Auth->deny();
    //             $this->layout = 'front';
    //         }
    //     }else{
    //         $this->Auth->allow();
    //         $this->layout = 'front';
    //     }


    public function initialize() {

        $this->loadComponent('Flash');

        $user = $this->request->session()->read('Auth.User.role');

        if(isset($this->request->prefix) && ($this->request->prefix == 'admin')){

        // if($user == 'admin'){
    
                    $this->loadComponent('Auth', [   

                        'authorize' => 'Controller',  

                        'loginRedirect' => [
                        'controller' => 'Postsupdate',
                        'action' => 'dashboard',
                        'prefix' => 'admin',
                        // 'prefix' => false,
                        ],

                        'logoutRedirect' => [
                        'controller' => 'Users',
                        'action' => 'login',
                        'prefix' => false,
                            
                        ],

                        'authenticate' => [
                            'Form' => [
                                'fields' => ['username' => 'username', 'password' => 'password']
                            ]

                        ],
                        
                    ]);
        }else{


                     $this->loadComponent('Auth', [ 

                        // 'authorize' => 'Controller',

                        'loginRedirect' => [
                        'controller' => 'Postsupdate',
                        'action' => 'home',
                        // 'prefix' => 'admin',
                        'prefix' => false,
                        ],

                        'logoutRedirect' => [
                        'controller' => 'Users',
                        'action' => 'login',
                        'prefix' => false,
                            

                        ],

                        'authenticate' => [
                            'Form' => [
                                'fields' => ['username' => 'username', 'password' => 'password']
                            ]

                        ],
                        
                    ]);

        }            
    }

    /**
     * Before render callback.
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */

    public function beforeRender(Event $event) {

        if (!array_key_exists('_serialize', $this->viewVars) && in_array($this->response->type(), ['application/json', 'application/xml'])) {

            $this->set('_serialize', true);
            
        }

    }

    public function beforeFilter(Event $event) {

        $this->Auth->allow(['view', 'login']);

        $this->Auth->autoRedirect = false;

        // $this->Auth->allow(['add', 'logout']);
        // $this->Auth->config('authenticate', ['Form'=>['username'=>'username','password'=>'password']]);

    }

    public function isAuthorized($user = null) {

        // Any registered user can access public functions

        if (empty($this->request->params['prefix'])) {

            $this->Flash->error(__('You are Not authorized to access this page'));

            return $this->redirect('/',
                
                ['controller' => 'Postsupdate', 'action' => 'home']
            );

        }

        // Only admins can access admin functions
        if ($this->request->params['prefix'] === 'admin') {

            return (bool)($user['role'] === 'admin');

        }

        // if ($this->request->params['prefix'] === 'admin') {

        //     return (bool)($user['role'] === 'admin');

        // }

        // Default deny
        return false;
    }

    // public function beforeFilter() {

    //     if(in_array($this->params['controller'],array('rest_phones'))){

    //         // For RESTful web service requests, we check the name of our contoller

    //         $this->Auth->allow();

    //         // this line should always be there to ensure that all rest calls are secure
    //         /* $this->Security->requireSecure(); */

    //         $this->Security->unlockedActions = array('edit','delete','add','view');
            
    //     }else{

    //         // setup out Auth
            
    //         $this->Auth->allow();           

    //     }
    // }

}
