<?php
namespace DrdPlus\Exceptionalities\Choices\EnumTypes;

use Doctrineum\Scalar\EnumType;
use DrdPlus\Exceptionalities\Choices\Fortune;
use DrdPlus\Exceptionalities\Choices\PlayerDecision;

class ExceptionalityChoiceType extends EnumType
{
    const EXCEPTIONALITY_CHOICE = 'exceptionality_choice';

    public static function registerChoices()
    {
        if (!static::hasSubTypeEnum(Fortune::class)) {
            static::addSubTypeEnum(Fortune::class, '~^' . Fortune::FORTUNE . '$~');
        }
        if (!static::hasSubTypeEnum(PlayerDecision::class)) {
            static::addSubTypeEnum(PlayerDecision::class, '~^' . PlayerDecision::PLAYER_DECISION . '$~');
        }
    }
}
