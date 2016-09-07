<?php
/**
 *
 */

namespace Mvc5\Session;

class Start
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @param Session $session
     */
    function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param Session $session
     * @return bool
     */
    protected function active(Session $session)
    {
        return PHP_SESSION_ACTIVE === $session->status();
    }

    /**
     * @param Session $session
     * @return Session
     */
    protected function register(Session $session)
    {
        $session instanceof SessionContainer
            && $session->register();

        return $session;
    }

    /**
     * @param Session $session
     * @param array $options
     * @return Session
     */
    protected function start(Session $session, array $options = [])
    {
        $session->start($options);

        return $session;
    }

    /**
     * @param array $options
     * @return Session
     */
    function __invoke(array $options = [])
    {
        return $this->active($this->session) ? $this->register($this->session) : $this->start($this->session, $options);
    }
}
