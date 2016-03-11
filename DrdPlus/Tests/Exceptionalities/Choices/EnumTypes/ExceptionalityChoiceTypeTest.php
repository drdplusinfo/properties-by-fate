<?php
namespace DrdPlus\Tests\Exceptionalities\Choices\EnumTypes;

use Doctrine\DBAL\Types\Type;
use DrdPlus\Exceptionalities\Choices\EnumTypes\ExceptionalityChoiceType;
use DrdPlus\Exceptionalities\Choices\Fortune;
use DrdPlus\Exceptionalities\Choices\PlayerDecision;

class ExceptionalityChoiceTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_get_its_type_name()
    {
        self::assertSame('exceptionality_choice', ExceptionalityChoiceType::getTypeName());
        self::assertSame('exceptionality_choice', ExceptionalityChoiceType::EXCEPTIONALITY_CHOICE);
    }

    /**
     * @test
     */
    public function I_can_register_it_by_self()
    {
        ExceptionalityChoiceType::registerSelf();
        self::assertTrue(Type::hasType(ExceptionalityChoiceType::getTypeName()));
    }

    /**
     * @test
     */
    public function I_can_register_specific_choices()
    {
        ExceptionalityChoiceType::registerChoices();
        self::assertTrue(ExceptionalityChoiceType::hasSubTypeEnum(Fortune::class));
        self::assertTrue(ExceptionalityChoiceType::hasSubTypeEnum(PlayerDecision::class));
    }

}