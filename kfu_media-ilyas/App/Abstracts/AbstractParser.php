<?php

namespace App\Abstracts;

/**
 * Class AbstractParser
 * @package App\Abstracts
 */
abstract class AbstractParser
{
    /**
     * @var string
     */
    public $link;

    /**
     * @param string $resource
     */
    public abstract function parse(string $resource): void;
}