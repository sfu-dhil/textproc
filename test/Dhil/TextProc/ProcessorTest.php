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
     */
    public function doStuff() : void {
        $this->assertSame('a', $this->processor->doStuff('a'));
    }

    protected function setUp() : void {
        parent::setUp();
        $this->processor = new Processor();
    }
}
