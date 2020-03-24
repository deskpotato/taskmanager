<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class DataTest extends TestCase
{
//    /**
//     * @dataProvider addtionProvider
//     */
//    public function testAdd($a, $b, $expected)
//    {
//        $this->assertEquals($expected, $a + $b);
//    }
//
//    public function addtionProvider()
//    {
//        return [
//            [0, 0, 0],
//            [0, 1, 1],
//            [1, 0, 1],
//            [1, 1, 3]
//        ];
//    }

    public function provider()
    {
        return [['provider1']];
    }

    public function testProducerFirst()
    {
        $this->assertTrue(true);
        return 'first';
    }

    public function testProducerSecond()
    {
        $this->assertTrue(true);
        return 'second';
    }

    /**
     * @depends testProducerFirst
     * @depends testProducerSecond
     * @dataProvider provider
     */
    public function testConsumer()
    {
        $this->assertEquals(
            ['provider1', 'first', 'second'],
            func_get_args()
        );
    }
}
