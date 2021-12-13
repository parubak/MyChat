<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class ArrTest extends TestCase
{
    public $arr;

    public function setUp(): void
    {
        $this->arr = \Framework\Arr::wrap(['a'=>234]);
    }

    public function testWrap() {
        $this->assertIsObject($this->arr);

        $this->assertEquals(
            \Framework\Arr::class,
            get_class($this->arr)
        );
    }

    public function testGet1() {
        $a = [
            'a' => [
                'b' => [
                    'c' => [
                        'd' => [
                            'e' => 123
                        ]
                    ]
                ]
            ]
        ];

        $arr = \Framework\Arr::wrap($a);
        $var123 = $arr->get('a.b.c.d.e');
        $this->assertIsInt($var123);
        $this->assertEquals(123, $var123);
    }

    public function testGet2() {
        $var234 = $this->arr->get('a');
        $this->assertIsInt($var234);
        $this->assertEquals(234, $var234);
    }

    public function testGet3() {
        $var234 = $this->arr->get('b');
        $this->assertNull($var234);
    }

    public function testGet4() {
        $var234 = $this->arr->get('b', 3306);
        $this->assertIsInt($var234);
        $this->assertEquals(3306, $var234);
    }
}
