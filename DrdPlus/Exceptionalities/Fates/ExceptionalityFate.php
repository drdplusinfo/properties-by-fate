<?php
namespace DrdPlus\Exceptionalities\Fates;

use Doctrineum\Scalar\ScalarEnum;
use Drd\DiceRoll\RollInterface;
use Granam\Tools\Naming;

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
        return Naming::camelCaseClassToSnakeCase(static::class);
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
     * @param RollInterface $roll
     *
     * @return int
     */
    abstract public function getPrimaryPropertyBonusOnFortune(RollInterface $roll);

    /**
     * @param RollInterface $roll
     *
     * @return int
     */
    abstract public function getSecondaryPropertyBonusOnFortune(RollInterface $roll);

    /**
     * @return int
     */
    abstract public function getUpToSingleProperty();

}
