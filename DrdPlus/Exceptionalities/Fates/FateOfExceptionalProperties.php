<?php
namespace DrdPlus\Exceptionalities\Fates;

use Drd\DiceRoll\RollInterface;
use Granam\Tools\ValueDescriber;

class FateOfExceptionalProperties extends ExceptionalityFate
{
    const FATE_OF_EXCEPTIONAL_PROPERTIES = 'fate_of_exceptional_properties';
    /**
     * @return int
     */
    public function getPrimaryPropertiesBonusOnChoice()
    {
        return 3;
    }

    /**
     * @return int
     */
    public function getSecondaryPropertiesBonusOnChoice()
    {
        return 6;
    }

    /**
     * @return int
     */
    public function getUpToSingleProperty()
    {
        return 3;
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
            case 3:
                return 1;
            case 4:
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
        switch ($roll->getLastRollSummary()) {
            case 1:
                return 0;
            case 2:
            case 3:
                return 1;
            case 4:
            case 5:
                return 2;
            case 6:
                return 3;
            default:
                throw new Exceptions\UnexpectedRoll(
                    'Unexpected roll value ' . ValueDescriber::describe($roll->getLastRollSummary())
                );
        }
    }

}
