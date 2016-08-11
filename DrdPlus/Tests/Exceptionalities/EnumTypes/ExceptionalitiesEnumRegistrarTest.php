<?php
namespace DrdPlus\Tests\Exceptionalities;

use Doctrine\DBAL\Types\Type;
use DrdPlus\Exceptionalities\Choices\EnumTypes\ExceptionalityChoiceType;
use DrdPlus\Exceptionalities\EnumTypes\ExceptionalitiesEnumRegistrar;
use DrdPlus\Exceptionalities\Fates\EnumTypes\ExceptionalityFateType;
use Granam\Tests\Tools\TestWithMockery;

class ExceptionalitiesEnumRegistrarTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_register_all_enums_at_once()
    {
        ExceptionalitiesEnumRegistrar::registerAll();
        self::assertTrue(Type::hasType(ExceptionalityChoiceType::EXCEPTIONALITY_CHOICE));
        self::assertTrue(Type::hasType(ExceptionalityFateType::EXCEPTIONALITY_FATE));
    }
}