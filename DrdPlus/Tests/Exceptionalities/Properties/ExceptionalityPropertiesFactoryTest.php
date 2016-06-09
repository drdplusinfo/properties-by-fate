<?php
namespace DrdPlus\Tests\Exceptionalities\Properties;

use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use DrdPlus\Exceptionalities\Properties\ExceptionalityPropertiesFactory;
use DrdPlus\Exceptionalities\Templates\Integer1To6;
use DrdPlus\Person\ProfessionLevels\ProfessionLevel;
use DrdPlus\Professions\Profession;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\BasePropertiesFactory;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use Granam\Tests\Tools\TestWithMockery;

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
            $strength,
            $agility,
            $knack,
            $will,
            $intelligence,
            $charisma
        );
        self::assertSame($strength, $chosenProperties->getStrength()->getValue());
        self::assertSame($agility, $chosenProperties->getAgility()->getValue());
        self::assertSame($knack, $chosenProperties->getKnack()->getValue());
        self::assertSame($will, $chosenProperties->getWill()->getValue());
        self::assertSame($intelligence, $chosenProperties->getIntelligence()->getValue());
        self::assertSame($charisma, $chosenProperties->getCharisma()->getValue());
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
                return in_array($propertyCode, $primaryPropertyCodes, true);
            });
        $professionLevel->shouldReceive('getProfession')
            ->andReturn($profession = $this->mockery(Profession::class));
        $profession->shouldReceive('getValue')
            ->andReturn('foo');

        return $professionLevel;
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
     * @expectedException \DrdPlus\Exceptionalities\Properties\Exceptions\InvalidValueOfChosenProperty
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
            $strength,
            $agility,
            $knack,
            $will,
            $intelligence,
            $charisma
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
     * @expectedException \DrdPlus\Exceptionalities\Properties\Exceptions\InvalidSumOfChosenProperties
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
            $strength,
            $agility,
            $knack,
            $will,
            $intelligence,
            $charisma
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
     * @expectedException \DrdPlus\Exceptionalities\Properties\Exceptions\InvalidSumOfChosenProperties
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
            $strength,
            $agility,
            $knack,
            $will,
            $intelligence,
            $charisma
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
            $strength,
            $agility,
            $knack,
            $will,
            $intelligence,
            $charisma
        );
        self::assertSame($strength, $chosenProperties->getStrength()->getValue());
        self::assertSame($agility, $chosenProperties->getAgility()->getValue());
        self::assertSame($knack, $chosenProperties->getKnack()->getValue());
        self::assertSame($will, $chosenProperties->getWill()->getValue());
        self::assertSame($intelligence, $chosenProperties->getIntelligence()->getValue());
        self::assertSame($charisma, $chosenProperties->getCharisma()->getValue());
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
     * @expectedException \DrdPlus\Exceptionalities\Properties\Exceptions\InvalidSumOfChosenProperties
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
            $strength,
            $agility,
            $knack,
            $will,
            $intelligence,
            $charisma
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
     * @expectedException \DrdPlus\Exceptionalities\Properties\Exceptions\InvalidValueOfChosenProperty
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
            $strength,
            $agility,
            $knack,
            $will,
            $intelligence,
            $charisma
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
     * @expectedException \DrdPlus\Exceptionalities\Properties\Exceptions\InvalidSumOfChosenProperties
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
            $strength,
            $agility,
            $knack,
            $will,
            $intelligence,
            $charisma
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
            $strengthRoll,
            $agilityRoll,
            $knackRoll,
            $willRoll,
            $intelligenceRoll,
            $charismaRoll,
            new BasePropertiesFactory()
        );
        self::assertSame($strengthRoll * $testMultiplier, $chosenProperties->getStrength()->getValue());
        self::assertSame($strengthRoll, $chosenProperties->getStrengthRoll());
        self::assertSame($agilityRoll * $testMultiplier, $chosenProperties->getAgility()->getValue());
        self::assertSame($agilityRoll, $chosenProperties->getAgilityRoll());
        self::assertSame($knackRoll * $testMultiplier, $chosenProperties->getKnack()->getValue());
        self::assertSame($knackRoll, $chosenProperties->getKnackRoll());
        self::assertSame($willRoll * $testMultiplier, $chosenProperties->getWill()->getValue());
        self::assertSame($willRoll, $chosenProperties->getWillRoll());
        self::assertSame($intelligenceRoll * $testMultiplier, $chosenProperties->getIntelligence()->getValue());
        self::assertSame($intelligenceRoll, $chosenProperties->getIntelligenceRoll());
        self::assertSame($charismaRoll * $testMultiplier, $chosenProperties->getCharisma()->getValue());
        self::assertSame($charismaRoll, $chosenProperties->getCharismaRoll());
    }

    /**
     * @param int $testMultiplier
     * @return ExceptionalityFate
     */
    private function createFortuneFateForPrimaryPropertiesOnly($testMultiplier)
    {
        $fate = $this->mockery(ExceptionalityFate::class);
        $fate->shouldReceive('getPrimaryPropertyBonusOnFortune')
            ->with(\Mockery::type(Integer1To6::class))
            ->andReturnUsing(function (Integer1To6 $roll) use ($testMultiplier) {
                return $roll->getValue() * $testMultiplier;
            });

        return $fate;
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
            $strengthRoll,
            $agilityRoll,
            $knackRoll,
            $willRoll,
            $intelligenceRoll,
            $charismaRoll,
            new BasePropertiesFactory()
        );
        self::assertSame($strengthRoll * $testMultiplier, $chosenProperties->getStrength()->getValue());
        self::assertSame($strengthRoll, $chosenProperties->getStrengthRoll());
        self::assertSame($agilityRoll * $testMultiplier, $chosenProperties->getAgility()->getValue());
        self::assertSame($agilityRoll, $chosenProperties->getAgilityRoll());
        self::assertSame($knackRoll * $testMultiplier, $chosenProperties->getKnack()->getValue());
        self::assertSame($knackRoll, $chosenProperties->getKnackRoll());
        self::assertSame($willRoll * $testMultiplier, $chosenProperties->getWill()->getValue());
        self::assertSame($willRoll, $chosenProperties->getWillRoll());
        self::assertSame($intelligenceRoll * $testMultiplier, $chosenProperties->getIntelligence()->getValue());
        self::assertSame($intelligenceRoll, $chosenProperties->getIntelligenceRoll());
        self::assertSame($charismaRoll * $testMultiplier, $chosenProperties->getCharisma()->getValue());
        self::assertSame($charismaRoll, $chosenProperties->getCharismaRoll());
    }

    /**
     * @param int $testMultiplier
     * @return ExceptionalityFate
     */
    private function createFortuneFateForSecondaryPropertiesOnly($testMultiplier)
    {
        $fate = $this->mockery(ExceptionalityFate::class);
        $fate->shouldReceive('getSecondaryPropertyBonusOnFortune')
            ->with(\Mockery::type(Integer1To6::class))
            ->andReturnUsing(function (Integer1To6 $roll) use ($testMultiplier) {
                return $roll->getValue() * $testMultiplier;
            });

        return $fate;
    }

}
