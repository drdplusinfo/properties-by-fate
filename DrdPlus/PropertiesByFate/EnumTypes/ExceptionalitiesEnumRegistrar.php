<?php
namespace DrdPlus\PropertiesByFate\EnumTypes;

use DrdPlus\Codes\EnumTypes\FateCodeType;
use DrdPlus\Properties\EnumTypes\PropertiesEnumRegistrar;

class ExceptionalitiesEnumRegistrar
{
    public static function registerAll()
    {
        FateCodeType::registerSelf();
        PropertiesEnumRegistrar::registerBaseProperties();
    }
}