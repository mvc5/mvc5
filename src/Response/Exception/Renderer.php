<?php
/**
 *
 */

namespace Mvc5\Response\Exception;

use Mvc5\Response\Response;
use Mvc5\View\Manager\ManageView;
use Throwable;

class Renderer
    implements Render
{
    /**
     *
     */
    use ManageView;

    /**
     * @param Throwable $exception
     * @param Response $response
     * @return Response
     */
    public function __invoke(Throwable $exception, Response $response)
    {
        $response->setContent($this->exception($exception));
        return $response;
    }
}
