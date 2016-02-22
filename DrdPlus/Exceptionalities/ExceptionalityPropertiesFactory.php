<?php
namespace DrdPlus\Exceptionalities;

use Drd\DiceRoll\Templates\Rolls\Roll1d6;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use DrdPlus\Person\ProfessionLevels\ProfessionLevel;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\BaseProperty;
use DrdPlus\Properties\Base\BasePropertyFactory;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use Granam\Strict\Object\StrictObject;

class ExceptionalityPropertiesFactory extends StrictObject
{

    public function createFortuneProperties(
        ExceptionalityFate $fate,
        ProfessionLevel $professionLevel,
        Roll1d6 $strengthRoll,
        Roll1d6 $agilityRoll,
        Roll1d6 $knackRoll,
        Roll1d6 $willRoll,
        Roll1d6 $intelligenceRoll,
        Roll1d6 $charismaRoll,
        BasePropertyFactory $basePropertyFactory
    )
    {
        $strength = $this->createFortuneProperty(
            $professionLevel, $fate, $strengthRoll, Strength::STRENGTH, $basePropertyFactory
        );
        $agility = $this->createFortuneProperty(
            $professionLevel, $fate, $agilityRoll, Agility::AGILITY, $basePropertyFactory
        );
        $knack = $this->createFortuneProperty(
            $professionLevel, $fate, $knackRoll, Knack::KNACK, $basePropertyFactory
        );
        $will = $this->createFortuneProperty(
            $professionLevel, $fate, $willRoll, Will::WILL, $basePropertyFactory
        );
        $intelligence = $this->createFortuneProperty(
            $professionLevel, $fate, $intelligenceRoll, Intelligence::INTELLIGENCE, $basePropertyFactory
        );
        $charisma = $this->createFortuneProperty(
            $professionLevel, $fate, $charismaRoll, Charisma::CHARISMA, $basePropertyFactory
        );

        return new FortuneProperties(
            $strength,
            $strengthRoll,
            $agility,
            $agilityRoll,
            $knack,
            $knackRoll,
            $will,
            $willRoll,
            $intelligence,
            $intelligenceRoll,
            $charisma,
            $charismaRoll
        );
    }

    private function createFortuneProperty(
        ProfessionLevel $profession,
        ExceptionalityFate $fate,
        Roll1d6 $roll,
        $propertyCode,
        BasePropertyFactory $basePropertyFactory
    )
    {
        if ($profession->isPrimaryProperty($propertyCode)) {
            $value = $fate->getPrimaryPropertyBonusOnFortune($roll);
        } else {
            $value = $fate->getSecondaryPropertyBonusOnFortune($roll);
        }

        $property = $basePropertyFactory->createProperty($value, $propertyCode);

        return $property;
    }

    public function createChosenProperties(
        ExceptionalityFate $fate,
        ProfessionLevel $professionLevel,
        Strength $chosenStrength,
        Agility $chosenAgility,
        Knack $chosenKnack,
        Will $chosenWill,
        Intelligence $chosenIntelligence,
        Charisma $chosenCharisma
    )
    {
        $this->checkChosenProperties(
            $chosenStrength,
            $chosenAgility,
            $chosenKnack,
            $chosenWill,
            $chosenIntelligence,
            $chosenCharisma,
            $professionLevel,
            $fate
        );

        return new ChosenProperties($chosenStrength, $chosenAgility, $chosenKnack, $chosenWill, $chosenIntelligence, $chosenCharisma);
    }

    private function checkChosenProperties(
        Strength $strength,
        Agility $agility,
        Knack $knack,
        Will $will,
        Intelligence $intelligence,
        Charisma $charisma,
        ProfessionLevel $professionLevel,
        ExceptionalityFate $fate
    )
    {
        $primaryPropertiesSum = 0;
        $secondaryPropertiesSum = 0;
        foreach ([$strength, $agility, $knack, $will, $intelligence, $charisma] as $property) {
            $this->checkChosenProperty($professionLevel, $fate, $property);

            /** @var BaseProperty $property */
            if ($professionLevel->isPrimaryProperty($property->getCode())) {
                $primaryPropertiesSum += $property->getValue();
            } else {
                $secondaryPropertiesSum += $property->getValue();
            }
        }

        $this->checkChosenPropertiesSum($primaryPropertiesSum, $secondaryPropertiesSum, $fate, $professionLevel);
    }

    private function checkChosenProperty(ProfessionLevel $professionLevel, ExceptionalityFate $fate, BaseProperty $chosenProperty)
    {
        if ($chosenProperty->getValue() > $fate->getUpToSingleProperty()) {
            throw new Exceptions\InvalidValueOfChosenProperty(
                "Required {$chosenProperty->getCode()} of value {$chosenProperty->getValue()} is higher than allowed"
                . " maximum {$fate->getUpToSingleProperty()} for profession {$professionLevel->getProfession()->getValue()}"
                . " and fate {$fate->getCode()}"
            );
        }
    }

    private function checkChosenPropertiesSum($primaryPropertiesSum, $secondaryPropertiesSum, ExceptionalityFate $fate, ProfessionLevel $professionLevel)
    {
        if ($primaryPropertiesSum !== $fate->getPrimaryPropertiesBonusOnChoice()) {
            throw new Exceptions\InvalidSumOfChosenProperties(
                "Expected sum of primary properties is {$fate->getPrimaryPropertiesBonusOnChoice()}, got $primaryPropertiesSum"
                . " for profession {$professionLevel->getProfession()->getValue()} and fate {$fate->getCode()}"
            );
        }

        if ($secondaryPropertiesSum !== $fate->getSecondaryPropertiesBonusOnChoice()) {
            throw new Exceptions\InvalidSumOfChosenProperties(
                "Expected sum of secondary properties is {$fate->getSecondaryPropertiesBonusOnChoice()}, got $secondaryPropertiesSum"
                . " for profession {$professionLevel->getProfession()->getValue()} and fate {$fate->getCode()}"
            );
        }
    }
}
