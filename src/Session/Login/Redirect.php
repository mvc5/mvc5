<?php

namespace Mvc5\Session\Login;

use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Session\Session;

use const Mvc5\{ REDIRECT_URL, URI };

class Redirect
{
    /**
     * @var Response
     */
    protected Response $response;

    /**
     * @var Session
     */
    protected Session $session;

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
        $this->session[REDIRECT_URL] = $request[URI];

        return $this->response;
    }
}
