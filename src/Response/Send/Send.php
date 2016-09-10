<?php
/**
 *
 */

namespace Mvc5\Response\Send;

use Mvc5\Arg;
use Mvc5\Http\Response as HttpResponse;
use Mvc5\Response\Response;
use Mvc5\Signal;

trait Send
{
    /**
     *
     */
    use Signal;

    /**
     * @param HttpResponse $response
     */
    protected function body(HttpResponse $response)
    {
        echo $response->body();
    }

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
                $this->signal(Arg::SET_COOKIE, array_values($cookie));
            }
        }

        $statusLine = sprintf('HTTP/%s %s %s', $response->version(), $response->status(), $response->reason());

        header($statusLine, true, $response->status());
    }

    /**
     * @param HttpResponse $response
     * @return HttpResponse
     */
    protected function send(HttpResponse $response)
    {
        $this->headers($response);
        $this->body($response);
        return $response;
    }

    /**
     * @param HttpResponse $response
     * @return HttpResponse
     */
    function __invoke(HttpResponse $response)
    {
        return $this->send($response);
    }
}
