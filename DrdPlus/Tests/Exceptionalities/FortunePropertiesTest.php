<?php
namespace DrdPlus\Tests\Exceptionalities;

use Drd\DiceRoll\RollInterface;
use DrdPlus\Exceptionalities\FortuneProperties;

class FortunePropertiesTest extends AbstractTestOfExceptionalityProperties
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

        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param $value = null
     * @return \Mockery\MockInterface|RollInterface
     */
    protected function getRoll($value = null)
    {
        $roll = $this->mockery(RollInterface::class);
        $roll->shouldReceive('getLastRollSummary')
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
        $this->assertSame($strength, $fortuneProperties->getStrength());
        $this->assertSame($agility, $fortuneProperties->getAgility());
        $this->assertSame($knack, $fortuneProperties->getKnack());
        $this->assertSame($will, $fortuneProperties->getWill());
        $this->assertSame($intelligence, $fortuneProperties->getIntelligence());
        $this->assertSame($charisma, $fortuneProperties->getCharisma());
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
        $this->assertSame($strengthRoll, $fortuneProperties->getStrengthRoll());
        $this->assertSame($agilityRoll, $fortuneProperties->getAgilityRoll());
        $this->assertSame($knackRoll, $fortuneProperties->getKnackRoll());
        $this->assertSame($willRoll, $fortuneProperties->getWillRoll());
        $this->assertSame($intelligenceRoll, $fortuneProperties->getIntelligenceRoll());
        $this->assertSame($charismaRoll, $fortuneProperties->getCharismaRoll());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Exceptionalities\Exceptions\UnknownBasePropertyCode
     */
    public function I_can_not_use_invalid_property_code_for_generic_getter()
    {
        $exceptionalityProperties = new FortuneProperties(
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

        $exceptionalityProperties->getProperty('invalid code');
    }
}
