<?php
namespace DrdPlus\Tests\Exceptionalities\Choices;

use DrdPlus\Exceptionalities\Choices\ExceptionalityChoice;

abstract class AbstractTestOfChoice extends \PHPUnit_Framework_TestCase
{

    /**
     * @return ExceptionalityChoice
     *
     * @test
     */
    public function I_can_create_it_by_self()
    {
        $choiceClass = $this->getChoiceClass();
        $instance = $choiceClass::getIt();
        $this->assertInstanceOf($choiceClass, $instance);

        return $instance;
    }

    /**
     * @return string|ExceptionalityChoice
     */
    protected function getChoiceClass()
    {
        return preg_replace('~[\\\]Tests(.+)Test$~', '$1', static::class);
    }
}
