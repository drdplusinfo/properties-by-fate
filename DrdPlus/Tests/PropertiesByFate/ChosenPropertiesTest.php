<?php
namespace DrdPlus\Tests\PropertiesByFate;

use DrdPlus\Codes\ChoiceCode;
use DrdPlus\Codes\FateCode;
use DrdPlus\PropertiesByFate\ChosenProperties;
use DrdPlus\PropertiesByFate\ExceptionalityProperties;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use DrdPlus\Tables\History\PlayerDecisionsTable;

class ChosenPropertiesTest extends ExceptionalityPropertiesTest
{
    /**
     * @test
     * @dataProvider provideChosenProperties
     * @param int $strength
     * @param int $agility
     * @param int $knack
     * @param int $will
     * @param int $intelligence
     * @param int $charisma
     */
    public function I_can_get_chosen_properties_tested_as_primary($strength, $agility, $knack, $will, $intelligence, $charisma)
    {
        $chosenProperties = new ChosenProperties(
            Strength::getIt($strength),
            Agility::getIt($agility),
            Knack::getIt($knack),
            Will::getIt($will),
            Intelligence::getIt($intelligence),
            Charisma::getIt($charisma),
            $fateCode = FateCode::getIt(FateCode::COMBINATION_OF_PROPERTIES_AND_BACKGROUND),
            $this->createProfession([
                Strength::STRENGTH,
                Agility::AGILITY,
                Knack::KNACK,
                Will::WILL,
                Intelligence::INTELLIGENCE,
                Charisma::CHARISMA,
            ]),
            $this->createPlayerDecisionsTable(
                $strength + $agility + $knack + $will + $intelligence + $charisma,
                0,
                max($strength, $agility, $knack, $will, $intelligence, $charisma)
            )
        );
        $this->I_get_null_as_id_before_persist($chosenProperties);
        $this->I_get_expected_choice_code($chosenProperties);
        $this->I_get_fate_code_created_with($chosenProperties, $fateCode);
        self::assertSame($strength, $chosenProperties->getStrength()->getValue());
        self::assertSame($agility, $chosenProperties->getAgility()->getValue());
        self::assertSame($knack, $chosenProperties->getKnack()->getValue());
        self::assertSame($will, $chosenProperties->getWill()->getValue());
        self::assertSame($intelligence, $chosenProperties->getIntelligence()->getValue());
        self::assertSame($charisma, $chosenProperties->getCharisma()->getValue());
    }

    public function provideChosenProperties()
    {
        return [
            [1, 2, 3, 4, 5, 6],
        ];
    }

    /**
     * @param int $primaryPropertiesBonus
     * @param int $secondaryPropertiesBonus
     * @param int $upToSingleProperty
     * @return PlayerDecisionsTable|\Mockery\MockInterface
     */
    private function createPlayerDecisionsTable($primaryPropertiesBonus, $secondaryPropertiesBonus, $upToSingleProperty)
    {
        $playerDecisionsTable = $this->mockery(PlayerDecisionsTable::class);
        $playerDecisionsTable->shouldReceive('getPointsToSecondaryProperties')
            ->andReturn($secondaryPropertiesBonus);
        $playerDecisionsTable->shouldReceive('getPointsToPrimaryProperties')
            ->andReturn($primaryPropertiesBonus);
        $playerDecisionsTable->shouldReceive('getMaximumToSingleProperty')
            ->andReturn($upToSingleProperty);

        return $playerDecisionsTable;
    }

    protected function I_get_null_as_id_before_persist(ExceptionalityProperties $chosenProperties)
    {
        self::assertNull($chosenProperties->getId());
    }

    protected function I_get_expected_choice_code(ExceptionalityProperties $chosenProperties)
    {
        self::assertSame(ChoiceCode::getIt(ChoiceCode::PLAYER_DECISION), $chosenProperties->getChoiceCode());
    }

    protected function I_get_fate_code_created_with(
        ExceptionalityProperties $chosenProperties,
        FateCode $expectedFateCode
    )
    {
        self::assertSame($expectedFateCode, $chosenProperties->getFateCode());
    }

    /**
     * @test
     * @dataProvider provideChosenProperties
     * @expectedException \DrdPlus\PropertiesByFate\Exceptions\InvalidValueOfChosenProperty
     * @param int $strength
     * @param int $agility
     * @param int $knack
     * @param int $will
     * @param int $intelligence
     * @param int $charisma
     */
    public function I_can_not_use_higher_than_allowed_chosen_property_tested_as_primary(
        $strength,
        $agility,
        $knack,
        $will,
        $intelligence,
        $charisma
    )
    {
        new ChosenProperties(
            Strength::getIt($strength),
            Agility::getIt($agility),
            Knack::getIt($knack),
            Will::getIt($will),
            Intelligence::getIt($intelligence),
            Charisma::getIt($charisma),
            FateCode::getIt(FateCode::GOOD_BACKGROUND),
            $this->createProfession([
                Strength::STRENGTH,
                Agility::AGILITY,
                Knack::KNACK,
                Will::WILL,
                Intelligence::INTELLIGENCE,
                Charisma::CHARISMA,
            ]),
            $this->createPlayerDecisionsTable(
                $strength + $agility + $knack + $will + $intelligence + $charisma,
                0,
                max($strength, $agility, $knack, $will, $intelligence, $charisma) - 1 /* allowed a little bit lesser than given */
            )
        );
    }

    /**
     * @test
     * @dataProvider provideChosenProperties
     * @expectedException \DrdPlus\PropertiesByFate\Exceptions\InvalidSumOfChosenProperties
     * @param int $strength
     * @param int $agility
     * @param int $knack
     * @param int $will
     * @param int $intelligence
     * @param int $charisma
     */
    public function I_can_not_use_higher_than_expected_chosen_properties_sum_tested_as_primary($strength, $agility, $knack, $will, $intelligence, $charisma)
    {
        new ChosenProperties(
            Strength::getIt($strength),
            Agility::getIt($agility),
            Knack::getIt($knack),
            Will::getIt($will),
            Intelligence::getIt($intelligence),
            Charisma::getIt($charisma),
            FateCode::getIt(FateCode::EXCEPTIONAL_PROPERTIES),
            $this->createProfession([
                Strength::STRENGTH,
                Agility::AGILITY,
                Knack::KNACK,
                Will::WILL,
                Intelligence::INTELLIGENCE,
                Charisma::CHARISMA,
            ]),
            $this->createPlayerDecisionsTable(
                $strength + $agility + $knack + $will + $intelligence + $charisma - 1 /* allowed a little bit less than given*/,
                0,
                max($strength, $agility, $knack, $will, $intelligence, $charisma)
            )
        );
    }

    /**
     * @test
     * @dataProvider provideChosenProperties
     * @expectedException \DrdPlus\PropertiesByFate\Exceptions\InvalidSumOfChosenProperties
     * @param int $strength
     * @param int $agility
     * @param int $knack
     * @param int $will
     * @param int $intelligence
     * @param int $charisma
     */
    public function I_can_not_use_lesser_than_expected_chosen_properties_sum_tested_as_primary(
        $strength,
        $agility,
        $knack,
        $will,
        $intelligence,
        $charisma
    )
    {
        new ChosenProperties(
            Strength::getIt($strength),
            Agility::getIt($agility),
            Knack::getIt($knack),
            Will::getIt($will),
            Intelligence::getIt($intelligence),
            Charisma::getIt($charisma),
            FateCode::getIt(FateCode::EXCEPTIONAL_PROPERTIES),
            $this->createProfession([
                Strength::STRENGTH,
                Agility::AGILITY,
                Knack::KNACK,
                Will::WILL,
                Intelligence::INTELLIGENCE,
                Charisma::CHARISMA,
            ]),
            $this->createPlayerDecisionsTable(
                $strength + $agility + $knack + $will + $intelligence + $charisma + 1/* expected a little bit more than given*/,
                0,
                max($strength, $agility, $knack, $will, $intelligence, $charisma)
            )
        );
    }

    /**
     * @test
     * @dataProvider provideChosenProperties
     * @param int $strength
     * @param int $agility
     * @param int $knack
     * @param int $will
     * @param int $intelligence
     * @param int $charisma
     */
    public function I_can_get_chosen_properties_tested_as_secondary($strength, $agility, $knack, $will, $intelligence, $charisma)
    {
        $chosenProperties = new ChosenProperties(
            Strength::getIt($strength),
            Agility::getIt($agility),
            Knack::getIt($knack),
            Will::getIt($will),
            Intelligence::getIt($intelligence),
            Charisma::getIt($charisma),
            FateCode::getIt(FateCode::COMBINATION_OF_PROPERTIES_AND_BACKGROUND),
            $this->createProfession([]), // all properties as secondary
            $this->createPlayerDecisionsTable(
                0,
                $strength + $agility + $knack + $will + $intelligence + $charisma,
                max($strength, $agility, $knack, $will, $intelligence, $charisma)
            )
        );
        self::assertSame($strength, $chosenProperties->getStrength()->getValue());
        self::assertSame($agility, $chosenProperties->getAgility()->getValue());
        self::assertSame($knack, $chosenProperties->getKnack()->getValue());
        self::assertSame($will, $chosenProperties->getWill()->getValue());
        self::assertSame($intelligence, $chosenProperties->getIntelligence()->getValue());
        self::assertSame($charisma, $chosenProperties->getCharisma()->getValue());
    }

    /**
     * @test
     * @dataProvider provideChosenProperties
     * @expectedException \DrdPlus\PropertiesByFate\Exceptions\InvalidSumOfChosenProperties
     * @param int $strength
     * @param int $agility
     * @param int $knack
     * @param int $will
     * @param int $intelligence
     * @param int $charisma
     */
    public function I_can_not_use_higher_than_expected_chosen_properties_sum_tested_as_secondary(
        $strength,
        $agility,
        $knack,
        $will,
        $intelligence,
        $charisma
    )
    {
        new ChosenProperties(
            Strength::getIt($strength),
            Agility::getIt($agility),
            Knack::getIt($knack),
            Will::getIt($will),
            Intelligence::getIt($intelligence),
            Charisma::getIt($charisma),
            FateCode::getIt(FateCode::EXCEPTIONAL_PROPERTIES),
            $this->createProfession([]),
            $this->createPlayerDecisionsTable(
                0,
                $strength + $agility + $knack + $will + $intelligence + $charisma - 1 /* allowed a little bit less than given*/,
                max($strength, $agility, $knack, $will, $intelligence, $charisma)
            )
        );
    }

    /**
     * @test
     * @dataProvider provideChosenProperties
     * @expectedException \DrdPlus\PropertiesByFate\Exceptions\InvalidValueOfChosenProperty
     * @param int $strength
     * @param int $agility
     * @param int $knack
     * @param int $will
     * @param int $intelligence
     * @param int $charisma
     */
    public function I_can_not_use_higher_than_allowed_chosen_property_tested_as_secondary(
        $strength,
        $agility,
        $knack,
        $will,
        $intelligence,
        $charisma
    )
    {
        new ChosenProperties(
            Strength::getIt($strength),
            Agility::getIt($agility),
            Knack::getIt($knack),
            Will::getIt($will),
            Intelligence::getIt($intelligence),
            Charisma::getIt($charisma),
            FateCode::getIt(FateCode::GOOD_BACKGROUND),
            $this->createProfession([]), // no primary property
            $this->createPlayerDecisionsTable(
                0,
                $strength + $agility + $knack + $will + $intelligence + $charisma,
                max($strength, $agility, $knack, $will, $intelligence, $charisma) - 1 /* allowed a little bit lesser than given */
            )
        );
    }

    /**
     * @test
     * @dataProvider provideChosenProperties
     * @expectedException \DrdPlus\PropertiesByFate\Exceptions\InvalidSumOfChosenProperties
     * @param int $strength
     * @param int $agility
     * @param int $knack
     * @param int $will
     * @param int $intelligence
     * @param int $charisma
     */
    public function I_can_not_use_lesser_than_expected_chosen_properties_sum_tested_as_secondary(
        $strength,
        $agility,
        $knack,
        $will,
        $intelligence,
        $charisma
    )
    {
        new ChosenProperties(
            Strength::getIt($strength),
            Agility::getIt($agility),
            Knack::getIt($knack),
            Will::getIt($will),
            Intelligence::getIt($intelligence),
            Charisma::getIt($charisma),
            FateCode::getIt(FateCode::COMBINATION_OF_PROPERTIES_AND_BACKGROUND),
            $this->createProfession([]), // no primary property
            $this->createPlayerDecisionsTable(
                0,
                $strength + $agility + $knack + $will + $intelligence + $charisma + 1 /* expected a little bit more than given*/,
                max($strength, $agility, $knack, $will, $intelligence, $charisma)
            )
        );
    }

}