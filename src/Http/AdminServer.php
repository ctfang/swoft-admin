<?php


class AdminServer extends \Swoft\Http\Server\HttpServer
{
    /**
     * Server type
     *
     * @var string
     */
    protected static $serverType = 'HTTP';

    /**
     * Default http port
     *
     * @var int
     */
    protected $port = 18306;

    /**
     * @var string
     */
    protected $pidName = 'swoft-http';

    /**
     * Pid file
     *
     * @var string
     */
    protected $pidFile = '@runtime/admin.pid';

    /**
     * @var string
     */
    protected $commandFile = '@runtime/admin.command';
}
