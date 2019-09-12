<?php


namespace Swoft\SwoftAdmin;


use Swoft\Helper\ComposerJSON;
use Swoft\SwoftAdmin\Exec\Exec;
use Swoft\SwoftComponent;

class AutoLoader extends SwoftComponent
{
    /**
     * @return bool
     */
    public function enable(): bool
    {
        return true;
    }

    /**
     * Get namespace and dir
     *
     * @return array
     * [
     *     namespace => dir path
     * ]
     */
    public function getPrefixDirs(): array
    {
        Exec::$mainPath = __DIR__."/main.php";

        return [
            __NAMESPACE__."\\Http\\Controller" => __DIR__.'/Http/Controller',
            __NAMESPACE__."\\Command" => __DIR__."/Command",
//            __NAMESPACE__."\\Model" => __DIR__."/Model",
            __NAMESPACE__."\\Helper" => __DIR__."/Helper",
        ];
    }

    /**
     * Metadata information for the component.
     *
     * Quick config:
     *
     * ```php
     * $jsonFile = \dirname(__DIR__) . '/composer.json';
     *
     * return ComposerJSON::open($jsonFile)->getMetadata();
     * ```
     *
     * @return array
     * @see ComponentInterface::getMetadata()
     */
    public function metadata(): array
    {
        $jsonFile = dirname(__DIR__) . '/composer.json';

        return ComposerJSON::open($jsonFile)->getMetadata();
    }
}
