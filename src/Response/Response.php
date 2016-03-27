<?php
/**
 *
 */

namespace Mvc5\Response;

interface Response
{
    /**
     * @return callable|mixed|null|string|object
     */
    function content();

    /**
     * @return void
     */
    function send();

    /**
     * @param  mixed $content
     * @return self
     */
    function setContent($content);

    /**
     * @param int $status
     * @return self
     */
    function setStatus($status);

    /**
     * @return int
     */
    function status();
}
