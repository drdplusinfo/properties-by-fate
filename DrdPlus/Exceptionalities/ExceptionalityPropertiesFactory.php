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
        ProfessionLevel $profession,
        RollInterface $strengthRoll,
        RollInterface $agilityRoll,
        RollInterface $knackRoll,
        RollInterface $willRoll,
        RollInterface $intelligenceRoll,
        RollInterface $charismaRoll
    )
    {
        $strength = $this->createFortuneStrength($profession, $fate, $strengthRoll);
        $agility = $this->createFortuneAgility($profession, $fate, $agilityRoll);
        $knack = $this->createFortuneKnack($profession, $fate, $knackRoll);
        $will = $this->createFortuneWill($profession, $fate, $willRoll);
        $intelligence = $this->createFortuneIntelligence($profession, $fate, $intelligenceRoll);
        $charisma = $this->createFortuneCharisma($profession, $fate, $charismaRoll);

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
        $this->checkFortunePropertyValue($strength, $fate, $profession);

        return $strength;
    }

    /**
     * @param BaseProperty $property
     * @param ExceptionalityFate $fate
     * @param ProfessionLevel $profession
     */
    private function checkFortunePropertyValue(BaseProperty $property, ExceptionalityFate $fate, ProfessionLevel $profession)
    {
        if ($property->getValue() > $fate->getUpToSingleProperty()) {
            throw new \LogicException(
                ucfirst($property->getCode()) . " bonus on fortune should be at most {$fate->getUpToSingleProperty()}"
                . " for profession {$profession->getProfession()->getCode()}, is $property"
            );
        }
    }

    private function createFortuneAgility(ProfessionLevel $profession, ExceptionalityFate $fate, RollInterface $agilityRoll)
    {
        if ($profession->isPrimaryProperty(Agility::AGILITY)) {
            $agilityValue = $fate->getPrimaryPropertyBonusOnFortune($agilityRoll);
        } else {
            $agilityValue = $fate->getSecondaryPropertyBonusOnFortune($agilityRoll);
        }

        $agility = Agility::getIt($agilityValue);
        $this->checkFortunePropertyValue($agility, $fate, $profession);

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
        $this->checkFortunePropertyValue($knack, $fate, $profession);

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
        $this->checkFortunePropertyValue($will, $fate, $profession);

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

    private function createFortuneCharisma(ProfessionLevel $profession, ExceptionalityFate $fate, RollInterface $charismaRoll)
    {
        if ($profession->isPrimaryProperty(Charisma::CHARISMA)) {
            $charismaValue = $fate->getPrimaryPropertyBonusOnFortune($charismaRoll);
        } else {
            $charismaValue = $fate->getSecondaryPropertyBonusOnFortune($charismaRoll);
        }

        $charisma = Charisma::getIt($charismaValue);
        $this->checkFortunePropertyValue($charisma, $fate, $profession);

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
        $this->checkChosenProperty($professionLevel, $fate, $chosenStrength);
        $this->checkChosenProperty($professionLevel, $fate, $chosenAgility);
        $this->checkChosenProperty($professionLevel, $fate, $chosenKnack);
        $this->checkChosenProperty($professionLevel, $fate, $chosenWill);
        $this->checkChosenProperty($professionLevel, $fate, $chosenIntelligence);
        $this->checkChosenProperty($professionLevel, $fate, $chosenCharisma);

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

    private function checkChosenProperty(ProfessionLevel $profession, ExceptionalityFate $fate, BaseProperty $chosenProperty)
    {
        if ($profession->isPrimaryProperty($chosenProperty->getCode())) {
            $maximalValue = $fate->getPrimaryPropertiesBonusOnChoice();
        } else {
            $maximalValue = $fate->getSecondaryPropertiesBonusOnChoice();
        }

        $this->checkChosenPropertyValue($maximalValue, $chosenProperty, $fate, $profession);
    }

    private function checkChosenPropertyValue($maximalValue, BaseProperty $chosenProperty, ExceptionalityFate $fate, ProfessionLevel $professionLevel)
    {
        if ($chosenProperty->getValue() > $maximalValue) {
            throw new \LogicException(
                "Required {$chosenProperty->getCode()} of value {$chosenProperty->getValue()} is higher then allowed"
                . " maximum $maximalValue for profession {$professionLevel->getProfession()->getCode()} and fate {$fate->getCode()}"
            );
        }
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
            /** @var BaseProperty $property */
            if ($profession->isPrimaryProperty($property->getCode())) {
                $primaryPropertiesSum += $property->getValue();
            } else {
                $secondaryPropertiesSum += $property->getValue();
            }
        }

        if ($primaryPropertiesSum !== $fate->getPrimaryPropertiesBonusOnChoice()) {
            throw new \LogicException(
                "Expected sum of primary properties was {$fate->getPrimaryPropertiesBonusOnChoice()}, got $primaryPropertiesSum"
            );
        }

        if ($secondaryPropertiesSum !== $fate->getSecondaryPropertiesBonusOnChoice()) {
            throw new \LogicException(
                "Expected sum of secondary properties was {$fate->getSecondaryPropertiesBonusOnChoice()}, got $secondaryPropertiesSum"
            );
        }
    }

}
