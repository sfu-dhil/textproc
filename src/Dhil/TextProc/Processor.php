<?php

declare(strict_types=1);

/*
 * (c) 2021 Digital Humanities Innovation Lab, Simon Fraser University
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace Dhil\TextProc;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

/**
 * Implementation of some text processing functions.
 */
class Processor implements LoggerAwareInterface {
    use LoggerAwareTrait;

    public function __construct() {
        $this->logger = new NullLogger();
    }

    /**
     * This placeholder function exists to check that the configuration
     * is correct. It should be removed once everything is working.
     *
     * Take a string and return the same exact string.
     */
    public function doStuff(string $a) : string {
        $this->logger->notice("doing stuff with {$a}.");

        return $a;
    }
}
