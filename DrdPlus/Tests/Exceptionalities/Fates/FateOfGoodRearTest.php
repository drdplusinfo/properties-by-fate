<?php
namespace DrdPlus\Tests\Exceptionalities\Fates;

class FateOfGoodRearTest extends ExceptionalityFateTest
{

    protected function getExpectedPrimaryPropertiesBonusOnChoice()
    {
        return 1;
    }

    protected function getExpectedSecondaryPropertiesBonusOnChoice()
    {
        return 2;
    }

    protected function getExpectedUpToSingleProperty()
    {
        return 1;
    }

    /**
     * @param int $value
     *
     * @return int
     */
    protected function getExpectedPrimaryPropertiesBonusOnFortune($value)
    {
        return (int)floor($value / 4);
    }

    /**
     * @param int $value
     * @return int
     */
    protected function getExpectedSecondaryPropertiesBonusOnFortune($value)
    {
        return (int)floor($value / 4);
    }

    protected function getExpectedFateCode()
    {
        return 'fate_of_good_rear';
    }

}
