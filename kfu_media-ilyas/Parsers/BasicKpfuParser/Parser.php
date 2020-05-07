<?php

namespace Parsers\BasicKpfuParser;

use App\Abstracts\AbstractParser;
use App\App;
use DiDom\Document;
use DiDom\Exceptions\InvalidSelectorException;

class Parser extends AbstractParser
{

    public function parse(string $resource): void
    {
        $document = new Document($resource);

        if (!$document->has('#news_list2')) {
            App::$app->logger()->error("Ошибка парсинга страницы " . $this->link);
            return;
        }

        try {
            // ищем ссылки на странице
            // совет: смотрите где удобнее выцепить ссылки, в случае с сайтом химфака, удобнее всего было брать дату поста, т.к. там есть ссылка и класс
            $links = $document->first('#news_list2')->find('.vn_new_date');
        } catch (InvalidSelectorException $e) {
            App::$app->logger()->error($e->getMessage());
        }
        if (empty($links)) return;

        $article = new ArticleParser();
        foreach ($links as $link) {

            // осуществляем добавление статьи в базу
            App::$app->mediaService()->processLink($link->attr('href'), $article);
        }

    }
}