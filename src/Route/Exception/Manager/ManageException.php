<?php
/**
 *
 */

namespace Mvc5\Route\Exception\Manager;

use Mvc5\Route\Route;
use Mvc5\View\Model\ViewModel;
use Throwable;

trait ManageException
{
    /**
     * @var ExceptionManager
     */
    protected $em;

    /**
     * @param Route $route
     * @param Throwable $exception
     * @return ViewModel
     */
    public function exception(Route $route, Throwable $exception)
    {
        return $this->em->exception($route, $exception);
    }

    /**
     * @param ExceptionManager $em
     */
    public function setExceptionManager(ExceptionManager $em)
    {
        $this->em = $em;
    }
}
