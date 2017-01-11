<?php
namespace DrdPlus\PropertiesByFate;

use Drd\DiceRoll\Templates\Rolls\Roll1d6;
use DrdPlus\Codes\ChoiceCode;
use DrdPlus\Codes\FateCode;
use DrdPlus\Codes\PropertyCode;
use DrdPlus\Professions\Profession;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\BasePropertiesFactory;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use Doctrine\ORM\Mapping as ORM;
use DrdPlus\Tables\History\InfluenceOfFortuneTable;

/**
 * @ORM\Entity()
 */
class FortuneProperties extends ExceptionalityProperties
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $strengthRoll;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $agilityRoll;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $knackRoll;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $willRoll;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $intelligenceRoll;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $charismaRoll;

    /**
     * @param Roll1d6 $strengthRoll
     * @param Roll1d6 $agilityRoll
     * @param Roll1d6 $knackRoll
     * @param Roll1d6 $willRoll
     * @param Roll1d6 $intelligenceRoll
     * @param Roll1d6 $charismaRoll
     * @param FateCode $fateCode
     * @param Profession $profession
     * @param InfluenceOfFortuneTable $influenceOfFortuneTable
     * @param BasePropertiesFactory $basePropertiesFactory
     * @throws \DrdPlus\PropertiesByFate\Exceptions\InvalidValueOfChosenProperty
     * @throws \DrdPlus\PropertiesByFate\Exceptions\InvalidSumOfChosenProperties
     */
    public function __construct(
        Roll1d6 $strengthRoll,
        Roll1d6 $agilityRoll,
        Roll1d6 $knackRoll,
        Roll1d6 $willRoll,
        Roll1d6 $intelligenceRoll,
        Roll1d6 $charismaRoll,
        FateCode $fateCode,
        Profession $profession,
        InfluenceOfFortuneTable $influenceOfFortuneTable,
        BasePropertiesFactory $basePropertiesFactory
    )
    {
        $strength = $this->createFortuneProperty(
            $profession, $fateCode, $strengthRoll, PropertyCode::getIt(PropertyCode::STRENGTH), $influenceOfFortuneTable, $basePropertiesFactory
        );
        $agility = $this->createFortuneProperty(
            $profession, $fateCode, $agilityRoll, PropertyCode::getIt(PropertyCode::AGILITY), $influenceOfFortuneTable, $basePropertiesFactory
        );
        $knack = $this->createFortuneProperty(
            $profession, $fateCode, $knackRoll, PropertyCode::getIt(PropertyCode::KNACK), $influenceOfFortuneTable, $basePropertiesFactory
        );
        $will = $this->createFortuneProperty(
            $profession, $fateCode, $willRoll, PropertyCode::getIt(PropertyCode::WILL), $influenceOfFortuneTable, $basePropertiesFactory
        );
        $intelligence = $this->createFortuneProperty(
            $profession, $fateCode, $intelligenceRoll, PropertyCode::getIt(PropertyCode::INTELLIGENCE), $influenceOfFortuneTable, $basePropertiesFactory
        );
        $charisma = $this->createFortuneProperty(
            $profession, $fateCode, $charismaRoll, PropertyCode::getIt(PropertyCode::CHARISMA), $influenceOfFortuneTable, $basePropertiesFactory
        );
        parent::__construct($strength, $agility, $knack, $will, $intelligence, $charisma, $fateCode);
        $this->strengthRoll = $strengthRoll->getValue();
        $this->agilityRoll = $agilityRoll->getValue();
        $this->knackRoll = $knackRoll->getValue();
        $this->willRoll = $willRoll->getValue();
        $this->intelligenceRoll = $intelligenceRoll->getValue();
        $this->charismaRoll = $charismaRoll->getValue();
    }

    /**
     * @param Profession $profession
     * @param FateCode $fateCode
     * @param Roll1d6 $roll
     * @param PropertyCode $propertyCode
     * @param InfluenceOfFortuneTable $influenceOfFortuneTable
     * @param BasePropertiesFactory $basePropertiesFactory
     * @return Strength|Agility|Knack|Will|Intelligence|Charisma
     * @throws \DrdPlus\PropertiesByFate\Exceptions\InvalidValueOfChosenProperty
     * @throws \DrdPlus\PropertiesByFate\Exceptions\InvalidSumOfChosenProperties
     */
    private function createFortuneProperty(
        Profession $profession,
        FateCode $fateCode,
        Roll1d6 $roll,
        PropertyCode $propertyCode,
        InfluenceOfFortuneTable $influenceOfFortuneTable,
        BasePropertiesFactory $basePropertiesFactory
    )
    {
        if ($profession->isPrimaryProperty($propertyCode)) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $value = $influenceOfFortuneTable->getPrimaryPropertyOnFate($fateCode, $roll);
        } else {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $value = $influenceOfFortuneTable->getSecondaryPropertyOnFate($fateCode, $roll);
        }

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $basePropertiesFactory->createProperty($value, $propertyCode);
    }

    /**
     * @return int
     */
    public function getStrengthRoll()
    {
        return $this->strengthRoll;
    }

    /**
     * @return int
     */
    public function getAgilityRoll()
    {
        return $this->agilityRoll;
    }

    /**
     * @return int
     */
    public function getKnackRoll()
    {
        return $this->knackRoll;
    }

    /**
     * @return int
     */
    public function getWillRoll()
    {
        return $this->willRoll;
    }

    /**
     * @return int
     */
    public function getIntelligenceRoll()
    {
        return $this->intelligenceRoll;
    }

    /**
     * @return int
     */
    public function getCharismaRoll()
    {
        return $this->charismaRoll;
    }

    /**
     * @return ChoiceCode
     */
    public function getChoiceCode()
    {
        return ChoiceCode::getIt(ChoiceCode::FORTUNE);
    }

}