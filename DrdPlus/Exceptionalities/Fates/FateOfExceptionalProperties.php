<?php
namespace DrdPlus\Exceptionalities\Fates;

use DrdPlus\Exceptionalities\Templates\Integer1To6;
use Granam\Tools\ValueDescriber;

class FateOfExceptionalProperties extends ExceptionalityFate
{
    const FATE_OF_EXCEPTIONAL_PROPERTIES = 'fate_of_exceptional_properties';

    /**
     * @return FateOfExceptionalProperties
     */
    public static function getIt()
    {
        return parent::getIt();
    }

    /**
     * @return string
     */
    public static function getCode()
    {
        return parent::getCode();
    }

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
     * @param Integer1to6 $roll
     *
     * @return int
     */
    public function getPrimaryPropertyBonusOnFortune(Integer1To6 $roll)
    {
        switch ($roll->getValue()) {
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
                    'Unexpected roll value ' . ValueDescriber::describe($roll->getValue())
                );
        }
    }

    /**
     * @param Integer1to6 $roll
     *
     * @return int
     */
    public function getSecondaryPropertyBonusOnFortune(Integer1to6 $roll)
    {
        switch ($roll->getValue()) {
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
                    'Unexpected roll value ' . ValueDescriber::describe($roll->getValue())
                );
        }
    }

}
