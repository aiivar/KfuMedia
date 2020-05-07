<?php

namespace App\Actions;

use App\Abstracts\AbstractParser;
use App\App;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use Psr\Http\Message\ResponseInterface;

/**
 * Class MainAction
 * @package App\Actions
 */
class MainAction
{
    public function run(): void
    {
        $parsers = App::$app->getParsers();
        $promises = [];

        foreach ($parsers as $parserName => $subParsers) {
            foreach ($subParsers as $subParserName => $parser) {
                $parser = new $parser;
                if (!($parser instanceof AbstractParser)) continue;

                $promises[$parserName . '_' . $subParserName] = App::$app->guzzle()->getAsync($parser->link)->then(
                    function (ResponseInterface $res) use ($parser, $parserName, $subParserName) {
                        App::$app->logger()->info("Запуск парсера {$parserName}_{$subParserName}");
                        $parser->parse($res->getBody());
                    },
                    function (RequestException $e) {
                        App::$app->logger()->error($e->getMessage());
                    }
                );
            }
        }

        $responses = Promise\settle($promises)->wait();
    }
}