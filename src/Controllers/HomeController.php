<?php

namespace Application\Controllers;

use Application\Models\Chat;
use Sse\SSE;
use Slim\Http\Request;

/**
 * Description of HomeContoller
 *
 * @author Mustafa Tunçau
 */
class HomeController extends Base\BaseController
{

    private $chat;

    public function __construct()
    {
        parent::__construct();
        $this->chat = new Chat;
    }

    /**
     * 
     * @return Slim\Views\PhpRenderer
     */
    public function index()
    {
        return $this->renderer->render($this->response, "chatClient.php");
    }

    /**
     * getChatList Method returns Last 15 Chats as JSON
     * @return string
     */
    public function getChatList()
    {
        $sse = new SSE;
        $sse->exec_limit = 0.5; //the execution time of the loop in seconds. Default: 600. Set to 0 to allow the script to run as long as possible.
        $sse->sleep_time = 0.5; //The time to sleep after the data has been sent in seconds. Default: 0.5.
        $sse->client_reconnect = 0.5; //the time for the client to reconnect after the connection has lost in seconds. Default: 1.
        $sse->use_chunked_encodung = false; //Use chunked encoding. Some server may get problems with this and it defaults to false
        $sse->keep_alive_time = 600; //The interval of sending a signal to keep the connection alive. Default: 300 seconds.
        $sse->allow_cors = true; //Allow cross-domain access? Default: false. If you want others to access this must set to true.
        $sse->addEventListener('message', new \Application\Models\MessageEvent()); //register your event handler
        $sse->start(); //start the event loop
    }

    /**
     * 
     * @param Request $request
     * @return Slim\Http\Response
     */
    public function messageSend(Request $request)
    {
        $data = $request->getParsedBody();
        return $this->response->withJson(array('status' => $this->chat->messageSend($data)), 201);
    }
    
    /**
     * 
     * @param Request $request
     */
    public function saveActivity(Request $request)
    {
        $data = $request->getParsedBody();
        $this->chat->saveActivity($data['senderId']);
        
    }

}
