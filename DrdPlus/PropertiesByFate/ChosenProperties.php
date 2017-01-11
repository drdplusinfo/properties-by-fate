<?php
namespace DrdPlus\PropertiesByFate;

use DrdPlus\Codes\ChoiceCode;
use DrdPlus\Codes\FateCode;
use DrdPlus\Codes\PropertyCode;
use DrdPlus\Professions\Profession;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\BaseProperty;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use Doctrine\ORM\Mapping as ORM;
use DrdPlus\Tables\History\PlayerDecisionsTable;

/**
 * @ORM\Entity()
 */
class ChosenProperties extends ExceptionalityProperties
{

    /**
     * @param Strength $strength
     * @param Agility $agility
     * @param Knack $knack
     * @param Will $will
     * @param Intelligence $intelligence
     * @param Charisma $charisma
     * @param FateCode $fateCode
     * @param Profession $profession
     * @param PlayerDecisionsTable $playerDecisionsTable
     * @throws \DrdPlus\PropertiesByFate\Exceptions\InvalidValueOfChosenProperty
     * @throws \DrdPlus\PropertiesByFate\Exceptions\InvalidSumOfChosenProperties
     */
    public function __construct(
        Strength $strength,
        Agility $agility,
        Knack $knack,
        Will $will,
        Intelligence $intelligence,
        Charisma $charisma,
        FateCode $fateCode,
        Profession $profession,
        PlayerDecisionsTable $playerDecisionsTable
    )
    {
        $this->checkChosenProperties(
            $strength,
            $agility,
            $knack,
            $will,
            $intelligence,
            $charisma,
            $fateCode,
            $profession,
            $playerDecisionsTable
        );
        parent::__construct($strength, $agility, $knack, $will, $intelligence, $charisma, $fateCode);
    }

    /**
     * @param Strength $strength
     * @param Agility $agility
     * @param Knack $knack
     * @param Will $will
     * @param Intelligence $intelligence
     * @param Charisma $charisma
     * @param FateCode $fate
     * @param Profession $profession
     * @param PlayerDecisionsTable $playerDecisionsTable
     * @throws \DrdPlus\PropertiesByFate\Exceptions\InvalidValueOfChosenProperty
     * @throws \DrdPlus\PropertiesByFate\Exceptions\InvalidSumOfChosenProperties
     */
    private function checkChosenProperties(
        Strength $strength,
        Agility $agility,
        Knack $knack,
        Will $will,
        Intelligence $intelligence,
        Charisma $charisma,
        FateCode $fate,
        Profession $profession,
        PlayerDecisionsTable $playerDecisionsTable
    )
    {
        $primaryPropertiesSum = 0;
        $secondaryPropertiesSum = 0;
        foreach ([$strength, $agility, $knack, $will, $intelligence, $charisma] as $property) {
            $this->checkChosenProperty($profession, $fate, $property, $playerDecisionsTable);

            /** @var BaseProperty $property */
            if ($profession->isPrimaryProperty(PropertyCode::getIt($property->getCode()))) {
                $primaryPropertiesSum += $property->getValue();
            } else {
                $secondaryPropertiesSum += $property->getValue();
            }
        }

        $this->checkChosenPropertiesSum(
            $primaryPropertiesSum,
            $secondaryPropertiesSum,
            $fate,
            $profession,
            $playerDecisionsTable
        );
    }

    /**
     * @param Profession $profession
     * @param FateCode $fate
     * @param BaseProperty $chosenProperty
     * @param PlayerDecisionsTable $playerDecisionsTable
     * @throws \DrdPlus\PropertiesByFate\Exceptions\InvalidValueOfChosenProperty
     */
    private function checkChosenProperty(
        Profession $profession,
        FateCode $fate,
        BaseProperty $chosenProperty,
        PlayerDecisionsTable $playerDecisionsTable
    )
    {
        if ($chosenProperty->getValue() > $playerDecisionsTable->getMaximumToSingleProperty($fate)) {
            throw new Exceptions\InvalidValueOfChosenProperty(
                "Requested {$chosenProperty->getCode()} value {$chosenProperty->getValue()} is higher than allowed"
                . " maximum {$playerDecisionsTable->getMaximumToSingleProperty($fate)}"
                . " for profession {$profession->getValue()} and fate {$fate}"
            );
        }
    }

    /**
     * @param int $primaryPropertiesSum
     * @param int $secondaryPropertiesSum
     * @param FateCode $fateCode
     * @param Profession $profession
     * @param PlayerDecisionsTable $playerDecisionsTable
     * @throws \DrdPlus\PropertiesByFate\Exceptions\InvalidSumOfChosenProperties
     */
    private function checkChosenPropertiesSum(
        $primaryPropertiesSum,
        $secondaryPropertiesSum,
        FateCode $fateCode,
        Profession $profession,
        PlayerDecisionsTable $playerDecisionsTable
    )
    {
        if ($primaryPropertiesSum !== $playerDecisionsTable->getPointsToPrimaryProperties($fateCode)) {
            throw new Exceptions\InvalidSumOfChosenProperties(
                "Expected {$playerDecisionsTable->getPointsToPrimaryProperties($fateCode)} as sum of primary properties,"
                . " got $primaryPropertiesSum for profession '{$profession->getValue()}'"
                . " and fate '{$fateCode}'"
            );
        }

        if ($secondaryPropertiesSum !== $playerDecisionsTable->getPointsToSecondaryProperties($fateCode)) {
            throw new Exceptions\InvalidSumOfChosenProperties(
                "Expected {$playerDecisionsTable->getPointsToSecondaryProperties($fateCode)} as sum of secondary properties,"
                . " got $secondaryPropertiesSum for profession '{$profession->getValue()}'"
                . " and fate '{$fateCode}'"
            );
        }
    }

    public function getChoiceCode()
    {
        return ChoiceCode::getIt(ChoiceCode::PLAYER_DECISION);
    }

}