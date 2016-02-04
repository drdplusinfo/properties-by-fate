<?php
namespace DrdPlus\Exceptionalities\Fates;

use Drd\DiceRoll\RollInterface;
use Granam\Tools\ValueDescriber;

class FateOfCombination extends ExceptionalityFate
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
    public function getPrimaryPropertyBonusOnFortune(RollInterface $roll)
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
                throw new Exceptions\UnexpectedRoll(
                    'Unexpected roll value ' . ValueDescriber::describe($roll->getLastRollSummary())
                );
        }
    }

    /**
     * @param RollInterface $roll
     *
     * @return int
     */
    public function getSecondaryPropertyBonusOnFortune(RollInterface $roll)
    {
        // combination has same secondary and primary properties bonus
        return $this->getPrimaryPropertyBonusOnFortune($roll);
    }

}
