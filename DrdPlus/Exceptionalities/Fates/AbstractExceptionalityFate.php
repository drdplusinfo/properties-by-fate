<?php
namespace DrdPlus\Exceptionalities\Fates;

use Doctrineum\Strict\String\StrictStringEnum;
use Drd\DiceRoll\RollInterface;

abstract class AbstractExceptionalityFate extends StrictStringEnum
{
    /**
     * @return AbstractExceptionalityFate
     */
    public static function getIt()
    {
        return static::getEnum(static::getFateName());
    }

    /**
     * @param string $fateName
     *
     * @return AbstractExceptionalityFate
     */
    protected static function createByValue($fateName)
    {
        $exceptionality = parent::createByValue($fateName);
        /** @var $exceptionality AbstractExceptionalityFate */
        if ($exceptionality::getFateName() !== $fateName) {
            throw new \LogicException(
                'Given exceptionality type ' . var_export($fateName, true) .
                ' results into exceptionality ' . get_class($exceptionality) . ' with type ' . var_export($exceptionality::getFateName(), true) . '.'
            );
        }

        return $exceptionality;
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
    abstract public function getPrimaryPropertiesBonusOnFortune(RollInterface $roll);

    /**
     * @param RollInterface $roll
     *
     * @return int
     */
    abstract public function getSecondaryPropertiesBonusOnFortune(RollInterface $roll);

    /**
     * @return int
     */
    abstract public function getUpToSingleProperty();

}
