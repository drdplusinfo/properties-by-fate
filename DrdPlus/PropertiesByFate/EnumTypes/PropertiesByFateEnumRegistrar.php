<?php
namespace DrdPlus\PropertiesByFate\EnumTypes;

use DrdPlus\Codes\History\EnumTypes\FateCodeType;
use DrdPlus\Properties\EnumTypes\PropertiesEnumRegistrar;

class PropertiesByFateEnumRegistrar
{
    public static function registerAll()
    {
        FateCodeType::registerSelf();
        PropertiesEnumRegistrar::registerBaseProperties();
    }
}