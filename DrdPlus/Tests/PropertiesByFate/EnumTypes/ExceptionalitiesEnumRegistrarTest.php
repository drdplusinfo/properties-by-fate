<?php
namespace DrdPlus\Tests\PropertiesByFate;

use Doctrine\DBAL\Types\Type;
use DrdPlus\Codes\EnumTypes\FateCodeType;
use DrdPlus\PropertiesByFate\EnumTypes\ExceptionalitiesEnumRegistrar;
use Granam\Tests\Tools\TestWithMockery;

class ExceptionalitiesEnumRegistrarTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_register_all_enums_at_once()
    {
        ExceptionalitiesEnumRegistrar::registerAll();
        self::assertTrue(Type::hasType(FateCodeType::FATE_CODE));
    }
}