<?php
namespace DrdPlus\Exceptionalities\Fates;

use DrdPlus\Tests\Exceptionalities\Fates\AbstractTestOfExceptionalityFate;

class FateOfCombinationTest extends AbstractTestOfExceptionalityFate
{

    protected function getExpectedPrimaryPropertiesBonusOnChoice()
    {
        return 2;
    }

    protected function getExpectedSecondaryPropertiesBonusOnChoice()
    {
        return 4;
    }

    protected function getExpectedUpToSingleProperty()
    {
        return 2;
    }

    /**
     * @param int $value
     *
     * @return int
     */
    protected function getExpectedPrimaryPropertiesBonusOnFortune($value)
    {
        return (int)round($value / 2) - 1;
    }

    /**
     * @param int $value
     * @return int
     */
    protected function getExpectedSecondaryPropertiesBonusOnFortune($value)
    {
        return (int)round($value / 2) - 1;
    }

}
