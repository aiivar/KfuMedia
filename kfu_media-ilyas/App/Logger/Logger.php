<?php

namespace App\Logger;
class Logger
{
    const LEVEL_ERROR = 1;
    const LEVEL_WARNING = 2;
    const LEVEL_INFO = 3;
    const LEVEL_DEBUG = 4;

    private $_time;
    private $_path = __DIR__ . '\logs\\';

    function __construct()
    {
        $this->_time = date('d.m.Y H_i_s');
    }


    /**
     * Adds new record to log
     * @param string $message
     * @param int $level
     */
    private function add(string $message, int $level = self::LEVEL_DEBUG): void
    {
        $log = '[' . date('H:i:s d.m.Y') . '] [' . self::level($level) . '] ' . $message . PHP_EOL;
        file_put_contents($this->_path . $this->_time . '.txt', $log, FILE_APPEND);
    }

    /**
     * Adds new record to log with error level
     * @param string $message
     * @param int $level
     */
    public function error(string $message): void
    {
        $this->add($message, self::LEVEL_ERROR);
    }

    /**
     * Adds new record to log with warning level
     * @param string $message
     * @param int $level
     */
    public function warning(string $message): void
    {
        $this->add($message, self::LEVEL_WARNING);
    }

    /**
     * Adds new record to log with info level
     * @param string $message
     * @param int $level
     */
    public function info(string $message): void
    {
        $this->add($message, self::LEVEL_INFO);
    }

    /**
     * Adds new record to log with debug level
     * @param string $message
     * @param int $level
     */
    public function degub(string $message): void
    {
        $this->add($message, self::LEVEL_DEBUG);
    }

    public static function level(int $level): string
    {
        switch ($level) {
            case 1:
                return 'ERROR';
            case 2:
                return 'WARNING';
            case 3:
                return 'INFO';
            case 4:
            default:
                return 'DEBUG';
        }
    }
}