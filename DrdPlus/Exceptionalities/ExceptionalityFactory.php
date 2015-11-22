<?php
namespace DrdPlus\Exceptionalities;

use DrdPlus\Exceptionalities\Choices\Fortune;
use DrdPlus\Exceptionalities\Choices\PlayerDecision;
use DrdPlus\Exceptionalities\Fates\FateOfCombination;
use DrdPlus\Exceptionalities\Fates\FateOfExceptionalProperties;
use DrdPlus\Exceptionalities\Fates\FateOfGoodRear;
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

    // FATES

    /**
     * @return FateOfCombination
     */
    public function getCombination()
    {
        return FateOfCombination::getIt();
    }

    /**
     * @return FateOfGoodRear
     */
    public function getGoodRear()
    {
        return FateOfGoodRear::getIt();
    }

    /**
     * @return FateOfExceptionalProperties
     */
    public function getExceptionalProperties()
    {
        return FateOfExceptionalProperties::getIt();
    }
}
