<?php
namespace DrdPlus\Exceptionalities\Fates\EnumTypes;

use Doctrineum\Strict\String\StrictStringEnumType;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFateOfCombination;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFateOfExceptionalProperties;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFateOfGoodRear;

class ExceptionalityFateType extends StrictStringEnumType
{
    const FATE = 'fate';

    public static function registerChoices()
    {
        if (!static::hasSubTypeEnum(ExceptionalityFateOfCombination::class)) {
            static::addSubTypeEnum(ExceptionalityFateOfCombination::class, '~^' . ExceptionalityFateOfCombination::FATE_OF_COMBINATION . '$~');
        }
        if (!static::hasSubTypeEnum(ExceptionalityFateOfExceptionalProperties::class)) {
            static::addSubTypeEnum(
                ExceptionalityFateOfExceptionalProperties::class,
                '~^' . ExceptionalityFateOfExceptionalProperties::FATE_OF_EXCEPTIONAL_PROPERTIES . '$~'
            );
        }
        if (!static::hasSubTypeEnum(ExceptionalityFateOfGoodRear::class)) {
            static::addSubTypeEnum(ExceptionalityFateOfGoodRear::class, '~^' . ExceptionalityFateOfGoodRear::FATE_OF_GOOD_REAR . '$~');
        }
    }
}