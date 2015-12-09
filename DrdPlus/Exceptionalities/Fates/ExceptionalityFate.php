<?php
namespace DrdPlus\Exceptionalities\Fates;

use Doctrineum\Scalar\Enum;
use Drd\DiceRoll\RollInterface;

abstract class ExceptionalityFate extends Enum
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
        $classBaseName = preg_replace('~.+[\\\](\w+)$~', '$1', static::class);
        $basenameUnderscored = preg_replace('~.([A-Z])~', '_$1', $classBaseName);
        $code = strtolower($basenameUnderscored);

        return $code;
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
