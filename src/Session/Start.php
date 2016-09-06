<?php
/**
 *
 */

namespace Mvc5\Session;

class Start
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @param array $options
     */
    function __construct($options = [])
    {
        $this->options = $options;
    }

    /**
     *
     */
    function __invoke()
    {
        if (session_id()) {
            return true;
        }

        $cookie_params = [];

        foreach(session_get_cookie_params() as $key => $value) {
            $cookie_params['cookie_' . $key] = $value;
        }

        $options = $this->options + $cookie_params;

        return session_start($options);
    }
}
