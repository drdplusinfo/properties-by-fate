<?php
namespace DrdPlus\Tests\Exceptionalities\Properties;

use DrdPlus\Exceptionalities\Properties\FortuneProperties;
use DrdPlus\Exceptionalities\Templates\Integer1To6;

class FortunePropertiesTest extends ExceptionalityPropertiesTest
{
    /**
     * @return FortuneProperties
     *
     * @test
     */
    public function I_can_create_it()
    {
        $className = $this->getClassName();
        $instance = new $className(
            $this->getStrength(),
            $this->getRoll(),
            $this->getAgility(),
            $this->getRoll(),
            $this->getKnack(),
            $this->getRoll(),
            $this->getWill(),
            $this->getRoll(),
            $this->getIntelligence(),
            $this->getRoll(),
            $this->getCharisma(),
            $this->getRoll()
        );

        self::assertNotNull($instance);

        return $instance;
    }

    /**
     * @param $value = null
     * @return \Mockery\MockInterface|Integer1To6
     */
    protected function getRoll($value = null)
    {
        $roll = $this->mockery(Integer1To6::class);
        $roll->shouldReceive('getValue')
            ->andReturn($value);

        return $roll;
    }

    /**
     * @test
     * @depends I_can_create_it
     */
    public function I_can_get_every_property()
    {
        $fortuneProperties = new FortuneProperties(
            $strength = $this->getStrength(),
            $this->getRoll(),
            $agility = $this->getAgility(),
            $this->getRoll(),
            $knack = $this->getKnack(),
            $this->getRoll(),
            $will = $this->getWill(),
            $this->getRoll(),
            $intelligence = $this->getIntelligence(),
            $this->getRoll(),
            $charisma = $this->getCharisma(),
            $this->getRoll()
        );
        self::assertSame($strength, $fortuneProperties->getStrength());
        self::assertSame($agility, $fortuneProperties->getAgility());
        self::assertSame($knack, $fortuneProperties->getKnack());
        self::assertSame($will, $fortuneProperties->getWill());
        self::assertSame($intelligence, $fortuneProperties->getIntelligence());
        self::assertSame($charisma, $fortuneProperties->getCharisma());
    }

    /**
     * @test
     */
    public function I_can_get_every_dice_roll()
    {
        $fortuneProperties = new FortuneProperties(
            $this->getStrength(),
            $this->getRoll($strengthRoll = 1),
            $this->getAgility(),
            $this->getRoll($agilityRoll = 2),
            $this->getKnack(),
            $this->getRoll($knackRoll = 3),
            $this->getWill(),
            $this->getRoll($willRoll = 4),
            $this->getIntelligence(),
            $this->getRoll($intelligenceRoll = 5),
            $this->getCharisma(),
            $this->getRoll($charismaRoll = 6)
        );
        self::assertSame($strengthRoll, $fortuneProperties->getStrengthRoll());
        self::assertSame($agilityRoll, $fortuneProperties->getAgilityRoll());
        self::assertSame($knackRoll, $fortuneProperties->getKnackRoll());
        self::assertSame($willRoll, $fortuneProperties->getWillRoll());
        self::assertSame($intelligenceRoll, $fortuneProperties->getIntelligenceRoll());
        self::assertSame($charismaRoll, $fortuneProperties->getCharismaRoll());
    }

    protected function createExceptionalityProperties()
    {
        return new FortuneProperties(
            $this->getStrength(),
            $this->getRoll(),
            $this->getAgility(),
            $this->getRoll(),
            $this->getKnack(),
            $this->getRoll(),
            $this->getWill(),
            $this->getRoll(),
            $this->getIntelligence(),
            $this->getRoll(),
            $this->getCharisma(),
            $this->getRoll()
        );
    }
}
