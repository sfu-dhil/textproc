<?php

declare(strict_types=1);

/*
 * (c) 2021 Digital Humanities Innovation Lab, Simon Fraser University
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace Dhil\TextProc;

use PHPUnit\Framework\TestCase;

class ProcessorTest extends TestCase {
    private Processor $processor;


    /**
     * @test
     * @dataProvider cleanData
     */
    public function clean($expectedResult, $input) : void {
          $this->assertSame($expectedResult, $this->processor->clean($input));
    }
    public function cleanData(){
    return [
        ['a','  a'],
        ['',''],
        ['','  '],
        ['a','a  '],
        ['a','a?'],
        ['a','A'],
        ['hello it is me','hello  it is me'],
        ['aبنفش','aبنفش'],
        ['e','é'],
        ['e',"e\u{0301}",true], //é
    ];
    }
    /**
     * @test
     * @dataProvider countCharactersData
     */
    public function countCharacters($expectedResult, $input, $dirtFlag): void {
        $this->assertSame($expectedResult, $this->processor->countCharacters($input,$dirtFlag));
    }
    public function countCharactersData(){
        return [
            [0,'', true],
            [1,'a',true],
            [2,'a?',true],
            [9,'hello hyd',true],
            [4,'联合声明',true],
            [4,'بنفش',true],
            [1,'é',true],
            [2,"e\u{0301}",true], //é  -> at end, we want it to be one (change line 60 processor.php)

        ];
    }

    /**
     * @test
     * @dataProvider countLinesData
     */
    public function countLines($expectedResult, $input, $dirtFlag): void{
        $this->assertSame($expectedResult, $this->processor->countLines($input,$dirtFlag));
    }
    public function countLinesData(){
        return [
            [0,'', true],
            [1,"\n",true],
            [2,"hello\nhny\n",true],
            [2,"hello\n\n",true],
        ];
    }

    /**
     * @test
     * @dataProvider countWordsData
     */
    public function countWords($expectedResult, $input, $dirtFlag): void{
        $this->assertSame($expectedResult, $this->processor->countWords($input,$dirtFlag));

    }
    public function countWordsData(){
        return [
            [4,'azizam بگو bar migardi', true],
            [1,'woo-hoo',true],
            [1,'aziz?i',true],
            [0,'',true],
            [3,'azizami ؟ مگه',true],
            [1,'联合声明',true],
            [2,'hello  what',true],

        ];
    }

    protected function setUp() : void {
        parent::setUp();
        $this->processor = new Processor();
    }
}
