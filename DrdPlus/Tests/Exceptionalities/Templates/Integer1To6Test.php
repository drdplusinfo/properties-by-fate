<?php
namespace DrdPlus\Tests\Exceptionalities\Templates;

use DrdPlus\Exceptionalities\Templates\Integer1To6;
use Granam\Integer\IntegerInterface;

class Integer1To6Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        for($value = 1; $value <=6; $value++) {
            $integer1to6 = new Integer1To6($value);
            self::assertInstanceOf(IntegerInterface::class, $integer1to6);
            self::assertSame($value, $integer1to6->getValue());
        }
    }

    /**
     * @test
     * @expectedException \DrdPlus\Exceptionalities\Templates\Exceptions\ValueNotInRange
     */
    public function I_can_not_create_it_with_lesser_than_one()
    {
        new Integer1To6(-1);
    }
    /**
     * @test
     * @expectedException \DrdPlus\Exceptionalities\Templates\Exceptions\ValueNotInRange
     */
    public function I_can_not_create_it_with_higher_than_six()
    {
        new Integer1To6(7);
    }
}
