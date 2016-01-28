<?php
namespace DrdPlus\Exceptionalities\Choices;

use Doctrineum\Scalar\ScalarEnum;
use Granam\Tools\Naming;

abstract class ExceptionalityChoice extends ScalarEnum
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
        return Naming::camelCaseClassToSnakeCase(static::class);
    }
}
