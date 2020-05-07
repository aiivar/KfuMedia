<?php


namespace App\Abstracts;


use App\MediaService\Article;

/**
 * Class AbstractArticleParser
 * @package App\Abstracts
 */
abstract class AbstractArticleParser
{
    /**
     * @param string $resource
     * @return Article
     */
    public abstract function parse(string $resource): Article;
}