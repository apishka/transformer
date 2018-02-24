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
    protected function prepareAssert()
    {
        return new PostFileArray();
    }

    /**
     * Test valid data
     */
    public function testValidData()
    {
        $this->assertSame(
            ['error' => UPLOAD_ERR_OK],
            $this->prepareAssert()->process(['error' => UPLOAD_ERR_OK])
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
     * Test wrong values
     *
     * @dataProvider             wrongValuesProvider
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage  wrong input format
     * @param mixed $wrong_type
     */
    public function testWrongValues($wrong_type)
    {
        $assert = $this->prepareAssert();
        $assert->process($wrong_type);
    }

    /**
     * Test wrong values
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage  upload
     */
    public function testEmptyUpload()
    {
        $assert = $this->prepareAssert();
        $assert->process([]);
    }

    /**
     * Test wrong values
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage  upload
     */
    public function testWrongUpload()
    {
        $assert = $this->prepareAssert();
        $assert->process(['error' => !UPLOAD_ERR_OK]);
    }

    /**
     * Wrong data provider
     *
     * @return array
     */
    public function wrongValuesProvider()
    {
        return [
            ['test'],
            [new \StdClass()],
            [true],
            [2],
        ];
    }
}
