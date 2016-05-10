<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\Network\Exception\InternalErrorException;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Text;
use Cake\Utility\Security;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

     public function initialize()
    {
        $this->loadModel('Users');
        parent::initialize();   
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
         $users = $this->Users->find('all');
        $this->set([
            'users' => $users,
            '_serialize' => ['users']
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
     * Login method  API URL  /api/users/login method: GET
     * @return json response
     */
    public function login()
    {
        try {                                    
            if(!isset($this->request->query['username'])){
                throw new UnauthorizedException("Please enter your username");                
            }
             if(!isset($this->request->query['password'])){
                throw new UnauthorizedException("Please enter your password");                
            }
            $username  = $this->request->query['username'];
            $password  = $this->request->query['password'];
            
            // Check for user credentials 
            $user = $this->Users->find('login', ['email'=>$username, 'api_key_plain'=>$password]);
            //$user = $this->Auth->identify();
            if(!$user) {
               throw new UnauthorizedException("Invalid login");     
            }
              
              
              // if everything is OK set Auth session with user data
              $this->Auth->setUser($user->toArray());
              
              // Generate user Auth token
              $token =  Security::hash($user->id.$user->username, 'sha1', true);
              // Add user token into Auth session
              $this->request->session()->write('Auth.User.token', $token);
           
              // return Auth token
              $this->response->header('Authorization', 'Bearer ' . $token);
              
                            
                
        } catch (UnauthorizedException $e) {            
            throw new UnauthorizedException($e->getMessage(),401);   
        }           
        
        $authUserid = $this->Auth->user('id');
        $this->set('user', ['id' => $authUserid,'token' => $token]);        
        $this->set('_serialize', ['user']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
