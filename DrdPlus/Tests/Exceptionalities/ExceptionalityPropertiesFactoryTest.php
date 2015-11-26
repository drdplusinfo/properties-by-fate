<?php
namespace DrdPlus\Exceptionalities;

use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use DrdPlus\ProfessionLevels\ProfessionLevel;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use DrdPlus\Tools\Tests\TestWithMockery;

class ExceptionalityPropertiesFactoryTest extends TestWithMockery
{
    /**
     * @param $strength
     * @param $agility
     * @param $knack
     * @param $will
     * @param $intelligence
     * @param $charisma
     *
     * @test
     * @dataProvider getProperties
     */
    public function I_can_get_chosen_properties($strength, $agility, $knack, $will, $intelligence, $charisma)
    {
        $factory = new ExceptionalityPropertiesFactory();
        $chosenProperties = $factory->createChosenProperties(
            $this->createChosenFate($strength + $agility + $knack + $will + $intelligence + $charisma, 0),
            $this->createProfessionLevel([
                Strength::STRENGTH,
                Agility::AGILITY,
                Knack::KNACK,
                Will::WILL,
                Intelligence::INTELLIGENCE,
                Charisma::CHARISMA,
            ]),
            $strength = $this->createStrength($strength),
            $agility = $this->createAgility($agility),
            $knack = $this->createKnack($knack),
            $will = $this->createWill($will),
            $intelligence = $this->createIntelligence($intelligence),
            $charisma = $this->createCharisma($charisma)
        );
        $this->assertSame($strength, $chosenProperties->getStrength());
        $this->assertSame($agility, $chosenProperties->getAgility());
        $this->assertSame($knack, $chosenProperties->getKnack());
        $this->assertSame($will, $chosenProperties->getWill());
        $this->assertSame($intelligence, $chosenProperties->getIntelligence());
        $this->assertSame($charisma, $chosenProperties->getCharisma());
    }

    public function getProperties()
    {
        return [
            [1, 2, 3, 4, 5, 6],
        ];
    }

    /**
     * @param int $primaryPropertyBonus
     * @param int $secondaryPropertyBonus
     * @return ExceptionalityFate
     */
    private function createChosenFate($primaryPropertyBonus, $secondaryPropertyBonus)
    {
        $fate = $this->mockery(ExceptionalityFate::class);
        $fate->shouldReceive('getSecondaryPropertiesBonusOnChoice')
            ->andReturn($secondaryPropertyBonus);
        $fate->shouldReceive('getPrimaryPropertiesBonusOnChoice')
            ->andReturn($primaryPropertyBonus);

        return $fate;
    }

    /**
     * @param array $primaryPropertyCodes
     * @return ProfessionLevel
     */
    private function createProfessionLevel(array $primaryPropertyCodes)
    {
        $professionLevel = $this->mockery(ProfessionLevel::class)
            ->shouldReceive('isPrimaryProperty')
            ->andReturnUsing(function ($propertyCode) use ($primaryPropertyCodes) {
                return in_array($propertyCode, $primaryPropertyCodes);
            })->getMock();

        return $professionLevel;
    }

    /**
     * @param $value
     * @return Strength
     */
    private function createStrength($value)
    {
        return Strength::getIt($value);
    }

    /**
     * @param $value
     * @return Agility
     */
    private function createAgility($value)
    {
        return Agility::getIt($value);
    }

    /**
     * @param $value
     * @return Knack
     */
    private function createKnack($value)
    {
        return Knack::getIt($value);
    }

    /**
     * @param $value
     * @return Will
     */
    private function createWill($value)
    {
        return Will::getIt($value);
    }

    /**
     * @param $value
     * @return Intelligence
     */
    private function createIntelligence($value)
    {
        return Intelligence::getIt($value);
    }

    /**
     * @param $value
     * @return Charisma
     */
    private function createCharisma($value)
    {
        return Charisma::getIt($value);
    }
}
