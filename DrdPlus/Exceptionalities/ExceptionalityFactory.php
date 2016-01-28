<?php
namespace DrdPlus\Exceptionalities;

use DrdPlus\Exceptionalities\Choices\Fortune;
use DrdPlus\Exceptionalities\Choices\PlayerDecision;
use DrdPlus\Exceptionalities\Fates\FateOfCombination;
use DrdPlus\Exceptionalities\Fates\FateOfExceptionalProperties;
use DrdPlus\Exceptionalities\Fates\FateOfGoodRear;
use Granam\Scalar\Tools\ValueDescriber;
use Granam\Strict\Object\StrictObject;

class ExceptionalityFactory extends StrictObject
{

    // CHOICES

    /**
     * @return PlayerDecision
     */
    public function getPlayerDecision()
    {
        return PlayerDecision::getIt();
    }

    /**
     * @return Fortune
     */
    public function getFortune()
    {
        return Fortune::getIt();
    }

    public function getChoice($choiceCode)
    {
        switch ($choiceCode) {
            case PlayerDecision::PLAYER_DECISION :
                return $this->getPlayerDecision();
            case Fortune::FORTUNE :
                return $this->getFortune();
            default :
                throw new Exceptions\UnknownExceptionalityChoice(
                    'Unknown exceptionality choice code ' . ValueDescriber::describe($choiceCode)
                );
        }
    }

    // FATES

    /**
     * @return FateOfGoodRear
     */
    public function getGoodRear()
    {
        return FateOfGoodRear::getIt();
    }

    /**
     * @return FateOfCombination
     */
    public function getCombination()
    {
        return FateOfCombination::getIt();
    }

    /**
     * @return FateOfExceptionalProperties
     */
    public function getExceptionalProperties()
    {
        return FateOfExceptionalProperties::getIt();
    }
}
