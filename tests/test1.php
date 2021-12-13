<?php
declare(strict_types=1);

class TruncateTest extends \PHPUnit\Framework\TestCase
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