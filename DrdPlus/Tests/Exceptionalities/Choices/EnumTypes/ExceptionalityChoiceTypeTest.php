<?php
namespace DrdPlus\Tests\Exceptionalities\Choices\EnumTypes;

use Doctrine\DBAL\Types\Type;
use Doctrineum\Tests\SelfRegisteringType\AbstractSelfRegisteringTypeTest;
use DrdPlus\Exceptionalities\Choices\EnumTypes\ExceptionalityChoiceType;
use DrdPlus\Exceptionalities\Choices\Fortune;
use DrdPlus\Exceptionalities\Choices\PlayerDecision;

class ExceptionalityChoiceTypeTest extends AbstractSelfRegisteringTypeTest
{
    /**
     * @test
     */
    public function I_can_register_it_and_specific_choices_by_self()
    {
        ExceptionalityChoiceType::registerAll();
        self::assertTrue(Type::hasType($this->getExpectedTypeName()));
        self::assertTrue(ExceptionalityChoiceType::hasSubTypeEnum(Fortune::class));
        self::assertTrue(ExceptionalityChoiceType::hasSubTypeEnum(PlayerDecision::class));
    }

}