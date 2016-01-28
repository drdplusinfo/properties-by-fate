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

    /**
     * @test
     */
    public function I_can_get_choice_code()
    {
        $choiceClass = $this->getChoiceClass();
        $this->assertSame(
            $this->getExpectedChoiceCode(),
            $choiceClass::getCode()
        );
        $codeConstantName = $this->getCodeConstantName();
        $this->assertSame(
            $this->getExpectedChoiceCode(),
            constant("$choiceClass::$codeConstantName")
        );
    }

    /**
     * @return string
     */
    abstract protected function getExpectedChoiceCode();

    private function getCodeConstantName()
    {
        $code = $this->getExpectedChoiceCode();

        return strtoupper($code);
    }
}
