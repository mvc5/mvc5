<?php
/**
 *
 */

namespace Mvc5\Mvc;

use Mvc5\Plugin;
use Mvc5\Response\Sender;
use Throwable;

class Response
{
    /**
     *
     */
    use Plugin;
    use Sender;

    /**
     * @param mixed $response
     * @return mixed
     */
    public function __invoke($response)
    {
        try {

            return $this->send($response);

        } catch (Throwable $exception) {

            return $this->send($this->exception($exception, $response));

        }
    }
}
