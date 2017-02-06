<?php


namespace lilHermit\Toolkit\Test\TestCase\Utility;


use Cake\TestSuite\TestCase;
use lilHermit\Toolkit\Utility\Html;

class HtmlTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Test addClass method newClass parameter
     *
     * Tests null, string, array and false for `input`
     *
     * @return void
     */
    public function testAddClassMethodNewClass()
    {
        // Test new class as null, string, array, false etc
        $result = Html::addClass([], 'new_class');
        $this->assertEquals($result, ['class' => ['new_class']]);
        $result = Html::addClass([], ['new_class']);
        $this->assertEquals($result, ['class' => ['new_class']]);
        $result = Html::addClass([], false);
        $this->assertEquals($result, []);
        $result = Html::addClass([], null);
        $this->assertEquals($result, []);
        $result = Html::addClass(null, null);
        $this->assertNull($result);
    }

    /**
     * Test addClass method input (currentClass) parameter
     *
     * Tests null, string, array, false and object
     *
     * @return void
     */
    public function testAddClassMethodCurrentClass()
    {
        $result = Html::addClass(['class' => ['current']], 'new_class');
        $this->assertEquals($result, ['class' => ['current', 'new_class']]);
        $result = Html::addClass('', 'new_class');
        $this->assertEquals($result, ['class' => ['new_class']]);
        $result = Html::addClass(null, 'new_class');
        $this->assertEquals($result, ['class' => ['new_class']]);
        $result = Html::addClass(false, 'new_class');
        $this->assertEquals($result, ['class' => ['new_class']]);
        $result = Html::addClass(new \StdClass(), 'new_class');
        $this->assertEquals($result, ['class' => ['new_class']]);
    }

    /**
     * Test addClass method string parameter, it should fallback to string
     *
     * @return void
     */
    public function testAddClassMethodFallbackToString()
    {
        $result = Html::addClass('current', 'new_class');
        $this->assertEquals($result, ['class' => ['current', 'new_class']]);
    }

    /**
     * Test addClass method to make sure the returned array is unique
     *
     * @return void
     */
    public function testAddClassMethodUnique()
    {
        $result = Html::addClass(['class' => ['new_class']], 'new_class');
        $this->assertEquals($result, ['class' => ['new_class']]);
    }

    /**
     * Test addClass method useIndex option
     *
     * Tests for useIndex being the default, 'my_class' and false
     *
     * @return void
     */
    public function testAddClassMethodUseIndexOption()
    {
        $result = Html::addClass(
            [
                'class' => 'current_class',
                'other_index1' => false,
                'type' => 'text'
            ],
            'new_class',
            [
                'useIndex' => 'class'
            ]
        );
        $this->assertEquals(
            $result,
            [
                'class' => ['current_class', 'new_class'],
                'other_index1' => false,
                'type' => 'text'
            ]
        );

        $result = Html::addClass(
            [
                'my_class' => 'current_class',
                'other_index1' => false,
                'type' => 'text'
            ],
            'new_class',
            [
                'useIndex' => 'my_class'
            ]
        );
        $this->assertEquals(
            $result,
            [
                'other_index1' => false,
                'type' => 'text',
                'my_class' => ['current_class', 'new_class']
            ]
        );

        $result = Html::addClass(
            [
                'current_class',
                'text'
            ],
            'new_class',
            [
                'useIndex' => false
            ]
        );
        $this->assertEquals(
            $result,
            [
                'current_class',
                'text',
                'new_class'
            ]
        );
    }

    /**
     * Test addClass method to make sure `asString` option is handle correctly
     *
     * @return void
     */
    public function testAddClassMethodAsStringOption()
    {
        $result = Html::addClass(
            ['class' => 'current_class'],
            'new_class',
            [
                'asString' => true
            ]
        );
        $this->assertEquals($result, ['class' => 'current_class new_class']);

        $result = Html::addClass(
            ['current_class'],
            'new_class',
            [
                'useIndex' => false,
                'asString' => true
            ]
        );
        $this->assertEquals($result, 'current_class new_class');

        $result = Html::addClass(
            null,
            'new_class',
            [
                'asString' => true
            ]
        );
        $this->assertEquals($result, ['class' => 'new_class']);
    }

    /**
     * Test containsClass
     *
     * @return void
     */
    public function testContainsClassMethod()
    {
        $result = Html::containsClass(
            ['class' => 'monkey'],
            'monkey'
        );
        $this->assertEquals(true, $result);

        $result = Html::containsClass(
            ['class' => ['monkey']],
            'monkey'
        );
        $this->assertEquals(true, $result);

        $result = Html::containsClass(
            ['class' => ['monkey', 'lion']],
            ['monkey']
        );
        $this->assertEquals(true, $result);

        $result = Html::containsClass(
            ['class' => ['monkey', 'lion']],
            ['monkey', 'lion']
        );
        $this->assertEquals(true, $result);

        $result = Html::containsClass(
            ['class' => ['monkey', 'lion']],
            ['monkey', 'tiger']
        );
        $this->assertEquals(false, $result);
    }

    /**
     * Test containsClass useIndex option
     *
     * @return void
     */
    public function testContainsClassMethodOptionUseIndex()
    {
        $result = Html::containsClass(
            ['my-class' => 'monkey'],
            'monkey',
            ['useIndex' => 'my-class']
        );
        $this->assertEquals(true, $result);

        $result = Html::containsClass(
            ['my-class' => ['monkey', 'lion']],
            ['monkey', 'lion'],
            ['useIndex' => 'my-class']
        );
        $this->assertEquals(true, $result);

        $result = Html::containsClass(
            ['something' => ['my-class' => 'monkey']],
            'monkey',
            ['useIndex' => 'something.my-class']
        );
        $this->assertEquals(true, $result);

        $result = Html::containsClass(
            ['something' => ['my-class' => ['monkey', 'lion']]],
            ['monkey', 'lion'],
            ['useIndex' => 'something.my-class']
        );
        $this->assertEquals(true, $result);


        $result = Html::containsClass(
            ['monkey'],
            'monkey',
            ['useIndex' => false]
        );
        $this->assertEquals(true, $result);

        $result = Html::containsClass(
            ['monkey', 'lion'],
            ['monkey', 'lion'],
            ['useIndex' => false]
        );
        $this->assertEquals(true, $result);
    }

    /**
     * Test containsClass Or option
     *
     * @return void
     */
    public function testContainsClassMethodOptionOr()
    {
        $result = Html::containsClass(
            ['class' => ['monkey']],
            ['monkey', 'lion'],
            ['or' => true]
        );
        $this->assertEquals(true, $result);

        $result = Html::containsClass(
            ['class' => ['monkey', 'lion']],
            ['monkey', 'lion', 'tiger'],
            ['or' => true]
        );
        $this->assertEquals(true, $result);
    }
}