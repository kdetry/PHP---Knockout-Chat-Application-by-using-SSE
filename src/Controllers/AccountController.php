<?php

namespace Application\Controllers;

use Application\Models\Avatar;
use Application\Models\Account;
use Slim\Http\Request;
use Sse\SSE;

class AccountController extends Base\BaseController
{

    private $account;

    public function __construct()
    {
        parent::__construct();
        $this->account = new Account();
    }

    /**
     * All of Avatars
     * @return Json
     */
    public function getAvatarList()
    {
        $avatar = new Avatar;
        return $this->response->withJson($avatar->getAvatarList());
    }

    /**
     * Save User by Ajax
     * @param Request $request
     * @return Json
     */
    public function saveUser(Request $request)
    {
        $data = $request->getParsedBody();
        return $this->response->withJson(array('status' => $this->account->saveUser($data)), 201);
    }

    /**
     * Get Active Users
     * @return Json
     */
    public function getActiveUserList() {
        
        $sse = new SSE;
        $sse->exec_limit = 1; //the execution time of the loop in seconds. Default: 600. Set to 0 to allow the script to run as long as possible.
        $sse->sleep_time = 1; //The time to sleep after the data has been sent in seconds. Default: 0.5.
        $sse->client_reconnect = 1; //the time for the client to reconnect after the connection has lost in seconds. Default: 1.
        $sse->use_chunked_encodung = false; //Use chunked encoding. Some server may get problems with this and it defaults to false
        $sse->keep_alive_time = 600; //The interval of sending a signal to keep the connection alive. Default: 300 seconds.
        $sse->allow_cors = true; //Allow cross-domain access? Default: false. If you want others to access this must set to true.
        $sse->addEventListener('userlist', new \Application\Models\ActiveUsersEvent()); //register your event handler
        $sse->start(); //start the event loop
    }
    
    /**
     * 

    public function getModelDebug()
    {
        print_r($this->account->getActiveUserList());
    }     */
    
}
