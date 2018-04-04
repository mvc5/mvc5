<?php
/**
 *
 */
namespace Mvc5\Response\Emitter;

use Mvc5\Response\Emitter;

class ReadFile
    implements Emitter
{
    /**
     * @var resource|null
     */
    protected $context;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var bool|false
     */
    protected $useIncludePath;

    /**
     * @param string $filename
     * @param bool|false $use_include_path
     * @param resource|null $context
     */
    function __construct(string $filename, bool $use_include_path = false, resource $context = null)
    {
        $this->context        = $context;
        $this->filename       = $filename;
        $this->useIncludePath = $use_include_path;
    }

    /**
     *
     */
    function emit() : void
    {
        readfile($this->filename, $this->useIncludePath, $this->context);
    }
}
