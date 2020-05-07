<?php

namespace Parsers\LibraryParser;

use App\Abstracts\AbstractParser;
use App\App;
use DiDom\Document;
use DiDom\Exceptions\InvalidSelectorException;

class Parser extends \Parsers\BasicKpfuParser\Parser
{
    public $link = "https://kpfu.ru/library/--2.html";

}