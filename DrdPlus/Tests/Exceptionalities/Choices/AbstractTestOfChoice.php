<?php
namespace DrdPlus\Cave\UnitBundle\Tests\Person\Attributes\Exceptionalities\Choices;

use Doctrine\DBAL\Types\Type;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\Choices\ExceptionalityChoice;
use DrdPlus\Cave\UnitBundle\Person\Races\Race;
use DrdPlus\Cave\UnitBundle\Tests\TestWithMockery;

abstract class AbstractTestOfChoice extends TestWithMockery
{
    /**
     * @test
     */
    public function type_name_is_as_expected()
    {
        $choiceClass = $this->getChoiceClass();
        $this->assertSame($this->buildChoiceName(), $choiceClass::getTypeName());
    }

    /**
     * @return string
     */
    protected function buildChoiceName()
    {
        $baseName = $this->getChoiceBaseName();
        $underScoredBaseName = preg_replace('~(\w)([A-Z])~', '$1_$2', $baseName);

        return strtolower($underScoredBaseName);
    }

    /**
     * @return string
     */
    protected function getChoiceBaseName()
    {
        $choiceBaseName = $this->getChoiceClass();

        return preg_replace('~(\w+\\\)*(\w+)~', '$2', $choiceBaseName);
    }

    /**
     * @return string|ExceptionalityChoice
     */
    protected function getChoiceClass()
    {
        return preg_replace('~Test$~', '', static::class);
    }

    /**
     * @test
     */
    public function can_register_self()
    {
        $choiceClass = $this->getChoiceClass();
        $choiceClass::registerSelf();
        $this->assertTrue(Type::hasType($choiceClass::getTypeName()));
    }

    /**
     * @return Race
     *
     * @test
     * @depends can_register_self
     */
    public function can_create_self()
    {
        $choiceClass = $this->getChoiceClass();
        $instance = $choiceClass::getIt();
        $this->assertInstanceOf($choiceClass, $instance);
        $expectedName = $this->buildChoiceName();
        $this->assertSame($expectedName, $instance->getTypeName());
        // as a self-typed single-value enum is the type name same as the enum value
        $this->assertSame($expectedName, $instance->getEnumValue());
        // kind is human shortcut for enum value
        $this->assertSame($expectedName, $instance->getChoice());

        return $instance;
    }
}
