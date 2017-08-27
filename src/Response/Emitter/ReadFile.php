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
     * @var null|resource
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
     * @param null|resource $context
     */
    function __construct(string $filename, bool $use_include_path = false, resource $context = null)
    {
        $this->context        = $context;
        $this->filename       = $filename;
        $this->useIncludePath = $use_include_path;
    }

    /**
     * @return int
     */
    function emit()
    {
        return readfile($this->filename, $this->useIncludePath, $this->context);
    }
}
