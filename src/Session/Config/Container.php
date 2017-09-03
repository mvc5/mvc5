<?php
/**
 *
 */

namespace Mvc5\Session\Config;

use Mvc5\Session\Model;
use Mvc5\Session\Session;

trait Container
{
    /**
     * @var Model
     */
    protected $config;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var Session
     */
    protected $session;

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
    function clear()
    {
        $this->resetSessionModel();
    }

    /**
     *
     */
    function close()
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
    function id(string $id = null)
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
    function name(string $name = null)
    {
        return $this->session->name($name);
    }

    /**
     * @param bool|false $delete_old_session
     */
    function regenerate(bool $delete_old_session = false)
    {
        $this->session->regenerate($delete_old_session);
    }

    /**
     *
     */
    protected function resetSessionModel()
    {
        $this->session[$this->label] = $this->config = new Model;
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
     * @return Session|self|mixed
     */
    function with($name, $value = null) : Session
    {
        $this->set($name, $value);
        return $this;
    }

    /**
     * @param array|string $name
     * @return Session|self|mixed
     */
    function without($name) : Session
    {
        $this->remove($name);
        return $this;
    }
}
