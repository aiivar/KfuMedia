<?php

namespace Parsers\BasicKpfuParser;

use App\Abstracts\AbstractArticleParser;
use App\MediaService\Article;
use DiDom\Document;

class ArticleParser extends AbstractArticleParser
{
    public function parse(string $resource): Article
    {
        $model = new Article();
        $text = '';

        $document = new Document(null, false, 'windows-1251');
        $document->loadHtml($resource);


        if ($document->has('.vn_new_date')) {
            $date = $document->first('.vn_new_date')->text();// совет: проверяйте, нет ли других элементов с таким же классом, может нужно искать более узко

            // приходится заменять дату, тк PHP не работает с русским языком
            $months = [
                'января' => 'january',
                'февраля' => 'february',
                'марта' => 'march',
                'апреля' => 'april',
                'мая' => 'may',
                'июня' => 'june',
                'июля' => 'jule',
                'августа' => 'august',
                'сентября' => 'september',
                'октября' => 'october',
                'ноября' => 'november',
                'декабря' => 'december',
            ];

            $model->date = strtotime(strtr($date, $months));
        }
        if ($document->has('#news_list')) {
            $element = $document->first('.vn_new_header');
            $model->title = $element->text();

            $element = $this->nextNotEmptySibling($element);

            $text = $element->html();
            $element = $this->nextNotEmptySibling($element);

            $text .= $element->html();

            $model->text = $text;
            $model->author = $this->nextNotEmptySibling($element)->text();
        }
        return $model;
    }

    // DiDom парсит с пробелами, приходится делать вот так
    private function nextNotEmptySibling(\DiDom\Element $element)
    {
        $element = $element->nextSibling();
        while ($element->html() == '') $element = $element->nextSibling();

        return $element;
    }
}