<?php
/**
 *
 */

namespace Mvc5\Response;

use Mvc5\Http\Response as HttpResponse;
use Mvc5\Signal;

class Send
{
    /**
     *
     */
    use Signal;

    /**
     * @param HttpResponse $response
     * @return void
     */
    protected function headers(HttpResponse $response)
    {
        if (headers_sent()) {
            return;
        }

        foreach($response->headers() as $name => $header) {
            header($name . ': ' . (is_array($header) ? implode(', ', $header) : $header));
        }

        if ($response instanceof Response) {
            foreach($response->cookies() as $cookie) {
                $this->signal('setcookie', array_values($cookie));
            }
        }

        $statusLine = sprintf('HTTP/%s %s %s', $response->version(), $response->status(), $response->reason());

        header($statusLine, true, $response->status());
    }

    /**
     * @param HttpResponse $response
     * @return null
     */
    protected function send(HttpResponse $response)
    {
        $this->headers($response);

        echo $response->body();
    }

    /**
     * @param HttpResponse $response
     */
    function __invoke(HttpResponse $response)
    {
        $this->send($response);
    }
}
