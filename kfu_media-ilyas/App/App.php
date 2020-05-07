<?php

namespace App;

use App\Actions\MainAction;
use App\Logger\Logger;
use App\MediaService\MediaService;
use App\ProviderService\ProviderService;
use GuzzleHttp\Client;

class App
{
    private static $_config;

    /**
     * App constructor.
     * @param $config array
     */

    public static $app;

    public function __construct($config)
    {
        self::$_config = $config;
        if (self::$app === null) self::$app = $this;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return self::$_config;
    }

    /**
     * @return array
     */
    public function getParsers(): array
    {
        return self::$_config['parsers'];
    }

    /**
     * Runs App
     */
    public function run(): void
    {
        $action = new MainAction();
        $action->run();
    }

    private $_logger;

    /**
     * App logger
     * @return Logger
     */
    public function logger()
    {
        if ($this->_logger === null) $this->_logger = new Logger();
        return $this->_logger;
    }

    private $_media;

    /**
     * Media service
     * @return MediaService
     */
    public function mediaService()
    {
        if ($this->_media === null) $this->_media = new MediaService();
        return $this->_media;
    }

    private $_provider;

    /**
     * Provider service
     * @return ProviderService
     */
    public function providerService()
    {
        if ($this->_provider === null) $this->_provider = new ProviderService();
        return $this->_provider;
    }

    private $_guzzle;

    /**
     * GuzzleHTTP Client
     * @return Client
     */
    public function guzzle()
    {
        if ($this->_guzzle === null) $this->_guzzle = new Client();
        return $this->_guzzle;
    }
}