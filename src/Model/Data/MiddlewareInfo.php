<?php


namespace Swoft\SwoftAdmin\Model\Data;


class MiddlewareInfo
{
    private static $zid = 0;

    public function __construct()
    {
        self::$zid++;
        $this->id = self::$zid;
    }

    public $id;
    /** @var string 标题 */
    public $title;
    public $path;
    /** @var bool 全局 */
    public $isGroup = false;
    /** @var bool bean */
    public $bean = false;
}
