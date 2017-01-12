<?php
namespace DrdPlus\Tests\PropertiesByFate;

use Doctrine\DBAL\Types\Type;
use DrdPlus\Codes\EnumTypes\FateCodeType;
use DrdPlus\PropertiesByFate\EnumTypes\PropertiesByFateEnumRegistrar;
use Granam\Tests\Tools\TestWithMockery;

class PropertiesByFateEnumRegistrarTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_register_all_enums_at_once()
    {
        PropertiesByFateEnumRegistrar::registerAll();
        self::assertTrue(Type::hasType(FateCodeType::FATE_CODE));
    }
}