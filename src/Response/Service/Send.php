<?php
/**
 *
 */

namespace Mvc5\Response\Service;

use Mvc5\Arg;
use Mvc5\Cookie\PHPCookies;
use Mvc5\Http\Response;
use Mvc5\Response\Emitter;

use function header;
use function headers_sent;
use function implode;
use function sprintf;

trait Send
{
    /**
     * @param Response $response
     */
    protected function body(Response $response) : void
    {
        $this->emit($response->body());
    }

    /**
     * @param Response $response
     * @return iterable
     */
    protected function cookies(Response $response) : iterable
    {
        return $response[Arg::COOKIES] ?? [];
    }

    /**
     * @param \Closure|Emitter|string $body
     */
    protected function emit($body) : void
    {
        $body instanceof Emitter ? $body->emit() : ($body instanceof \Closure ? $body() : print($body));
    }

    /**
     * @param Response $response
     */
    protected function headers(Response $response) : void
    {
        if (headers_sent()) {
            return;
        }

        foreach($response->headers() as $name => $header) {
            header($name . ': ' . implode(', ', (array) $header));
        }

        foreach($this->cookies($response) as $cookie) {
            PHPCookies::send($cookie);
        }

        $statusLine = sprintf('HTTP/%s %s %s', $response->version(), $response->status(), $response->reason());

        header($statusLine, true, (int) $response->status());
    }

    /**
     * @param Response $response
     * @return Response
     */
    protected function send(Response $response) : Response
    {
        $this->headers($response);
        $this->body($response);
        return $response;
    }

    /**
     * @param Response $response
     * @return Response
     */
    function __invoke(Response $response) : Response
    {
        return $this->send($response);
    }
}
