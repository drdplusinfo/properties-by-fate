<?php
namespace DrdPlus\Exceptionalities\Choices;

use Doctrineum\Strict\String\StrictStringEnum;

abstract class ExceptionalityChoice extends StrictStringEnum
{

    /**
     * @return ExceptionalityChoice
     */
    public static function getIt()
    {
        return static::getEnum(static::getCode());
    }

    public static function getCode()
    {
        $classBaseName = preg_replace('~.+[\\\](\w+)$~', '$1', static::class);
        $basenameUnderscored = preg_replace('~.([A-Z])~', '_$1', $classBaseName);
        $code = strtolower($basenameUnderscored);

        return $code;
    }
}
