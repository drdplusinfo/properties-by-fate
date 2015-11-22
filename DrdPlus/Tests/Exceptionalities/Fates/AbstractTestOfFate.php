<?php
namespace DrdPlus\Cave\UnitBundle\Tests\Person\Attributes\Exceptionalities\Fates;

use Doctrine\DBAL\Types\Type;
use DrdPlus\Cave\ToolsBundle\Dices\Roll;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\Fates\AbstractFate;
use DrdPlus\Cave\UnitBundle\Tests\TestWithMockery;

abstract class AbstractTestOfFate extends TestWithMockery
{
    /**
     * @test
     */
    public function type_name_is_as_expected()
    {
        $fateClass = $this->getFateClass();
        $this->assertSame($this->buildSpecificFateName(), $fateClass::getTypeName());
    }

    /**
     * @return string
     */
    protected function buildSpecificFateName()
    {
        $baseName = $this->getFateBaseName();
        $underScoredBaseName = preg_replace('~(\w)([A-Z])~', '$1_$2', $baseName);

        return strtolower($underScoredBaseName);
    }

    /**
     * @return string
     */
    protected function getFateBaseName()
    {
        $specificFateClass = $this->getFateClass();

        return preg_replace('~(\w+\\\)*(\w+)~', '$2', $specificFateClass);
    }

    /**
     * @return string|AbstractFate
     */
    protected function getFateClass()
    {
        return preg_replace('~Test$~', '', static::class);
    }

    /**
     * @test
     */
    public function can_register_self()
    {
        $fateClass = $this->getFateClass();
        $fateClass::registerSelf();
        $this->assertTrue(Type::hasType($fateClass::getTypeName()));
    }

    /**
     * @return AbstractFate
     *
     * @test
     * @depends can_register_self
     */
    public function can_create_self()
    {
        $exceptionalityClass = $this->getFateClass();
        $instance = $exceptionalityClass::getIt();
        $this->assertInstanceOf($exceptionalityClass, $instance);
        $expectedName = $this->buildSpecificFateName();
        $this->assertSame($expectedName, $instance->getTypeName());
        // as a self-typed single-value enum is the type name same as the enum value
        $this->assertSame($expectedName, $instance->getEnumValue());
        // kind is human shortcut for enum value
        $this->assertSame($expectedName, $instance->getFateName());

        return $instance;
    }

    /**
     * @param AbstractFate $kind
     *
     * @test
     * @depends can_create_self
     */
    public function gives_expected_primary_properties_bonus_on_chosen(AbstractFate $kind)
    {
        $this->assertSame($this->getExpectedPrimaryPropertiesBonusOnChoice(), $kind->getPrimaryPropertiesBonusOnChoice());
    }

    /**
     * @return int
     */
    abstract protected function getExpectedPrimaryPropertiesBonusOnChoice();

    /**
     * @param AbstractFate $kind
     *
     * @test
     * @depends can_create_self
     */
    public function gives_expected_secondary_properties_bonus_on_chosen(AbstractFate $kind)
    {
        $this->assertSame($this->getExpectedSecondaryPropertiesBonusOnChoice(), $kind->getSecondaryPropertiesBonusOnChoice());
    }

    /**
     * @return int
     */
    abstract protected function getExpectedSecondaryPropertiesBonusOnChoice();

    /**
     * @param AbstractFate $kind
     *
     * @test
     * @depends can_create_self
     */
    public function gives_expected_primary_properties_bonus_on_fortune(AbstractFate $kind)
    {
        foreach ([1, 2, 3, 4, 5, 6] as $value) {
            $roll = $this->mockery(Roll::class);
            $roll->shouldReceive('getRollSummary')
                ->andReturn($value);
            /** @var Roll $roll */
            $this->assertSame(
                $this->getExpectedPrimaryPropertiesBonusOnFortune($value),
                $kind->getPrimaryPropertiesBonusOnFortune($roll),
                "Value of $value should result to bonus {$this->getExpectedSecondaryPropertiesBonusOnFortune($value)}, but resulted into {$kind->getSecondaryPropertiesBonusOnFortune($roll)}"
            );
        }
    }

    /**
     * @param int $value
     * @return int
     */
    abstract protected function getExpectedPrimaryPropertiesBonusOnFortune($value);

    /**
     * @param AbstractFate $kind
     *
     * @test
     * @depends can_create_self
     */
    public function gives_expected_secondary_properties_bonus_on_fortune(AbstractFate $kind)
    {
        foreach ([1, 2, 3, 4, 5, 6] as $value) {
            $roll = $this->mockery(Roll::class);
            $roll->shouldReceive('getRollSummary')
                ->andReturn($value);
            /** @var Roll $roll */
            $this->assertSame(
                $this->getExpectedSecondaryPropertiesBonusOnFortune($value),
                $kind->getSecondaryPropertiesBonusOnFortune($roll),
                "Value of $value should result to bonus {$this->getExpectedSecondaryPropertiesBonusOnFortune($value)}, but resulted into {$kind->getSecondaryPropertiesBonusOnFortune($roll)}"
            );
        }
    }

    /**
     * @param int $value
     * @return int
     */
    abstract protected function getExpectedSecondaryPropertiesBonusOnFortune($value);

    /**
     * @param AbstractFate $abstractKind
     */
    public function gives_expected_up_to_single_property_limit(AbstractFate $abstractKind)
    {
        $this->assertSame($this->getExpectedUpToSingleProperty(), $abstractKind->getUpToSingleProperty());
    }

    /**
     * @return int
     */
    abstract protected function getExpectedUpToSingleProperty();
}
