<?php
namespace DrdPlus\Exceptionalities;

use DrdPlus\Exceptionalities\Choices\Fortune;
use DrdPlus\Exceptionalities\Choices\PlayerDecision;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFateOfCombination;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFateOfExceptionalProperties;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFateOfGoodRear;
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
     * @return ExceptionalityFateOfCombination
     */
    public function getCombination()
    {
        return ExceptionalityFateOfCombination::getIt();
    }

    /**
     * @return ExceptionalityFateOfGoodRear
     */
    public function getGoodRear()
    {
        return ExceptionalityFateOfGoodRear::getIt();
    }

    /**
     * @return ExceptionalityFateOfExceptionalProperties
     */
    public function getExceptionalProperties()
    {
        return ExceptionalityFateOfExceptionalProperties::getIt();
    }
}
