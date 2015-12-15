<?php
/**
 *
 */

namespace Mvc5;

use Throwable;

class Web
{
    /**
     * @var App
     */
    protected $app;

    /**
     * @param array|\ArrayAccess|Config\Configuration $config
     */
    public function __construct($config = null)
    {
        $this->app = new App($config);
    }

    /**
     * @return callable|mixed|null|object
     */
    public function __invoke()
    {
        try {

            return $this->app->call(Arg::WEB);

        } catch(Throwable $exception) {

            return $this->app->call(Arg::RESPONSE_EXCEPTION, [Arg::EXCEPTION => $exception]);
        }
    }
}
