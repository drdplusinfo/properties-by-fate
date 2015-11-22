<?php
namespace DrdPlus\Exceptionalities\Fates;

use DrdPlus\Tests\Exceptionalities\Fates\AbstractTestOfExceptionalityFate;

class FateOfGoodRearTest extends AbstractTestOfExceptionalityFate
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
}
