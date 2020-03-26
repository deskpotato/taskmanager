<?php

namespace Tests\Feature;

use http\Exception\InvalidArgumentException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExceptionTest extends TestCase
{
    public function testException()
    {
        $this->expectException(InvalidArgumentException::class);
    }

    /**
     * @expectedException \PHPUnit\Framework\Error\Error
     */
    public function testFailingInclude()
    {
        include 'not_existing_file.php';
    }

    /**
     * @expectedException \PHPUnit\Framework\Error\Notice
     */
    public function testFailing()
    {
        include 'not_existing_file_2.php';
    }

    public function testExpectFooActualFoo()
    {
        $this->expectOutputString('foo');
        print('foo');
    }

    public function testExpectBarActualBaz()
    {
        $this->expectOutputString('bar');
        print 'baz';
    }



}
