<?php

namespace Parsers\ZrkParser;

use App\Abstracts\AbstractParser;
use App\App;
use DiDom\Document;
use DiDom\Exceptions\InvalidSelectorException;

class Parser extends \Parsers\BasicKpfuParser\Parser
{
    public $link = "https://kpfu.ru/zrk/--2.html";

}