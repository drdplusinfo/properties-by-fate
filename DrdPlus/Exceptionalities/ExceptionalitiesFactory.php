<?php
namespace DrdPlus\Exceptionalities;

use DrdPlus\Exceptionalities\Choices\Fortune;
use DrdPlus\Exceptionalities\Choices\PlayerDecision;
use DrdPlus\Exceptionalities\Fates\FateOfCombination;
use DrdPlus\Exceptionalities\Fates\FateOfExceptionalProperties;
use DrdPlus\Exceptionalities\Fates\FateOfGoodRear;
use Granam\Scalar\Tools\ToString;
use Granam\Tools\ValueDescriber;
use Granam\Strict\Object\StrictObject;

class ExceptionalitiesFactory extends StrictObject
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
        switch (ToString::toString($choiceCode)) {
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
    public function getFateOfGoodRear()
    {
        return FateOfGoodRear::getIt();
    }

    /**
     * @return FateOfCombination
     */
    public function getFateOfCombination()
    {
        return FateOfCombination::getIt();
    }

    /**
     * @return FateOfExceptionalProperties
     */
    public function getFateOfExceptionalProperties()
    {
        return FateOfExceptionalProperties::getIt();
    }

    public function getFate($fateCode)
    {
        switch (ToString::toString($fateCode)) {
            case FateOfGoodRear::FATE_OF_GOOD_REAR :
                return $this->getFateOfGoodRear();
            case FateOfCombination::FATE_OF_COMBINATION :
                return $this->getFateOfCombination();
            case FateOfExceptionalProperties::FATE_OF_EXCEPTIONAL_PROPERTIES :
                return $this->getFateOfExceptionalProperties();
            default :
                throw new Exceptions\UnknownExceptionalityFate(
                    'Unknown exceptionality fate code ' . ValueDescriber::describe($fateCode)
                );
        }
    }

}
