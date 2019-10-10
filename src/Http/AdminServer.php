<?php

namespace SwoftAdmin\Tool\Http;

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Http\Server\HttpServer;

/**
 * @Bean("adminServer")
 * @package SwoftAdmin\Tool\Http
 */
class AdminServer extends HttpServer
{
    /**
     * @var null|int 0禁用1admin启动2http启动
     */
    public static $enable = null;

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
    protected $pidName = 'admin-http';

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
