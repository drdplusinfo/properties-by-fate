<?php
namespace DrdPlus\Exceptionalities\Fates;

use Drd\DiceRoll\RollInterface;

class ExceptionalityFateOfGoodRear extends AbstractExceptionalityFate
{
    const FATE_OF_GOOD_REAR = 'fate_of_good_rear';

    /**
     * @return int
     */
    public function getPrimaryPropertiesBonusOnChoice()
    {
        return 1;
    }

    /**
     * @return int
     */
    public function getSecondaryPropertiesBonusOnChoice()
    {
        return 2;
    }

    /**
     * @return int
     */
    public function getUpToSingleProperty()
    {
        return 1;
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
            case 3:
                return 0;
            case 4:
            case 5:
            case 6:
                return 1;
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
        // secondary and primary properties got same bonus
        return $this->getPrimaryPropertiesBonusOnFortune($roll);
    }

}
