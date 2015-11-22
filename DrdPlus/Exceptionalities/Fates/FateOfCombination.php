<?php
namespace DrdPlus\Exceptionalities\Fates;

use Drd\DiceRoll\RollInterface;

class ExceptionalityFateOfCombination extends AbstractExceptionalityFate
{
    const FATE_OF_COMBINATION = 'fate_of_combination';

    /**
     * @return int
     */
    public function getPrimaryPropertiesBonusOnChoice()
    {
        return 2;
    }

    /**
     * @return int
     */
    public function getSecondaryPropertiesBonusOnChoice()
    {
        return 4;
    }

    /**
     * @return int
     */
    public function getUpToSingleProperty()
    {
        return 2;
    }

    /**
     * @param RollInterface $roll
     *
     * @return int
     */
    public function getPrimaryPropertiesBonusOnFortune(RollInterface $roll)
    {
        switch ($roll->getLastRollSummary()) {
            case 1:
            case 2:
                return 0;
            case 3:
            case 4:
                return 1;
            case 5:
            case 6:
                return 2;
            default:
                throw new \RuntimeException(
                    'Unexpected roll value ' . var_export($roll->getLastRollSummary(), true)
                );
        }
    }

    /**
     * @param RollInterface $roll
     *
     * @return int
     */
    public function getSecondaryPropertiesBonusOnFortune(RollInterface $roll)
    {
        // combination has same secondary and primary properties bonus
        return $this->getPrimaryPropertiesBonusOnFortune($roll);
    }

}
