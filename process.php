<?php

declare(strict_types=1);

/*
 * (c) 2021 Digital Humanities Innovation Lab, Simon Fraser University
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

require 'vendor/autoload.php';

use Dhil\TextProc\Processor;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$logger = new Logger('process');
$output = "[%datetime%] %channel% - %level_name%: %message%\n";
$formatter = new LineFormatter($output);
$handler = new StreamHandler('php://stdout', Logger::WARNING);
$handler->setFormatter($formatter);
$logger->pushHandler($handler);

$processor = new Processor();
$processor->setLogger($logger);

if (2 !== $argc) {
    echo "usage: php processor <string>\n";

    exit(1);
}

//echo $processor->doStuff($argv[1]);
//echo $processor->clean($argv[1]);
//var_dump($processor->countCharactersOccurrence($argv[1]));
var_dump($processor->countWordsOccurrence($argv[1]));
//echo $processor->countWords($argv[1]);

echo "\n";
