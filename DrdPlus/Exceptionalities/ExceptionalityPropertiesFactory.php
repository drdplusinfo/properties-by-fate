<?php
namespace DrdPlus\Exceptionalities;

use Drd\DiceRoll\RollInterface;
use DrdPlus\Exceptionalities\Fates\AbstractExceptionalityFate;
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
        AbstractExceptionalityFate $fate,
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

    private function createFortuneStrength(ProfessionLevel $profession, AbstractExceptionalityFate $fate, RollInterface $strengthRoll)
    {
        if ($profession->isPrimaryProperty(Strength::STRENGTH)) {
            $strengthValue = $fate->getPrimaryPropertiesBonusOnFortune($strengthRoll);
        } else {
            $strengthValue = $fate->getSecondaryPropertiesBonusOnFortune($strengthRoll);
        }

        $strength = Strength::getIt($strengthValue);
        $this->checkFortunePropertyValue($strength, $fate, $profession);

        return $strength;
    }

    /**
     * @param BaseProperty $property
     * @param AbstractExceptionalityFate $fate
     * @param ProfessionLevel $profession
     */
    private function checkFortunePropertyValue(BaseProperty $property, AbstractExceptionalityFate $fate, ProfessionLevel $profession)
    {
        if ($property->getValue() > $fate->getUpToSingleProperty()) {
            throw new \LogicException(
                ucfirst($property->getCode()) . " bonus on fortune should be at most {$fate->getUpToSingleProperty()} for profession {$profession->getProfession()->getCode()}, is $property"
            );
        }
    }

    private function createFortuneAgility(ProfessionLevel $profession, AbstractExceptionalityFate $fate, RollInterface $agilityRoll)
    {
        if ($profession->isPrimaryProperty(Agility::AGILITY)) {
            $agilityValue = $fate->getPrimaryPropertiesBonusOnFortune($agilityRoll);
        } else {
            $agilityValue = $fate->getSecondaryPropertiesBonusOnFortune($agilityRoll);
        }

        $agility = Agility::getIt($agilityValue);
        $this->checkFortunePropertyValue($agility, $fate, $profession);

        return $agility;
    }

    private function createFortuneKnack(ProfessionLevel $profession, AbstractExceptionalityFate $fate, RollInterface $knackRoll)
    {
        if ($profession->isPrimaryProperty(Knack::KNACK)) {
            $knackValue = $fate->getPrimaryPropertiesBonusOnFortune($knackRoll);
        } else {
            $knackValue = $fate->getSecondaryPropertiesBonusOnFortune($knackRoll);
        }

        $knack = Knack::getIt($knackValue);
        $this->checkFortunePropertyValue($knack, $fate, $profession);

        return $knack;
    }

    private function createFortuneWill(ProfessionLevel $profession, AbstractExceptionalityFate $fate, RollInterface $willRoll)
    {
        if ($profession->isPrimaryProperty(Will::WILL)) {
            $willValue = $fate->getPrimaryPropertiesBonusOnFortune($willRoll);
        } else {
            $willValue = $fate->getSecondaryPropertiesBonusOnFortune($willRoll);
        }

        $will = Will::getIt($willValue);
        $this->checkFortunePropertyValue($will, $fate, $profession);

        return $will;
    }

    private function createFortuneIntelligence(ProfessionLevel $profession, AbstractExceptionalityFate $fate, RollInterface $intelligenceRoll)
    {
        if ($profession->isPrimaryProperty(Intelligence::INTELLIGENCE)) {
            $intelligenceValue = $fate->getPrimaryPropertiesBonusOnFortune($intelligenceRoll);
        } else {
            $intelligenceValue = $fate->getSecondaryPropertiesBonusOnFortune($intelligenceRoll);
        }

        return Intelligence::getIt($intelligenceValue);
    }

    private function createFortuneCharisma(ProfessionLevel $profession, AbstractExceptionalityFate $fate, RollInterface $charismaRoll)
    {
        if ($profession->isPrimaryProperty(Charisma::CHARISMA)) {
            $charismaValue = $fate->getPrimaryPropertiesBonusOnFortune($charismaRoll);
        } else {
            $charismaValue = $fate->getSecondaryPropertiesBonusOnFortune($charismaRoll);
        }

        $charisma = Charisma::getIt($charismaValue);
        $this->checkFortunePropertyValue($charisma, $fate, $profession);

        return $charisma;
    }

    public function createChosenProperties(
        AbstractExceptionalityFate $fate,
        ProfessionLevel $profession,
        Strength $chosenStrength,
        Agility $chosenAgility,
        Knack $chosenKnack,
        Will $chosenWill,
        Intelligence $chosenIntelligence,
        Charisma $chosenCharisma
    )
    {
        $this->checkChosenProperty($profession, $fate, $chosenStrength);
        $this->checkChosenProperty($profession, $fate, $chosenAgility);
        $this->checkChosenProperty($profession, $fate, $chosenKnack);
        $this->checkChosenProperty($profession, $fate, $chosenWill);
        $this->checkChosenProperty($profession, $fate, $chosenIntelligence);
        $this->checkChosenProperty($profession, $fate, $chosenCharisma);

        $this->checkChosenProperties($chosenStrength, $chosenAgility, $chosenKnack, $chosenWill, $chosenIntelligence, $chosenCharisma, $profession, $fate);

        return new ChosenProperties($chosenStrength, $chosenAgility, $chosenKnack, $chosenWill, $chosenIntelligence, $chosenCharisma);
    }

    private function checkChosenProperty(ProfessionLevel $profession, AbstractExceptionalityFate $fate, BaseProperty $chosenProperty)
    {
        if ($profession->isPrimaryProperty($chosenProperty->getCode())) {
            $maximalValue = $fate->getPrimaryPropertiesBonusOnChoice();
        } else {
            $maximalValue = $fate->getSecondaryPropertiesBonusOnChoice();
        }

        $this->checkChosenPropertyValue($maximalValue, $chosenProperty, $fate, $profession);
    }

    private function checkChosenPropertyValue($maximalValue, BaseProperty $chosenProperty, AbstractExceptionalityFate $fate, ProfessionLevel $professionLevel)
    {
        if ($chosenProperty->getValue() > $maximalValue) {
            throw new \LogicException(
                "Required {$chosenProperty->getCode()} of value {$chosenProperty->getValue()} is higher then allowed"
                . " maximum $maximalValue for profession {$professionLevel->getProfession()->getCode()} and fate {$fate->getFateName()}"
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
        AbstractExceptionalityFate $fate
    )
    {
        $primaryPropertySum = 0;
        $secondaryPropertySum = 0;
        foreach ([$strength, $agility, $knack, $will, $intelligence, $charisma] as $property) {
            /** @var BaseProperty $property */
            if ($profession->isPrimaryProperty($property->getCode())) {
                $primaryPropertySum += $property->getValue();
            } else {
                $secondaryPropertySum += $property->getValue();
            }
        }

        if ($primaryPropertySum !== $fate->getPrimaryPropertiesBonusOnChoice()) {
            throw new \LogicException(
                "Expected sum of primary properties is {$fate->getPrimaryPropertiesBonusOnChoice()}, got $primaryPropertySum"
            );
        }

        if ($secondaryPropertySum !== $fate->getSecondaryPropertiesBonusOnChoice()) {
            throw new \LogicException(
                "Expected sum of secondary properties is {$fate->getSecondaryPropertiesBonusOnChoice()}, got $secondaryPropertySum"
            );
        }
    }

}
