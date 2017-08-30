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
     * @param null|string $label
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
    function destroy(bool $remove_session_cookie = true)
    {
        return $this->session->destroy($remove_session_cookie);
    }

    /**
     * @param null|string $id
     * @return string
     */
    function id(string $id = null)
    {
        return $this->session->id($id);
    }

    /**
     * @return string
     */
    function label()
    {
        return $this->label;
    }

    /**
     * @param null|string $name
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
    function start(array $options = [])
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
    function status()
    {
        return $this->session->status();
    }

    /**
     * @param array|string $name
     * @param mixed $value
     * @return self|mixed
     */
    function with($name, $value = null)
    {
        $this->set($name, $value);
        return $this;
    }

    /**
     * @param array|string $name
     * @return self|mixed
     */
    function without($name)
    {
        $this->remove($name);
        return $this;
    }
}
