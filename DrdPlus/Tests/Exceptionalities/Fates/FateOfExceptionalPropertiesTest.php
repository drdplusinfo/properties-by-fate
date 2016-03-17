<?php
namespace DrdPlus\Exceptionalities\Fates;

use DrdPlus\Tests\Exceptionalities\Fates\AbstractTestOfExceptionalityFate;

class FateOfExceptionalPropertiesTest extends AbstractTestOfExceptionalityFate
{

    protected function getExpectedPrimaryPropertiesBonusOnChoice()
    {
        return 3;
    }

    protected function getExpectedSecondaryPropertiesBonusOnChoice()
    {
        return 6;
    }

    protected function getExpectedUpToSingleProperty()
    {
        return 3;
    }

    /**
     * @param int $value
     *
     * @return int
     */
    protected function getExpectedPrimaryPropertiesBonusOnFortune($value)
    {
        return (int)ceil($value / 3);
    }

    /**
     * @param int $value
     * @return int
     */
    protected function getExpectedSecondaryPropertiesBonusOnFortune($value)
    {
        return (int)floor($value / 2);
    }

    protected function getExpectedFateCode()
    {
        return 'fate_of_exceptional_properties';
    }

}
