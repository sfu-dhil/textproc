<?php

declare(strict_types=1);

/*
 * (c) 2021 Digital Humanities Innovation Lab, Simon Fraser University
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace Dhil\TextProc;

use PHPUnit\Framework\TestCase;

class ProcessorTest extends TestCase
{
    private Processor $processor;


    /**
     * @test
     * @dataProvider cleanData
     */
    public function clean($expectedResult, $input): void
    {
        $this->assertSame($expectedResult, $this->processor->clean($input));
    }

    public function cleanData()
    {
        return [
            ['a', '  a'],
            ['', ''],
            ['', '  '],
            ['a', 'a  '],
            ['a', 'a?'],
            ['a', 'A'],
            ['hello it is me', 'hello  it is me'],
            ['aبنفش', 'aبنفش'],
            ['e', 'é'],
            ['e', "e\u{0301}"], //é
        ];
    }

    /**
     * @test
     * @dataProvider countCharactersData
     */
    public function countCharacters($expectedResult, $input): void
    {
        $this->assertSame($expectedResult, $this->processor->countCharacters($input));
    }

    public function countCharactersData()
    {
        return [
            [0, ''],
            [1, 'a'],
            [2, 'a?'],
            [9, 'hello hyd'],
            [4, '联合声明'],
            [4, 'بنفش'],
            [1, 'é'],
            // [2,"e\u{0301}"], //é  -> at end, we want it to be one (change line 60 processor.php)
            [1, "e\u{0301}"]
        ];
    }

    /**
     * @test
     * @dataProvider countLinesData
     */
    public function countLines($expectedResult, $input): void
    {
        $this->assertSame($expectedResult, $this->processor->countLines($input));
    }

    public function countLinesData()
    {
        return [
            [0, ''],
            [1, "\n"],
            [2, "hello\nhny\n"],
            [2, "hello\n\n"],
        ];
    }

    /**
     * @test
     * @dataProvider countWordsData
     */
    public function countWords($expectedResult, $input): void
    {
        $this->assertSame($expectedResult, $this->processor->countWords($input));

    }

    public function countWordsData()
    {
        return [
            [4, 'azizam بگو bar migardi'],
            [1, 'woo-hoo'],
            [1, 'aziz?i'],
            [0, ''],
            [3, 'azizami ؟ مگه'],
            [1, '联合声明'],
            [2, 'hello  what'],

        ];
    }


    /**
     * @test
     * @dataProvider countCharactersOccurrenceData
     */
    public function countCharactersOccurrence($expectedResult, $input): void
    {
        $this->assertEqualsCanonicalizing($expectedResult, $this->processor->countCharactersOccurrence($input));
    }

    public function countCharactersOccurrenceData()
    {
        return [
            [
                [
                    '?' => 1,
                    'a' => 1
                ],
                'a?'
            ],
            [
                [
                    'a' => 1,
                    'b' => 1
                ],
                'ab'
            ],
            [
                [
                    'a' => 1,
                    'b' => 1
                ],
                'ba'
            ],
            [
                [
                    'س' => 1,
                    'ب' => 1,
                    'ا' => 1,
                ],
                'سبا'
            ],
            [
                [
                ],
                ''
            ],
            [
                ['' => 1,
                ],
                ' '
            ],
            [
                [' ' => 1,
                ],
                ' '
            ],
            [
                ['' => 2
                ],
                '  '
            ]
        ];
    }

    /**
     * @test
     * @dataProvider countWordsOccurrenceData
     */
    public function countWordsOccurrence($expectedResult, $input): void
    {
        $this->assertEqualsCanonicalizing($expectedResult, $this->processor->countWordsOccurrence($input));
    }

    public function countWordsOccurrenceData()
    {
//        [4, 'azizam بگو bar migardi'],
//            [1, 'woo-hoo'],
//            [1, 'aziz?i'],
//            [0, ''],
//            [3, 'azizami ؟ مگه'],
//            [1, '联合声明'],
//            [2, 'hello  what'],

        return [
            [
                [
                    'Hi' => 1,
                    'there' => 1
                ],
                'Hi there'
            ],
            [
                [
                ],
                ''
            ],
            [
                ['woo-hoo'=>1
                ],
                'woo-hoo'
            ],
            [
                ['azizami'=>1,
                    'مگه' =>1,
                    '؟' =>1,
                ],
                'azizami ؟ مگه'
            ],
            [
                ['عزیزم'=>2,
                    'مگه' =>1,
                    '؟' =>1,
                ],
                'عزیزم عزیزم ؟ مگه'
            ]
        ];
    }


    protected function setUp(): void
    {
        parent::setUp();
        $this->processor = new Processor();
    }
}
