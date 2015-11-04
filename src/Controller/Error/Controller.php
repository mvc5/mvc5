<?php
/**
 *
 */

namespace Mvc5\Controller\Error;

use Mvc5\Response\Response;
use Mvc5\View\ViewModel;

class Controller
    implements Error
{
    /**
     *
     */
    use ViewModel;

    /**
     * @param Response $response
     * @return ErrorModel
     */
    public function __invoke(Response $response)
    {
        $response->setStatus(404);

        return $this->model();
    }
}
