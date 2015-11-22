<?php
namespace DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\Fates;

use DrdPlus\Cave\UnitBundle\Tests\Person\Attributes\Exceptionalities\Fates\AbstractTestOfFate;

class FateOfCombinationTest extends AbstractTestOfFate
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
