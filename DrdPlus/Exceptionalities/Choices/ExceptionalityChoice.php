<?php
namespace DrdPlus\Exceptionalities\Choices;

use Doctrineum\Strict\String\StrictStringEnum;

abstract class ExceptionalityChoice extends StrictStringEnum
{

    /**
     * @param string $choiceName
     * @return ExceptionalityChoice
     */
    protected static function getIt($choiceName)
    {
        return static::getEnum($choiceName);
    }
}
