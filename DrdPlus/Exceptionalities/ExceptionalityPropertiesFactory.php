<?php
namespace DrdPlus\Exceptionalities;

use Drd\DiceRoll\RollInterface;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use DrdPlus\ProfessionLevels\ProfessionLevel;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\BaseProperty;
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
        RollInterface $strengthRoll,
        RollInterface $agilityRoll,
        RollInterface $knackRoll,
        RollInterface $willRoll,
        RollInterface $intelligenceRoll,
        RollInterface $charismaRoll
    )
    {
        $strength = $this->createFortuneStrength($professionLevel, $fate, $strengthRoll);
        $agility = $this->createFortuneAgility($professionLevel, $fate, $agilityRoll);
        $knack = $this->createFortuneKnack($professionLevel, $fate, $knackRoll);
        $will = $this->createFortuneWill($professionLevel, $fate, $willRoll);
        $intelligence = $this->createFortuneIntelligence($professionLevel, $fate, $intelligenceRoll);
        $charisma = $this->createFortuneCharisma($professionLevel, $fate, $charismaRoll);

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

    private function createFortuneStrength(ProfessionLevel $profession, ExceptionalityFate $fate, RollInterface $strengthRoll)
    {
        if ($profession->isPrimaryProperty(Strength::STRENGTH)) {
            $strengthValue = $fate->getPrimaryPropertyBonusOnFortune($strengthRoll);
        } else {
            $strengthValue = $fate->getSecondaryPropertyBonusOnFortune($strengthRoll);
        }

        $strength = Strength::getIt($strengthValue);

        return $strength;
    }

    private function createFortuneAgility(ProfessionLevel $profession, ExceptionalityFate $fate, RollInterface $agilityRoll)
    {
        if ($profession->isPrimaryProperty(Agility::AGILITY)) {
            $agilityValue = $fate->getPrimaryPropertyBonusOnFortune($agilityRoll);
        } else {
            $agilityValue = $fate->getSecondaryPropertyBonusOnFortune($agilityRoll);
        }

        $agility = Agility::getIt($agilityValue);

        return $agility;
    }

    private function createFortuneKnack(ProfessionLevel $profession, ExceptionalityFate $fate, RollInterface $knackRoll)
    {
        if ($profession->isPrimaryProperty(Knack::KNACK)) {
            $knackValue = $fate->getPrimaryPropertyBonusOnFortune($knackRoll);
        } else {
            $knackValue = $fate->getSecondaryPropertyBonusOnFortune($knackRoll);
        }

        $knack = Knack::getIt($knackValue);

        return $knack;
    }

    private function createFortuneWill(ProfessionLevel $profession, ExceptionalityFate $fate, RollInterface $willRoll)
    {
        if ($profession->isPrimaryProperty(Will::WILL)) {
            $willValue = $fate->getPrimaryPropertyBonusOnFortune($willRoll);
        } else {
            $willValue = $fate->getSecondaryPropertyBonusOnFortune($willRoll);
        }

        $will = Will::getIt($willValue);

        return $will;
    }

    private function createFortuneIntelligence(ProfessionLevel $profession, ExceptionalityFate $fate, RollInterface $intelligenceRoll)
    {
        if ($profession->isPrimaryProperty(Intelligence::INTELLIGENCE)) {
            $intelligenceValue = $fate->getPrimaryPropertyBonusOnFortune($intelligenceRoll);
        } else {
            $intelligenceValue = $fate->getSecondaryPropertyBonusOnFortune($intelligenceRoll);
        }

        return Intelligence::getIt($intelligenceValue);
    }

    private function createFortuneCharisma(ProfessionLevel $professionLevel, ExceptionalityFate $fate, RollInterface $charismaRoll)
    {
        if ($professionLevel->isPrimaryProperty(Charisma::CHARISMA)) {
            $charismaValue = $fate->getPrimaryPropertyBonusOnFortune($charismaRoll);
        } else {
            $charismaValue = $fate->getSecondaryPropertyBonusOnFortune($charismaRoll);
        }

        $charisma = Charisma::getIt($charismaValue);

        return $charisma;
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
        ProfessionLevel $profession,
        ExceptionalityFate $fate
    )
    {
        $primaryPropertiesSum = 0;
        $secondaryPropertiesSum = 0;
        foreach ([$strength, $agility, $knack, $will, $intelligence, $charisma] as $property) {
            $this->checkChosenProperty($profession, $fate, $property);

            /** @var BaseProperty $property */
            if ($profession->isPrimaryProperty($property->getCode())) {
                $primaryPropertiesSum += $property->getValue();
            } else {
                $secondaryPropertiesSum += $property->getValue();
            }
        }

        $this->checkChosenPropertiesSum($primaryPropertiesSum, $secondaryPropertiesSum, $fate, $profession);
    }

    private function checkChosenProperty(ProfessionLevel $professionLevel, ExceptionalityFate $fate, BaseProperty $chosenProperty)
    {
        if ($chosenProperty->getValue() > $fate->getUpToSingleProperty()) {
            throw new Exceptions\InvalidValueOfChosenProperty(
                "Required {$chosenProperty->getCode()} of value {$chosenProperty->getValue()} is higher than allowed"
                . " maximum {$fate->getUpToSingleProperty()} for profession {$professionLevel->getProfession()->getCode()}"
                . " and fate {$fate->getCode()}"
            );
        }
    }

    private function checkChosenPropertiesSum($primaryPropertiesSum, $secondaryPropertiesSum, ExceptionalityFate $fate, ProfessionLevel $professionLevel)
    {
        if ($primaryPropertiesSum !== $fate->getPrimaryPropertiesBonusOnChoice()) {
            throw new Exceptions\InvalidSumOfChosenProperties(
                "Expected sum of primary properties is {$fate->getPrimaryPropertiesBonusOnChoice()}, got $primaryPropertiesSum"
                . " for profession {$professionLevel->getProfession()->getCode()} and fate {$fate->getCode()}"
            );
        }

        if ($secondaryPropertiesSum !== $fate->getSecondaryPropertiesBonusOnChoice()) {
            throw new Exceptions\InvalidSumOfChosenProperties(
                "Expected sum of secondary properties is {$fate->getSecondaryPropertiesBonusOnChoice()}, got $secondaryPropertiesSum"
                . " for profession {$professionLevel->getProfession()->getCode()} and fate {$fate->getCode()}"
            );
        }
    }
}
