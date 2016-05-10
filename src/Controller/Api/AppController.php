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
namespace App\Controller\Api;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;

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
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Auth',[
            'authenticate' => [
                'Basic' => ['fields' => ['username' => 'email','password' => 'api_key'],
                'userModel' => 'Users'
                ],
            ],
            'storage' => 'Memory',
            'unauthorizedRedirect' => false
            ]);
    }

    
    
    
    /**
    * Before filter logic
    *
    */
    public function beforeFilter(Event $event)
    {
        $this->user_id = $this->Auth->user('id');
        
        // validate user token for logged user
         if($this->user_id) {
            if(!$this->checkUserToken()) { 
            $this->Auth->logout(); // logout user
            throw new ForbiddenException("Invalid Token!");    // throw an 403 error
            }
        }        
    }
 

    /**
     * Check User Token
     */
    public function checkUserToken() 
    {
            $request_token = $this->getRequestToken();
            
            if (!$request_token) {
               return false;
            }
            
            if ($request_token != $this->userToken()) {               
                return false;
            }
        return true;
    }
    
    /**
     * Get Request token
     */
    public function getRequestToken() 
    {
        
        $headers = $this->getHeaders();
        if (!isset($headers['Authorization'])) return false;
        $token = explode(" ", $headers['Authorization']);       
        return $token[1];
    }
    
    /**
     * Get Request headers
     */
    private function getHeaders() 
    {
        $headers = getallheaders();        
        return $headers;
    }
    
    /**
    * Get User token
    *
    */
    public function userToken()
    {
        //return $this->Auth->user('token');
        return $this->request->session()->read('Auth.User.token');
    }
    
    /**
    * Authorization default true
    */
    public function isAuthorized($user)
    {
        return false;
    }
    
}
