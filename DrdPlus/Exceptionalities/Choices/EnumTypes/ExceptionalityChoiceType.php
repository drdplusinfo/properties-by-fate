<?php
namespace DrdPlus\Exceptionalities\Choices\EnumTypes;

use Doctrineum\Scalar\ScalarEnumType;
use DrdPlus\Exceptionalities\Choices\Fortune;
use DrdPlus\Exceptionalities\Choices\PlayerDecision;

class ExceptionalityChoiceType extends ScalarEnumType
{
    const EXCEPTIONALITY_CHOICE = 'exceptionality_choice';

    public static function registerAll()
    {
        ExceptionalityChoiceType::registerSelf();
        if (!static::hasSubTypeEnum(Fortune::class)) {
            static::addSubTypeEnum(Fortune::class, '~^' . Fortune::FORTUNE . '$~');
        }
        if (!static::hasSubTypeEnum(PlayerDecision::class)) {
            static::addSubTypeEnum(PlayerDecision::class, '~^' . PlayerDecision::PLAYER_DECISION . '$~');
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::EXCEPTIONALITY_CHOICE;
    }
}
