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
/**
 * 注意
 *如果一个测试依赖于另外一个使用了数据供给器的测试，仅当被依赖的测试至少能在一组数据上成功时，依赖于它的测试才会运行。使用了数据供给器的测试，其运行结果是无
 *法注入到依赖于此测试的其他测试中的。
 */
