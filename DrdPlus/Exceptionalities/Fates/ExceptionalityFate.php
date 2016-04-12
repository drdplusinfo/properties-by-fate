<?php
namespace DrdPlus\Exceptionalities\Fates;

use Doctrineum\Scalar\ScalarEnum;
use DrdPlus\Exceptionalities\Templates\Integer1To6;
use Granam\String\StringTools;

abstract class ExceptionalityFate extends ScalarEnum
{
    /**
     * @return ExceptionalityFate
     */
    public static function getIt()
    {
        return static::getEnum(static::getCode());
    }

    public static function getCode()
    {
        return StringTools::camelToSnakeCaseBasename(static::class);
    }

    /**
     * @return int
     */
    abstract public function getPrimaryPropertiesBonusOnChoice();

    /**
     * @return int
     */
    abstract public function getSecondaryPropertiesBonusOnChoice();

    /**
     * @param Integer1To6 $roll
     *
     * @return int
     */
    abstract public function getPrimaryPropertyBonusOnFortune(Integer1To6 $roll);

    /**
     * @param Integer1To6 $roll
     *
     * @return int
     */
    abstract public function getSecondaryPropertyBonusOnFortune(Integer1To6 $roll);

    /**
     * @return int
     */
    abstract public function getUpToSingleProperty();

}
