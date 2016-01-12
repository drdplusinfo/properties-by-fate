<?php
namespace DrdPlus\Exceptionalities;

use Drd\DiceRoll\RollInterface;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use DrdPlus\Person\ProfessionLevels\ProfessionLevel;
use DrdPlus\Professions\Profession;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\BasePropertyFactory;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use DrdPlus\Tests\Tools\TestWithMockery;

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
     * @dataProvider getChosenProperties
     */
    public function I_can_get_chosen_properties_tested_as_primary($strength, $agility, $knack, $will, $intelligence, $charisma)
    {
        $factory = new ExceptionalityPropertiesFactory();

        $chosenProperties = $factory->createChosenProperties(
            $this->createChosenFate(
                $strength + $agility + $knack + $will + $intelligence + $charisma,
                0,
                max($strength, $agility, $knack, $will, $intelligence, $charisma)
            ),
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

    public function getChosenProperties()
    {
        return [
            [1, 2, 3, 4, 5, 6],
        ];
    }

    /**
     * @param int $primaryPropertiesBonus
     * @param int $secondaryPropertiesBonus
     * @param int $upToSingleProperty
     * @return ExceptionalityFate
     */
    private function createChosenFate($primaryPropertiesBonus, $secondaryPropertiesBonus, $upToSingleProperty)
    {
        $fate = $this->mockery(ExceptionalityFate::class);
        $fate->shouldReceive('getSecondaryPropertiesBonusOnChoice')
            ->andReturn($secondaryPropertiesBonus);
        $fate->shouldReceive('getPrimaryPropertiesBonusOnChoice')
            ->andReturn($primaryPropertiesBonus);
        $fate->shouldReceive('getUpToSingleProperty')
            ->andReturn($upToSingleProperty);
        $fate->shouldReceive('getCode')
            ->andReturn('foo');

        return $fate;
    }

    /**
     * @param array $primaryPropertyCodes
     * @return ProfessionLevel
     */
    private function createProfessionLevel(array $primaryPropertyCodes)
    {
        $professionLevel = $this->mockery(ProfessionLevel::class);
        $professionLevel->shouldReceive('isPrimaryProperty')
            ->andReturnUsing(function ($propertyCode) use ($primaryPropertyCodes) {
                return in_array($propertyCode, $primaryPropertyCodes);
            });
        $professionLevel->shouldReceive('getProfession')
            ->andReturn($profession = $this->mockery(Profession::class));
        $profession->shouldReceive('getValue')
            ->andReturn('foo');

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

    /**
     * @param $strength
     * @param $agility
     * @param $knack
     * @param $will
     * @param $intelligence
     * @param $charisma
     *
     * @test
     * @dataProvider getChosenProperties
     * @expectedException \DrdPlus\Exceptionalities\Exceptions\InvalidValueOfChosenProperty
     */
    public function I_can_not_use_higher_than_allowed_chosen_property_tested_as_primary($strength, $agility, $knack, $will, $intelligence, $charisma)
    {
        $factory = new ExceptionalityPropertiesFactory();

        $factory->createChosenProperties(
            $this->createChosenFate(
                $strength + $agility + $knack + $will + $intelligence + $charisma,
                0,
                max($strength, $agility, $knack, $will, $intelligence, $charisma) - 1 /* allowed a little bit lesser than given */
            ),
            $this->createProfessionLevel([
                Strength::STRENGTH,
                Agility::AGILITY,
                Knack::KNACK,
                Will::WILL,
                Intelligence::INTELLIGENCE,
                Charisma::CHARISMA,
            ]),
            $this->createStrength($strength),
            $this->createAgility($agility),
            $this->createKnack($knack),
            $this->createWill($will),
            $this->createIntelligence($intelligence),
            $this->createCharisma($charisma)
        );
    }

    /**
     * @param $strength
     * @param $agility
     * @param $knack
     * @param $will
     * @param $intelligence
     * @param $charisma
     *
     * @test
     * @dataProvider getChosenProperties
     * @expectedException \DrdPlus\Exceptionalities\Exceptions\InvalidSumOfChosenProperties
     */
    public function I_can_not_use_higher_than_expected_chosen_properties_sum_tested_as_primary($strength, $agility, $knack, $will, $intelligence, $charisma)
    {
        $factory = new ExceptionalityPropertiesFactory();

        $factory->createChosenProperties(
            $this->createChosenFate(
                $strength + $agility + $knack + $will + $intelligence + $charisma - 1 /* allowed a little bit less than given*/,
                0,
                max($strength, $agility, $knack, $will, $intelligence, $charisma)
            ),
            $this->createProfessionLevel([
                Strength::STRENGTH,
                Agility::AGILITY,
                Knack::KNACK,
                Will::WILL,
                Intelligence::INTELLIGENCE,
                Charisma::CHARISMA,
            ]),
            $this->createStrength($strength),
            $this->createAgility($agility),
            $this->createKnack($knack),
            $this->createWill($will),
            $this->createIntelligence($intelligence),
            $this->createCharisma($charisma)
        );
    }

    /**
     * @param $strength
     * @param $agility
     * @param $knack
     * @param $will
     * @param $intelligence
     * @param $charisma
     *
     * @test
     * @dataProvider getChosenProperties
     * @expectedException \DrdPlus\Exceptionalities\Exceptions\InvalidSumOfChosenProperties
     */
    public function I_can_not_use_lesser_than_expected_chosen_properties_sum_tested_as_primary($strength, $agility, $knack, $will, $intelligence, $charisma)
    {
        $factory = new ExceptionalityPropertiesFactory();

        $factory->createChosenProperties(
            $this->createChosenFate(
                $strength + $agility + $knack + $will + $intelligence + $charisma + 1/* expected a little bit more than given*/,
                0,
                max($strength, $agility, $knack, $will, $intelligence, $charisma)
            ),
            $this->createProfessionLevel([
                Strength::STRENGTH,
                Agility::AGILITY,
                Knack::KNACK,
                Will::WILL,
                Intelligence::INTELLIGENCE,
                Charisma::CHARISMA,
            ]),
            $this->createStrength($strength),
            $this->createAgility($agility),
            $this->createKnack($knack),
            $this->createWill($will),
            $this->createIntelligence($intelligence),
            $this->createCharisma($charisma)
        );
    }

    /**
     * @param $strength
     * @param $agility
     * @param $knack
     * @param $will
     * @param $intelligence
     * @param $charisma
     *
     * @test
     * @dataProvider getChosenProperties
     */
    public function I_can_get_chosen_properties_tested_as_secondary($strength, $agility, $knack, $will, $intelligence, $charisma)
    {
        $factory = new ExceptionalityPropertiesFactory();

        $chosenProperties = $factory->createChosenProperties(
            $this->createChosenFate(
                0,
                $strength + $agility + $knack + $will + $intelligence + $charisma,
                max($strength, $agility, $knack, $will, $intelligence, $charisma)
            ),
            $this->createProfessionLevel([]), // all properties as secondary
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

    /**
     * @param $strength
     * @param $agility
     * @param $knack
     * @param $will
     * @param $intelligence
     * @param $charisma
     *
     * @test
     * @dataProvider getChosenProperties
     * @expectedException \DrdPlus\Exceptionalities\Exceptions\InvalidSumOfChosenProperties
     */
    public function I_can_not_use_higher_than_expected_chosen_properties_sum_tested_as_secondary($strength, $agility, $knack, $will, $intelligence, $charisma)
    {
        $factory = new ExceptionalityPropertiesFactory();

        $factory->createChosenProperties(
            $this->createChosenFate(
                0,
                $strength + $agility + $knack + $will + $intelligence + $charisma - 1 /* allowed a little bit less than given*/,
                max($strength, $agility, $knack, $will, $intelligence, $charisma)
            ),
            $this->createProfessionLevel([]),
            $this->createStrength($strength),
            $this->createAgility($agility),
            $this->createKnack($knack),
            $this->createWill($will),
            $this->createIntelligence($intelligence),
            $this->createCharisma($charisma)
        );
    }

    /**
     * @param $strength
     * @param $agility
     * @param $knack
     * @param $will
     * @param $intelligence
     * @param $charisma
     *
     * @test
     * @dataProvider getChosenProperties
     * @expectedException \DrdPlus\Exceptionalities\Exceptions\InvalidValueOfChosenProperty
     */
    public function I_can_not_use_higher_than_allowed_chosen_property_tested_as_secondary($strength, $agility, $knack, $will, $intelligence, $charisma)
    {
        $factory = new ExceptionalityPropertiesFactory();

        $factory->createChosenProperties(
            $this->createChosenFate(
                0,
                $strength + $agility + $knack + $will + $intelligence + $charisma,
                max($strength, $agility, $knack, $will, $intelligence, $charisma) - 1 /* allowed a little bit lesser than given */
            ),
            $this->createProfessionLevel([]), // no primary property
            $this->createStrength($strength),
            $this->createAgility($agility),
            $this->createKnack($knack),
            $this->createWill($will),
            $this->createIntelligence($intelligence),
            $this->createCharisma($charisma)
        );
    }

    /**
     * @param $strength
     * @param $agility
     * @param $knack
     * @param $will
     * @param $intelligence
     * @param $charisma
     *
     * @test
     * @dataProvider getChosenProperties
     * @expectedException \DrdPlus\Exceptionalities\Exceptions\InvalidSumOfChosenProperties
     */
    public function I_can_not_use_lesser_than_expected_chosen_properties_sum_tested_as_secondary($strength, $agility, $knack, $will, $intelligence, $charisma)
    {
        $factory = new ExceptionalityPropertiesFactory();

        $factory->createChosenProperties(
            $this->createChosenFate(
                0,
                $strength + $agility + $knack + $will + $intelligence + $charisma + 1 /* expected a little bit more than given*/,
                max($strength, $agility, $knack, $will, $intelligence, $charisma)
            ),
            $this->createProfessionLevel([]), // no primary property
            $this->createStrength($strength),
            $this->createAgility($agility),
            $this->createKnack($knack),
            $this->createWill($will),
            $this->createIntelligence($intelligence),
            $this->createCharisma($charisma)
        );
    }

    /**
     * @param $strengthRoll
     * @param $agilityRoll
     * @param $knackRoll
     * @param $willRoll
     * @param $intelligenceRoll
     * @param $charismaRoll
     *
     * @test
     * @dataProvider getChosenProperties
     */
    public function I_can_get_fortune_properties_tested_as_primary(
        $strengthRoll,
        $agilityRoll,
        $knackRoll,
        $willRoll,
        $intelligenceRoll,
        $charismaRoll
    )
    {
        $factory = new ExceptionalityPropertiesFactory();

        $chosenProperties = $factory->createFortuneProperties(
            $this->createFortuneFateForPrimaryPropertiesOnly($testMultiplier = 456),
            $this->createProfessionLevel([
                Strength::STRENGTH,
                Agility::AGILITY,
                Knack::KNACK,
                Will::WILL,
                Intelligence::INTELLIGENCE,
                Charisma::CHARISMA,
            ]),
            $this->createRoll($strengthRoll),
            $this->createRoll($agilityRoll),
            $this->createRoll($knackRoll),
            $this->createRoll($willRoll),
            $this->createRoll($intelligenceRoll),
            $this->createRoll($charismaRoll),
            new BasePropertyFactory()
        );
        $this->assertSame($strengthRoll * $testMultiplier, $chosenProperties->getStrength()->getValue());
        $this->assertSame($strengthRoll, $chosenProperties->getStrengthRoll());
        $this->assertSame($agilityRoll * $testMultiplier, $chosenProperties->getAgility()->getValue());
        $this->assertSame($agilityRoll, $chosenProperties->getAgilityRoll());
        $this->assertSame($knackRoll * $testMultiplier, $chosenProperties->getKnack()->getValue());
        $this->assertSame($knackRoll, $chosenProperties->getKnackRoll());
        $this->assertSame($willRoll * $testMultiplier, $chosenProperties->getWill()->getValue());
        $this->assertSame($willRoll, $chosenProperties->getWillRoll());
        $this->assertSame($intelligenceRoll * $testMultiplier, $chosenProperties->getIntelligence()->getValue());
        $this->assertSame($intelligenceRoll, $chosenProperties->getIntelligenceRoll());
        $this->assertSame($charismaRoll * $testMultiplier, $chosenProperties->getCharisma()->getValue());
        $this->assertSame($charismaRoll, $chosenProperties->getCharismaRoll());
    }

    /**
     * @param int $testMultiplier
     * @return ExceptionalityFate
     */
    private function createFortuneFateForPrimaryPropertiesOnly($testMultiplier)
    {
        $fate = $this->mockery(ExceptionalityFate::class);
        $fate->shouldReceive('getPrimaryPropertyBonusOnFortune')
            ->with(\Mockery::type(RollInterface::class))
            ->andReturnUsing(function (RollInterface $roll) use ($testMultiplier) {
                return $roll->getLastRollSummary() * $testMultiplier;
            });

        return $fate;
    }

    /**
     * @param $value
     * @return RollInterface
     */
    private function createRoll($value)
    {
        $roll = $this->mockery(RollInterface::class);
        $roll->shouldReceive('getLastRollSummary')
            ->andReturn($value);

        return $roll;
    }

    /**
     * @param $strengthRoll
     * @param $agilityRoll
     * @param $knackRoll
     * @param $willRoll
     * @param $intelligenceRoll
     * @param $charismaRoll
     *
     * @test
     * @dataProvider getChosenProperties
     */
    public function I_can_get_fortune_properties_tested_as_secondary(
        $strengthRoll,
        $agilityRoll,
        $knackRoll,
        $willRoll,
        $intelligenceRoll,
        $charismaRoll
    )
    {
        $factory = new ExceptionalityPropertiesFactory();

        $chosenProperties = $factory->createFortuneProperties(
            $this->createFortuneFateForSecondaryPropertiesOnly($testMultiplier = 456),
            $this->createProfessionLevel([]), // all properties as secondary
            $this->createRoll($strengthRoll),
            $this->createRoll($agilityRoll),
            $this->createRoll($knackRoll),
            $this->createRoll($willRoll),
            $this->createRoll($intelligenceRoll),
            $this->createRoll($charismaRoll),
            new BasePropertyFactory()
        );
        $this->assertSame($strengthRoll * $testMultiplier, $chosenProperties->getStrength()->getValue());
        $this->assertSame($strengthRoll, $chosenProperties->getStrengthRoll());
        $this->assertSame($agilityRoll * $testMultiplier, $chosenProperties->getAgility()->getValue());
        $this->assertSame($agilityRoll, $chosenProperties->getAgilityRoll());
        $this->assertSame($knackRoll * $testMultiplier, $chosenProperties->getKnack()->getValue());
        $this->assertSame($knackRoll, $chosenProperties->getKnackRoll());
        $this->assertSame($willRoll * $testMultiplier, $chosenProperties->getWill()->getValue());
        $this->assertSame($willRoll, $chosenProperties->getWillRoll());
        $this->assertSame($intelligenceRoll * $testMultiplier, $chosenProperties->getIntelligence()->getValue());
        $this->assertSame($intelligenceRoll, $chosenProperties->getIntelligenceRoll());
        $this->assertSame($charismaRoll * $testMultiplier, $chosenProperties->getCharisma()->getValue());
        $this->assertSame($charismaRoll, $chosenProperties->getCharismaRoll());
    }

    /**
     * @param int $testMultiplier
     * @return ExceptionalityFate
     */
    private function createFortuneFateForSecondaryPropertiesOnly($testMultiplier)
    {
        $fate = $this->mockery(ExceptionalityFate::class);
        $fate->shouldReceive('getSecondaryPropertyBonusOnFortune')
            ->with(\Mockery::type(RollInterface::class))
            ->andReturnUsing(function (RollInterface $roll) use ($testMultiplier) {
                return $roll->getLastRollSummary() * $testMultiplier;
            });

        return $fate;
    }

}
