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
     * @return void
     */
    function setContent($content);

    /**
     * @param int $status
     * @return void
     */
    function setStatus($status);
}
