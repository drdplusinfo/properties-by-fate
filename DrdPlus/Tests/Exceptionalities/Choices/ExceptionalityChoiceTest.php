<?php
namespace DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\Choices;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use DrdPlus\Cave\UnitBundle\Tests\TestWithMockery;

class ExceptionalityChoiceTest extends TestWithMockery
{

    /**
     * @test
     */
    public function has_type_name_as_expected()
    {
        $this->assertSame('exceptionality_choice', ExceptionalityChoice::getTypeName());
        $this->assertSame('exceptionality_choice', ExceptionalityChoice::EXCEPTIONALITY_CHOICE);
    }

    /**
     * @test
     * @depends has_type_name_as_expected
     */
    public function can_register_self()
    {
        ExceptionalityChoice::registerSelf();
        $this->assertTrue(Type::hasType(ExceptionalityChoice::getTypeName()));
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function creating_exceptionality_enum_itself_cause_exception()
    {
        ExceptionalityChoice::getEnum('foo');
    }

    /**
     * @test
     * @expectedException \LogicException
     */
    public function creating_exceptionality_enum_by_shortcut_cause_exception()
    {
        ExceptionalityChoice::getIt();
    }


    /**
     * @test
     * @depends can_register_self
     */
    public function can_be_created_as_enum_type()
    {
        $genericExceptionality = Type::getType(ExceptionalityChoice::getTypeName());
        $this->assertInstanceOf(ExceptionalityChoice::class, $genericExceptionality);
    }

    /**
     * @test
     * @depends can_be_created_as_enum_type
     */
    public function type_name_of_generic_exceptionality_choice_is_as_generic_enum_type()
    {
        $this->assertSame('exceptionality_choice', ExceptionalityChoice::getTypeName());
    }

    /**
     * @test
     * @depends can_register_self
     */
    public function specific_exceptionality_choice_can_be_created()
    {
        TestExceptionalityChoice::registerSelf();
        $specificChoice = TestExceptionalityChoice::getIt();
        $this->assertInstanceOf(TestExceptionalityChoice::class, $specificChoice);
    }

    /**
     * @test
     * @depends specific_exceptionality_choice_can_be_created
     */
    public function specific_exceptionality_choice_type_name_is_built_from_class_name()
    {
        $this->assertSame('test_exceptionality_choice', TestExceptionalityChoice::getTypeName());
    }

    /**
     * @test
     * @depends can_be_created_as_enum_type
     */
    public function returns_proper_specific_exceptionality_choice()
    {
        /** @var ExceptionalityChoice $genericChoice */
        $genericChoice = Type::getType(ExceptionalityChoice::getTypeName());
        $genericChoice::addSubTypeEnum(TestExceptionalityChoice::class, $regexp = '~test_exceptionality_choice~');
        $this->assertRegExp($regexp, TestExceptionalityChoice::getTypeName());
        $specificChoice = $genericChoice->convertToPHPValue(TestExceptionalityChoice::getTypeName(), $this->getPlatform());
        $this->assertInstanceOf(TestExceptionalityChoice::class, $specificChoice);
    }

    /**
     * @return AbstractPlatform
     */
    protected function getPlatform()
    {
        return \Mockery::mock(AbstractPlatform::class);
    }

}

/** inner */
class TestExceptionalityChoice extends ExceptionalityChoice
{

}
