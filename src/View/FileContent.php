<?php


namespace SwoftAdmin\Tool\View;

/**
 * 文件内容
 * @package SwoftAdmin\Tool\View
 */
class FileContent extends BaseView
{
    public $title = "文件内容显示";
    protected $view = 'file_content';

    /** @var string 文件内容类型 */
    public $layTitle = "PHP";
    public $layContent = "";

    /**
     * 这是内容
     * @param  string  $content
     */
    public function setContent(string $content)
    {
        $this->layContent = $content;
    }
}
