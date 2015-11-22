<?php
namespace DrdPlus\Tests\Exceptionalities\Choices\EnumTypes;

use Doctrine\DBAL\Types\Type;
use DrdPlus\Exceptionalities\Fates\EnumTypes\ExceptionalityFateType;
use DrdPlus\Exceptionalities\Fates\FateOfCombination;
use DrdPlus\Exceptionalities\Fates\FateOfExceptionalProperties;
use DrdPlus\Exceptionalities\Fates\FateOfGoodRear;

class ExceptionalityFateTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_get_its_type_name()
    {
        $this->assertSame('exceptionality_fate', ExceptionalityFateType::getTypeName());
        $this->assertSame('exceptionality_fate', ExceptionalityFateType::EXCEPTIONALITY_FATE);
    }

    /**
     * @test
     */
    public function I_can_register_it_by_self()
    {
        ExceptionalityFateType::registerSelf();
        $this->assertTrue(Type::hasType(ExceptionalityFateType::getTypeName()));
    }

    /**
     * @test
     */
    public function I_can_register_specific_fates()
    {
        ExceptionalityFateType::registerFates();
        $this->assertTrue(ExceptionalityFateType::hasSubTypeEnum(FateOfCombination::class));
        $this->assertTrue(ExceptionalityFateType::hasSubTypeEnum(FateOfExceptionalProperties::class));
        $this->assertTrue(ExceptionalityFateType::hasSubTypeEnum(FateOfGoodRear::class));
    }

}