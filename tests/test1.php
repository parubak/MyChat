<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class TruncateTest extends TestCase
{
    public function testShortStringRemainsAsIs()
    {
        $result = truncate("hello", 10);

        $this->assertEquals("hello", $result);
    }

    public function testLongStringIsTruncated()
    {
        $result = truncate("hello world", 5);
        $this->assertEquals("hello…", $result);
    }
}