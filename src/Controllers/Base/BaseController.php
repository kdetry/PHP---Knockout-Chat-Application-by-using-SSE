<?php

namespace Application\Controllers\Base;

use Slim\Views\PhpRenderer;
use Slim\Http\Response;

/**
 * Description of BaseController
 *
 * @author Mustafa Tunçau
 */
class BaseController
{

    protected $renderer;
    protected $response;

    //put your code here

    public function __construct()
    {
        $this->renderer = new PhpRenderer(ROOT . 'templates/');
        $this->response = new Response();
    }

}
