<?php
namespace DrdPlus\Tests\Exceptionalities\Properties;

use DrdPlus\Exceptionalities\Properties\ChosenProperties;
use DrdPlus\Exceptionalities\Properties\ExceptionalityProperties;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use Granam\Tests\Tools\TestWithMockery;

abstract class ExceptionalityPropertiesTest extends TestWithMockery
{
    /**
     * @return ExceptionalityProperties
     *
     * @test
     */
    public function I_can_create_it()
    {
        $className = $this->getClassName();
        $instance = new $className(
            $this->getStrength(),
            $this->getAgility(),
            $this->getKnack(),
            $this->getWill(),
            $this->getIntelligence(),
            $this->getCharisma()
        );

        /** @var ChosenProperties $instance */
        self::assertNotNull($instance);
        self::assertNull($instance->getId());

        return $instance;
    }

    /**
     * @return string
     */
    protected function getClassName()
    {
        $testClassName = static::class;

        return preg_replace('~Test(s[\\\])?~', '', $testClassName);
    }

    /**
     * @return \Mockery\MockInterface|Strength
     */
    protected function getStrength()
    {
        return $this->mockery(Strength::class);
    }

    /**
     * @return \Mockery\MockInterface|Agility
     */
    protected function getAgility()
    {
        return $this->mockery(Agility::class);
    }

    /**
     * @return \Mockery\MockInterface|Knack
     */
    protected function getKnack()
    {
        return $this->mockery(Knack::class);
    }

    /**
     * @return \Mockery\MockInterface|Will
     */
    protected function getWill()
    {
        return $this->mockery(Will::class);
    }

    /**
     * @return \Mockery\MockInterface|Intelligence
     */
    protected function getIntelligence()
    {
        return $this->mockery(Intelligence::class);
    }

    /**
     * @return \Mockery\MockInterface|Charisma
     */
    protected function getCharisma()
    {
        return $this->mockery(Charisma::class);
    }

    /**
     * @test
     * @depends I_can_create_it
     */
    public function I_can_get_every_property()
    {
        $className = $this->getClassName();
        /** @var ExceptionalityProperties $exceptionalityProperties */
        $exceptionalityProperties = new $className(
            $strength = $this->getStrength(),
            $agility = $this->getAgility(),
            $knack = $this->getKnack(),
            $will = $this->getWill(),
            $intelligence = $this->getIntelligence(),
            $charisma = $this->getCharisma()
        );
        self::assertSame($strength, $exceptionalityProperties->getStrength());
        self::assertSame($strength, $exceptionalityProperties->getProperty(Strength::STRENGTH));
        self::assertSame($agility, $exceptionalityProperties->getAgility());
        self::assertSame($agility, $exceptionalityProperties->getProperty(Agility::AGILITY));
        self::assertSame($knack, $exceptionalityProperties->getKnack());
        self::assertSame($knack, $exceptionalityProperties->getProperty(Knack::KNACK));
        self::assertSame($will, $exceptionalityProperties->getWill());
        self::assertSame($will, $exceptionalityProperties->getProperty(Will::WILL));
        self::assertSame($intelligence, $exceptionalityProperties->getIntelligence());
        self::assertSame($intelligence, $exceptionalityProperties->getProperty(Intelligence::INTELLIGENCE));
        self::assertSame($charisma, $exceptionalityProperties->getCharisma());
        self::assertSame($charisma, $exceptionalityProperties->getProperty(Charisma::CHARISMA));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Exceptionalities\Properties\Exceptions\UnknownBasePropertyCode
     */
    public function I_can_not_use_invalid_property_code_for_generic_getter()
    {
        $exceptionalityProperties = $this->createExceptionalityProperties();

        $exceptionalityProperties->getProperty('invalid code');
    }

    /**
     * @return ExceptionalityProperties
     */
    abstract protected function createExceptionalityProperties();

    /**
     * @test
     * @expectedException \DrdPlus\Exceptionalities\Properties\Exceptions\UnknownBasePropertyCode
     */
    public function I_can_not_use_true_as_property_code_for_generic_getter()
    {
        $exceptionalityProperties = $this->createExceptionalityProperties();

        $exceptionalityProperties->getProperty(true);
    }
}
