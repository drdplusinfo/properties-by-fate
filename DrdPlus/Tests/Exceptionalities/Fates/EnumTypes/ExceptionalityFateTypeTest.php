<?php
namespace DrdPlus\Tests\Exceptionalities\Fates\EnumTypes;

use Doctrine\DBAL\Types\Type;
use Doctrineum\Tests\SelfRegisteringType\AbstractSelfRegisteringTypeTest;
use DrdPlus\Exceptionalities\Fates\EnumTypes\ExceptionalityFateType;
use DrdPlus\Exceptionalities\Fates\FateOfCombination;
use DrdPlus\Exceptionalities\Fates\FateOfExceptionalProperties;
use DrdPlus\Exceptionalities\Fates\FateOfGoodRear;

class ExceptionalityFateTypeTest extends AbstractSelfRegisteringTypeTest
{
    /**
     * @test
     */
    public function I_can_register_it_and_specific_fates_by_self()
    {
        ExceptionalityFateType::registerAll();
        self::assertTrue(Type::hasType($this->getExpectedTypeName()));
        self::assertTrue(ExceptionalityFateType::hasSubTypeEnum(FateOfCombination::class));
        self::assertTrue(ExceptionalityFateType::hasSubTypeEnum(FateOfExceptionalProperties::class));
        self::assertTrue(ExceptionalityFateType::hasSubTypeEnum(FateOfGoodRear::class));
    }

}