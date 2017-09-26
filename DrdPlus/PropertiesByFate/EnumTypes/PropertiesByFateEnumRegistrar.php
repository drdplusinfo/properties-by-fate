<?php
namespace DrdPlus\PropertiesByFate\EnumTypes;

use DrdPlus\Codes\History\EnumTypes\ChoiceCodeType;
use DrdPlus\Codes\History\EnumTypes\FateCodeType;
use DrdPlus\Properties\EnumTypes\PropertiesEnumRegistrar;

class PropertiesByFateEnumRegistrar
{
    public static function registerAll(): void
    {
        FateCodeType::registerSelf();
        ChoiceCodeType::registerSelf();
        PropertiesEnumRegistrar::registerBaseProperties();
    }
}