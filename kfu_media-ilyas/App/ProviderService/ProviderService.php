<?php


namespace App\ProviderService;


use App\App;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

/**
 * Provides methods to load pages via http
 * @package App\ProviderService
 */
class ProviderService
{
    private function request(string $link, string $method): string
    {
        $promise = App::$app->guzzle()->requestAsync($method, $link);

        $text = $promise->then(
            function (ResponseInterface $res){
                return (string)$res->getBody();
            },
            function (RequestException $e) {
                App::$app->logger()->error($e->getMessage());
                throw new \Exception($e->getMessage());
            }
        )->wait();

        return $text;
    }

    public function get(string $link): string
    {
        return $this->request($link, 'GET');
    }

    public function post(string $link): string
    {
        return $this->request($link, 'POST');
    }
}