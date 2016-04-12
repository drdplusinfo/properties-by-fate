<?php
namespace DrdPlus\Exceptionalities\Fates\EnumTypes;

use Doctrineum\Scalar\ScalarEnumType;
use DrdPlus\Exceptionalities\Fates\FateOfCombination;
use DrdPlus\Exceptionalities\Fates\FateOfExceptionalProperties;
use DrdPlus\Exceptionalities\Fates\FateOfGoodRear;

class ExceptionalityFateType extends ScalarEnumType
{
    const EXCEPTIONALITY_FATE = 'exceptionality_fate';

    public static function registerAll()
    {
        self::registerSelf();
        if (!static::hasSubTypeEnum(FateOfCombination::class)) {
            static::addSubTypeEnum(FateOfCombination::class, '~^' . FateOfCombination::FATE_OF_COMBINATION . '$~');
        }
        if (!static::hasSubTypeEnum(FateOfExceptionalProperties::class)) {
            static::addSubTypeEnum(
                FateOfExceptionalProperties::class,
                '~^' . FateOfExceptionalProperties::FATE_OF_EXCEPTIONAL_PROPERTIES . '$~'
            );
        }
        if (!static::hasSubTypeEnum(FateOfGoodRear::class)) {
            static::addSubTypeEnum(FateOfGoodRear::class, '~^' . FateOfGoodRear::FATE_OF_GOOD_REAR . '$~');
        }
    }
}
