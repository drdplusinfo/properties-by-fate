<?php
namespace DrdPlus\Exceptionalities\Choices;

use Doctrineum\Scalar\ScalarEnum;
use Granam\String\StringTools;

abstract class ExceptionalityChoice extends ScalarEnum
{

    /**
     * @return ExceptionalityChoice
     */
    protected static function getIt()
    {
        return static::getEnum(static::getCode());
    }

    public static function getCode()
    {
        return StringTools::camelCaseToSnakeCasedBasename(static::class);
    }
}
