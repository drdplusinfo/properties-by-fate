<?php
namespace DrdPlus\Tests\Exceptionalities\Fates;

use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use DrdPlus\Exceptionalities\Templates\Integer1To6;
use Granam\Tests\Tools\TestWithMockery;

abstract class AbstractTestOfExceptionalityFate extends TestWithMockery
{

    /**
     * @return ExceptionalityFate
     *
     * @test
     */
    public function I_can_create_it_by_self()
    {
        $exceptionalityClass = $this->getFateClass();
        $instance = $exceptionalityClass::getIt();
        $this->assertInstanceOf($exceptionalityClass, $instance);

        return $instance;
    }

    /**
     * @return string|ExceptionalityFate
     */
    protected function getFateClass()
    {
        return preg_replace('~Test$~', '', static::class);
    }

    /**
     * @param ExceptionalityFate $fate
     *
     * @test
     * @depends I_can_create_it_by_self
     */
    public function I_can_get_properties_bonus_on_choice(ExceptionalityFate $fate)
    {
        $this->assertSame(
            $this->getExpectedPrimaryPropertiesBonusOnChoice(),
            $fate->getPrimaryPropertiesBonusOnChoice()
        );
        $this->assertSame(
            $this->getExpectedSecondaryPropertiesBonusOnChoice(),
            $fate->getSecondaryPropertiesBonusOnChoice()
        );
    }

    /**
     * @return int
     */
    abstract protected function getExpectedPrimaryPropertiesBonusOnChoice();

    /**
     * @return int
     */
    abstract protected function getExpectedSecondaryPropertiesBonusOnChoice();

    /**
     * @param ExceptionalityFate $kind
     *
     * @test
     * @depends I_can_create_it_by_self
     */
    public function I_can_get_properties_bonus_on_fortune(ExceptionalityFate $kind)
    {
        foreach ([1, 2, 3, 4, 5, 6] as $value) {
            $roll = $this->mockery(Integer1To6::class);
            $roll->shouldReceive('getValue')
                ->andReturn($value);
            /** @var Integer1to6 $roll */
            $this->assertSame(
                $this->getExpectedPrimaryPropertiesBonusOnFortune($value),
                $kind->getPrimaryPropertyBonusOnFortune($roll),
                "Value of $value should result to bonus {$this->getExpectedSecondaryPropertiesBonusOnFortune($value)}"
                . ", but resulted into {$kind->getSecondaryPropertyBonusOnFortune($roll)}"
            );
            $this->assertSame(
                $this->getExpectedSecondaryPropertiesBonusOnFortune($value),
                $kind->getSecondaryPropertyBonusOnFortune($roll),
                "Value of $value should result to bonus {$this->getExpectedSecondaryPropertiesBonusOnFortune($value)}"
                . ", but resulted into {$kind->getSecondaryPropertyBonusOnFortune($roll)}"
            );
        }
    }

    /**
     * @param ExceptionalityFate $fate
     *
     * @test
     * @depends I_can_create_it_by_self
     * @expectedException \DrdPlus\Exceptionalities\Fates\Exceptions\UnexpectedRoll
     */
    public function I_can_not_use_unexpected_roll_for_primary_property_on_fortune(ExceptionalityFate $fate)
    {
        $roll = $this->mockery(Integer1to6::class);
        $roll->shouldReceive('getValue')
            ->andReturn(7);
        /** @var Integer1to6 $roll */
        $fate->getPrimaryPropertyBonusOnFortune($roll);
    }

    /**
     * @param ExceptionalityFate $fate
     *
     * @test
     * @depends I_can_create_it_by_self
     * @expectedException \DrdPlus\Exceptionalities\Fates\Exceptions\UnexpectedRoll
     */
    public function I_can_not_use_unexpected_roll_for_secondary_property_on_fortune(ExceptionalityFate $fate)
    {
        $roll = $this->mockery(Integer1to6::class);
        $roll->shouldReceive('getValue')
            ->andReturn(7);
        /** @var Integer1to6 $roll */
        $fate->getSecondaryPropertyBonusOnFortune($roll);
    }

    /**
     * @param int $value
     * @return int
     */
    abstract protected function getExpectedPrimaryPropertiesBonusOnFortune($value);

    /**
     * @param int $value
     * @return int
     */
    abstract protected function getExpectedSecondaryPropertiesBonusOnFortune($value);

    /**
     * @param ExceptionalityFate $fate
     * @test
     * @depends I_can_create_it_by_self
     */
    public function I_can_get_up_to_single_property_limit(ExceptionalityFate $fate)
    {
        $this->assertSame($this->getExpectedUpToSingleProperty(), $fate->getUpToSingleProperty());
    }

    /**
     * @return int
     */
    abstract protected function getExpectedUpToSingleProperty();

    /**
     * @test
     */
    public function I_can_get_choice_code()
    {
        $fateClass = $this->getFateClass();
        $this->assertSame(
            $this->getExpectedFateCode(),
            $fateClass::getCode()
        );
        $codeConstantName = $this->getCodeConstantName();
        $this->assertSame(
            $this->getExpectedFateCode(),
            constant("$fateClass::$codeConstantName")
        );
    }

    /**
     * @return string
     */
    abstract protected function getExpectedFateCode();

    private function getCodeConstantName()
    {
        $code = $this->getExpectedFateCode();

        return strtoupper($code);
    }
}
