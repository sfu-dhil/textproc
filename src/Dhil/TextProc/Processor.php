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
use Normalizer;
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

    /**
     * @param string $a
     * @return string
     */
    public function clean(string $a) : string {

        $a= Normalizer::normalize($a,Normalizer::FORM_D);
        $a= preg_replace('/\p{M}/u','',$a);

        //remove spaces beginning and end
        $a= preg_replace('/^\s+|\s+$/u','',$a);

        //remove punctuation
        $a= preg_replace('/\p{P}/u','',$a);

        //to lowerCase
        $a= mb_strtolower($a);

        //multiSpace to singleSpace
        return preg_replace('/\s+/u', ' ', $a);
    }

    public function countCharacters(string $a, bool $dirtFlag) : int {
        //This function gets a string and count the characters inside, if the bool is true
        if($dirtFlag)
            return mb_strlen($a);
    }
    public function countLines(string $a, bool $dirtFlag) : int {
        //This function gets a string, count the lines inside, if the bool is true
        if($dirtFlag){
            $matches=[];
            preg_match_all('/(\r\n|\r|\n)/u', $a, $matches);
            return count($matches[0]);
        }
    }
    public function countWords(string $a, bool $dirtFlag) : int {
        //This function gets a string, count the words inside, if the bool is true
        if ($dirtFlag){
            $matches=[];
            preg_match_all('/[\pL\pN\pPd]+/u', $a, $matches);
            return count($matches[0]);
        }
    }

}
