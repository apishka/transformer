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
    protected function prepareAssert(): Json
    {
        return new Json();
    }

    /**
     * Test valid data
     */
    public function testValid(): void
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
    public function testNull(): void
    {
        $this->assertNull(
            $this->prepareAssert()->process(null)
        );
    }

    /**
     * Test incorrect json string
     */
    public function testIncorrectJson(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $this->prepareAssert()->process('{dewwe=}');
    }

    /**
     * Test incorrect json string
     */
    public function testIncorrectType(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $this->prepareAssert()->process(STDOUT);
    }

    /**
     * Test incorrect json string
     */
    public function testIncorrectType2(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $this->prepareAssert()->process(2);
    }

    /**
     * Test incorrect json string
     */
    public function testIncorrectObject()
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $this->prepareAssert()->process(new class() {});
    }

    /**
     * Test object reference
     */
    public function testObjectReference(): void
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
