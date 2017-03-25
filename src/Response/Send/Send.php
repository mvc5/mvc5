<?php
/**
 *
 */

namespace Mvc5\Response\Send;

use Mvc5\Arg;
use Mvc5\Http\Response as HttpResponse;
use Mvc5\Response\Emitter;

trait Send
{
    /**
     * @param HttpResponse $response
     */
    protected function body(HttpResponse $response)
    {
        $this->emit($response->body());
    }

    /**
     * @param HttpResponse $response
     * @return array|mixed
     */
    protected function cookies(HttpResponse $response)
    {
        return $response[Arg::COOKIES] ?? [];
    }

    /**
     * @param \Closure|Emitter|string $body
     */
    protected function emit($body)
    {
        $body instanceof Emitter ? $body->emit() : ($body instanceof \Closure ? $body() : print($body));
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

        foreach($this->cookies($response) as $cookie) {
            setcookie(...array_values($cookie));
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
