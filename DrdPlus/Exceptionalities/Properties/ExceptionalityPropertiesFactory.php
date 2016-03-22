<?php
namespace DrdPlus\Exceptionalities\Properties;

use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use DrdPlus\Exceptionalities\Templates\Integer1To6;
use DrdPlus\Person\ProfessionLevels\ProfessionLevel;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\BaseProperty;
use DrdPlus\Properties\Base\BasePropertiesFactory;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use Granam\Strict\Object\StrictObject;

class ExceptionalityPropertiesFactory extends StrictObject
{

    /**
     * @param ExceptionalityFate $fate
     * @param ProfessionLevel $professionLevel
     * @param int $strengthRollValue
     * @param int $agilityRollValue
     * @param int $knackRollValue
     * @param int $willRollValue
     * @param int $intelligenceRollValue
     * @param int $charismaRollValue
     * @param BasePropertiesFactory $basePropertyFactory
     * @return FortuneProperties
     */
    public function createFortuneProperties(
        ExceptionalityFate $fate,
        ProfessionLevel $professionLevel,
        $strengthRollValue,
        $agilityRollValue,
        $knackRollValue,
        $willRollValue,
        $intelligenceRollValue,
        $charismaRollValue,
        BasePropertiesFactory $basePropertyFactory
    )
    {
        $strengthRoll = new Integer1To6($strengthRollValue);
        $strength = $this->createFortuneProperty(
            $professionLevel, $fate, $strengthRoll, Strength::STRENGTH, $basePropertyFactory
        );
        $agilityRoll = new Integer1To6($agilityRollValue);
        $agility = $this->createFortuneProperty(
            $professionLevel, $fate, $agilityRoll, Agility::AGILITY, $basePropertyFactory
        );
        $knackRoll = new Integer1To6($knackRollValue);
        $knack = $this->createFortuneProperty(
            $professionLevel, $fate, $knackRoll, Knack::KNACK, $basePropertyFactory
        );
        $willRoll = new Integer1To6($willRollValue);
        $will = $this->createFortuneProperty(
            $professionLevel, $fate, $willRoll, Will::WILL, $basePropertyFactory
        );
        $intelligenceRoll = new Integer1To6($intelligenceRollValue);
        $intelligence = $this->createFortuneProperty(
            $professionLevel, $fate, $intelligenceRoll, Intelligence::INTELLIGENCE, $basePropertyFactory
        );
        $charismaRoll = new Integer1To6($charismaRollValue);
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
        ProfessionLevel $professionLevel,
        ExceptionalityFate $fate,
        Integer1To6 $roll,
        $propertyCode,
        BasePropertiesFactory $basePropertyFactory
    )
    {
        if ($professionLevel->isPrimaryProperty($propertyCode)) {
            $value = $fate->getPrimaryPropertyBonusOnFortune($roll);
        } else {
            $value = $fate->getSecondaryPropertyBonusOnFortune($roll);
        }

        return $basePropertyFactory->createProperty($value, $propertyCode);
    }

    /**
     * @param ExceptionalityFate $fate
     * @param ProfessionLevel $professionLevel
     * @param int $chosenStrengthValue
     * @param int $chosenAgilityValue
     * @param int $chosenKnackValue
     * @param int $chosenWillValue
     * @param int $chosenIntelligenceValue
     * @param int $chosenCharismaValue
     * @return ChosenProperties
     */
    public function createChosenProperties(
        ExceptionalityFate $fate,
        ProfessionLevel $professionLevel,
        $chosenStrengthValue,
        $chosenAgilityValue,
        $chosenKnackValue,
        $chosenWillValue,
        $chosenIntelligenceValue,
        $chosenCharismaValue
    )
    {
        $this->checkChosenProperties(
            $chosenStrength = Strength::getIt($chosenStrengthValue),
            $chosenAgility = Agility::getIt($chosenAgilityValue),
            $chosenKnack = Knack::getIt($chosenKnackValue),
            $chosenWill = Will::getIt($chosenWillValue),
            $chosenIntelligence = Intelligence::getIt($chosenIntelligenceValue),
            $chosenCharisma = Charisma::getIt($chosenCharismaValue),
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
                . " and fate {$fate::getCode()}"
            );
        }
    }

    private function checkChosenPropertiesSum($primaryPropertiesSum, $secondaryPropertiesSum, ExceptionalityFate $fate, ProfessionLevel $professionLevel)
    {
        if ($primaryPropertiesSum !== $fate->getPrimaryPropertiesBonusOnChoice()) {
            throw new Exceptions\InvalidSumOfChosenProperties(
                "Expected sum of primary properties is {$fate->getPrimaryPropertiesBonusOnChoice()}, got $primaryPropertiesSum"
                . " for profession {$professionLevel->getProfession()->getValue()} and fate {$fate::getCode()}"
            );
        }

        if ($secondaryPropertiesSum !== $fate->getSecondaryPropertiesBonusOnChoice()) {
            throw new Exceptions\InvalidSumOfChosenProperties(
                "Expected sum of secondary properties is {$fate->getSecondaryPropertiesBonusOnChoice()}, got $secondaryPropertiesSum"
                . " for profession {$professionLevel->getProfession()->getValue()} and fate {$fate::getCode()}"
            );
        }
    }
}
