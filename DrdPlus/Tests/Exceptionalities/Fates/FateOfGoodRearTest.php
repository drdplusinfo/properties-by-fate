<?php
namespace DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\Fates;

use DrdPlus\Cave\UnitBundle\Tests\Person\Attributes\Exceptionalities\Fates\AbstractTestOfFate;

class FateOfGoodRearTest extends AbstractTestOfFate
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
