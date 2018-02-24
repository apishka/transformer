<?php

namespace ApishkaTest\Transformer\Transform\PostgreSQL;

use Apishka\Transformer\Transform\PostgreSQL\Json;

/**
 * Json assert test
 */
class JsonTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return Json
     */
    protected function prepareAssert()
    {
        return new Json();
    }

    /**
     * Test valid data
     */
    public function testValid()
    {
        $assert = $this->prepareAssert();

        $this->assertSame(
            ['key' => 'value'],
            $assert->process(json_encode(['key' => 'value']))
        );

        $this->assertSame(
            ['key' => 'value'],
            $assert->process(['key' => 'value'])
        );

        $test_obj = new class() implements \JsonSerializable {
            public function jsonSerialize()
            {
                return [];
            }
        };

        $this->assertSame(
            $test_obj,
            $assert->process($test_obj)
        );
    }

    /**
     * Test null
     */
    public function testNull()
    {
        $this->assertSame(
            null,
            $this->prepareAssert()->process(null)
        );
    }

    /**
     * Test incorrect json string
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong input format
     */
    public function testIncorrectJson()
    {
        $this->prepareAssert()->process('{dewwe=}');
    }

    /**
     * Test incorrect json string
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong input format
     */
    public function testIncorrectType()
    {
        $this->prepareAssert()->process(STDOUT);
    }

    /**
     * Test incorrect json string
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong input format
     */
    public function testIncorrectType2()
    {
        $this->prepareAssert()->process(2);
    }

    /**
     * Test incorrect json string
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong input format
     */
    public function testIncorrectObject()
    {
        $this->prepareAssert()->process(new class() {});
    }

    /**
     * Test object reference
     */
    public function testObjectReference()
    {
        $test_obj1 = new class() implements \JsonSerializable {
            protected $a = 1;
            public function jsonSerialize()
            {
                return ['a' => $this->a];
            }
        };

        $test_obj2 = new class() implements \JsonSerializable {
            protected $a = 1;
            public function jsonSerialize()
            {
                return ['a' => $this->a];
            }
        };

        $this->assertNotEquals(
            $test_obj1,
            $this->prepareAssert()->process($test_obj2)
        );
    }
}
