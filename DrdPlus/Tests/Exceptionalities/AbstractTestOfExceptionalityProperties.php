<?php
namespace DrdPlus\Tests\Exceptionalities;

use DrdPlus\Exceptionalities\ChosenProperties;
use DrdPlus\Exceptionalities\ExceptionalityProperties;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use DrdPlus\Tools\Tests\TestWithMockery;

abstract class AbstractTestOfExceptionalityProperties extends TestWithMockery
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
        $this->assertNotNull($instance);
        $this->assertNull($instance->getId());

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
        $this->assertSame($strength, $exceptionalityProperties->getStrength());
        $this->assertSame($strength, $exceptionalityProperties->getProperty(Strength::STRENGTH));
        $this->assertSame($agility, $exceptionalityProperties->getAgility());
        $this->assertSame($agility, $exceptionalityProperties->getProperty(Agility::AGILITY));
        $this->assertSame($knack, $exceptionalityProperties->getKnack());
        $this->assertSame($knack, $exceptionalityProperties->getProperty(Knack::KNACK));
        $this->assertSame($will, $exceptionalityProperties->getWill());
        $this->assertSame($will, $exceptionalityProperties->getProperty(Will::WILL));
        $this->assertSame($intelligence, $exceptionalityProperties->getIntelligence());
        $this->assertSame($intelligence, $exceptionalityProperties->getProperty(Intelligence::INTELLIGENCE));
        $this->assertSame($charisma, $exceptionalityProperties->getCharisma());
        $this->assertSame($charisma, $exceptionalityProperties->getProperty(Charisma::CHARISMA));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Exceptionalities\Exceptions\UnknownBasePropertyCode
     */
    public function I_can_not_use_invalid_property_code_for_generic_getter()
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

        $exceptionalityProperties->getProperty('invalid code');
    }
}
