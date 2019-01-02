<?php

namespace Mvc5\Session\Login;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Session\Session;

class Redirect
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @param Session $session
     * @param Response $response
     */
    function __construct(Session $session, Response $response)
    {
        $this->response = $response;
        $this->session = $session;
    }

    /**
     * @param Request $request
     * @return Response
     */
    function __invoke(Request $request) : Response
    {
        $this->session[Arg::REDIRECT_URL] = $request[Arg::URI];

        return $this->response;
    }
}
