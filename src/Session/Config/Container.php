<?php
/**
 *
 */

namespace Mvc5\Session\Config;

use Mvc5\Config\Model;
use Mvc5\Session\Model as SessionModel;
use Mvc5\Session\Session;

trait Container
{
    /**
     * @var Model
     */
    protected Model $config;

    /**
     * @var string
     */
    protected string $label;

    /**
     * @var Session
     */
    protected Session $session;

    /**
     * @param Session $session
     * @param string|null $label
     */
    function __construct(Session $session, string $label = null)
    {
        $this->label = $label ?? Model::class;
        $this->session = $session;
    }

    /**
     *
     */
    function clear() : void
    {
        $this->resetSessionModel();
    }

    /**
     *
     */
    function close() : void
    {
        $this->session->close();
    }

    /**
     * @param bool|true $remove_session_cookie
     * @return bool
     */
    function destroy(bool $remove_session_cookie = true) : bool
    {
        return $this->session->destroy($remove_session_cookie);
    }

    /**
     * @param string|null $id
     * @return string
     */
    function id(string $id = null) : string
    {
        return $this->session->id($id);
    }

    /**
     * @return string
     */
    function label() : string
    {
        return $this->label;
    }

    /**
     * @param string|null $name
     * @return string
     */
    function name(string $name = null) : string
    {
        return $this->session->name($name);
    }

    /**
     * @param bool|false $delete_old_session
     * @return bool
     */
    function regenerate(bool $delete_old_session = false) : bool
    {
        return $this->session->regenerate($delete_old_session);
    }

    /**
     *
     */
    protected function resetSessionModel() : void
    {
        $this->session[$this->label] = $this->config = new SessionModel;
    }

    /**
     * @param array $options
     * @return bool
     */
    function start(array $options = []) : bool
    {
        if (!$this->session->start($options)) {
            return false;
        }

        !isset($this->session[$this->label])
            ? $this->resetSessionModel() : $this->config = $this->session[$this->label];

        return true;
    }

    /**
     * @return int
     */
    function status() : int
    {
        return $this->session->status();
    }

    /**
     * @param array|string $name
     * @param mixed $value
     * @return Session|mixed
     */
    function with($name, $value = null) : Session
    {
        $this->set($name, $value);
        return $this;
    }

    /**
     * @param array|string $name
     * @return Session|mixed
     */
    function without($name) : Session
    {
        $this->remove($name);
        return $this;
    }
}
