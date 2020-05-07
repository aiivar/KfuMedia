<?php


namespace App\MediaService;


use App\Abstracts\AbstractArticleParser;
use App\App;

/**
 * Class MediaService
 * Provides methods to manage articles
 * @package App\MediaService
 */
class MediaService
{
    private $_path = 'articles/';

    public function articleExists(string $link): bool
    {
        return file_exists($this->_path . md5($link) . '.txt');
    }

    public function processLink(string $link, AbstractArticleParser $articleParser): void
    {
        //TODO articles updating

        if ($this->articleExists($link)) return;

        $page = App::$app->providerService()->get($link);
        $article = $articleParser->parse($page);
        $article->link = $link;

        //TODO filter text

        //add article to DB
        file_put_contents($this->_path . md5($link) . '.txt',
            'title: ' . $article->title . PHP_EOL .
            'author: ' . $article->author . PHP_EOL .
            'date: ' . date('d.m.Y H:i:s', $article->date) . PHP_EOL .
            'text: ' . $article->text . PHP_EOL .
            'link: ' . $article->link);
    }
}