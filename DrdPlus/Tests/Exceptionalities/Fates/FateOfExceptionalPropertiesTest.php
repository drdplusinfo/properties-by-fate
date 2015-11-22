<?php
namespace DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\Fates;

use DrdPlus\Cave\UnitBundle\Tests\Person\Attributes\Exceptionalities\Fates\AbstractTestOfFate;

class FateOfExceptionalPropertiesTest extends AbstractTestOfFate
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
}
