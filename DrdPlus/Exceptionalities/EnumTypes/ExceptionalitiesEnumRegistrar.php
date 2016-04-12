<?php
namespace DrdPlus\Exceptionalities\EnumTypes;

use DrdPlus\Exceptionalities\Choices\EnumTypes\ExceptionalityChoiceType;
use DrdPlus\Exceptionalities\Fates\EnumTypes\ExceptionalityFateType;
use DrdPlus\Properties\EnumTypes\PropertiesEnumRegistrar;

class ExceptionalitiesEnumRegistrar
{
    public static function registerAll()
    {
        ExceptionalityChoiceType::registerAll();
        ExceptionalityFateType::registerAll();

        PropertiesEnumRegistrar::registerAll();
    }
}