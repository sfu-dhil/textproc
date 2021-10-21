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
class Processor implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct()
    {
        $this->logger = new NullLogger();
    }

    /**
     * This placeholder function exists to check that the configuration
     * is correct. It should be removed once everything is working.
     *
     * Take a string and return the same exact string.
     */
    public function doStuff(string $a): string
    {
        $this->logger->notice("doing stuff with {$a}.");

        return $a;
    }

    /**
     * This function gets an input as an string, and cleans the string in a way that
     * 1) it is normalized and no accents ( canonical Decomposition)
     * 2) does not have spaces in the beginning and the end
     * 3) does not have any punctuation
     * 4) is all in lowercase
     * 5) does not have multi-spaces
     */
    public function clean(string $a): string
    {

        //removing accents characters
        $a = Normalizer::normalize($a, Normalizer::FORM_D);
        $a = preg_replace('/\p{M}/u', '', $a);

        //remove spaces beginning and end
        $a = preg_replace('/^\s+|\s+$/u', '', $a);

        //remove punctuation
        $a = preg_replace('/\p{P}/u', '', $a);

        //to lowerCase
        $a = mb_strtolower($a);

        //multiSpace to singleSpace
        return preg_replace('/\s+/u', ' ', $a);
    }

    /**
     * This function gets an input as an string, and count the characters inside, not bytes
     */
    public function countCharacters(string $a): int
    {
        $a = Normalizer::normalize($a, Normalizer::FORM_C);
        return mb_strlen($a);
    }

    /**
     * This function gets a string, count the lines inside,
     */
    public function countLines(string $a): int
    {
        $matches = [];
        preg_match_all('/(\r\n|\r|\n)/u', $a, $matches);
        return count($matches[0]);
    }

    /**
     * This function gets a string, count the words inside, if the bool is true
     */
    public function countWords(string $a): int
    {
            $matches = [];
            preg_match_all('/[\pL\pN\pPd]+/u', $a, $matches);
            //return $matches[0];
            return count($matches[0]);
    }
    /**
     * This function gets an input as an string, and count the occurrence of every single
     * character inside, not bytes
     */
    public function countCharactersOccurrence(string $a): array
    {
        $occ=[];
        for ($i = 0; $i < mb_strlen($a); $i++){
            $c=mb_substr($a,$i,1);
            if(array_key_exists($c,$occ)) {
                $occ[$c]++;
            }
            else {
                $occ[$c] = 1;
            }
        }
        return $occ;
    }
}
