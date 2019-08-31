<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\PostFileArray;

/**
 * Post file array assert test
 */
class PostFileArrayTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return PostFileArray
     */
    protected function prepareAssert(): PostFileArray
    {
        return new PostFileArray();
    }

    /**
     * Test valid data
     */
    public function testValidData(): void
    {
        $this->assertSame(
            ['error' => UPLOAD_ERR_OK],
            $this->prepareAssert()->process(['error' => UPLOAD_ERR_OK])
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
     * Test wrong values
     *
     * @dataProvider wrongValuesProvider
     * @param mixed $wrong_type
     */
    public function testWrongValues($wrong_type): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $assert = $this->prepareAssert();
        $assert->process($wrong_type);
    }

    /**
     * Test wrong values
     */
    public function testEmptyUpload(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('upload');

        $assert = $this->prepareAssert();
        $assert->process([]);
    }

    /**
     * Test wrong values
     */
    public function testWrongUpload(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('upload');

        $assert = $this->prepareAssert();
        $assert->process(['error' => !UPLOAD_ERR_OK]);
    }

    /**
     * Wrong data provider
     *
     * @return array
     */
    public function wrongValuesProvider(): array
    {
        return [
            ['test'],
            [new \StdClass()],
            [true],
            [2],
        ];
    }
}
