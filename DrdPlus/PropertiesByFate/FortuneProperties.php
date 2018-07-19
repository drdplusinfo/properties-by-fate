<?php
declare(strict_types = 1);

namespace DrdPlus\PropertiesByFate;

use DrdPlus\DiceRolls\Templates\Rolls\Roll1d6;
use DrdPlus\Codes\History\ChoiceCode;
use DrdPlus\Codes\History\FateCode;
use DrdPlus\Codes\Properties\PropertyCode;
use DrdPlus\Professions\Profession;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\BasePropertiesFactory;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use DrdPlus\Tables\Tables;

/**
 * @Doctrine\ORM\Mapping\Entity()
 */
class FortuneProperties extends PropertiesByFate
{
    /**
     * @var int
     * @Doctrine\ORM\Mapping\Column(type="integer")
     */
    private $strengthRoll;
    /**
     * @var int
     * @Doctrine\ORM\Mapping\Column(type="integer")
     */
    private $agilityRoll;
    /**
     * @var int
     * @Doctrine\ORM\Mapping\Column(type="integer")
     */
    private $knackRoll;
    /**
     * @var int
     * @Doctrine\ORM\Mapping\Column(type="integer")
     */
    private $willRoll;
    /**
     * @var int
     * @Doctrine\ORM\Mapping\Column(type="integer")
     */
    private $intelligenceRoll;
    /**
     * @var int
     * @Doctrine\ORM\Mapping\Column(type="integer")
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
     * @param Tables $tables
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
        Tables $tables,
        BasePropertiesFactory $basePropertiesFactory
    )
    {
        $strength = $this->createFortuneProperty(
            $profession, $fateCode, $strengthRoll, PropertyCode::getIt(PropertyCode::STRENGTH), $tables, $basePropertiesFactory
        );
        $agility = $this->createFortuneProperty(
            $profession, $fateCode, $agilityRoll, PropertyCode::getIt(PropertyCode::AGILITY), $tables, $basePropertiesFactory
        );
        $knack = $this->createFortuneProperty(
            $profession, $fateCode, $knackRoll, PropertyCode::getIt(PropertyCode::KNACK), $tables, $basePropertiesFactory
        );
        $will = $this->createFortuneProperty(
            $profession, $fateCode, $willRoll, PropertyCode::getIt(PropertyCode::WILL), $tables, $basePropertiesFactory
        );
        $intelligence = $this->createFortuneProperty(
            $profession, $fateCode, $intelligenceRoll, PropertyCode::getIt(PropertyCode::INTELLIGENCE), $tables, $basePropertiesFactory
        );
        $charisma = $this->createFortuneProperty(
            $profession, $fateCode, $charismaRoll, PropertyCode::getIt(PropertyCode::CHARISMA), $tables, $basePropertiesFactory
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
     * @param Tables $tables
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
        Tables $tables,
        BasePropertiesFactory $basePropertiesFactory
    )
    {
        if ($profession->isPrimaryProperty($propertyCode)) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $value = $tables->getInfluenceOfFortuneTable()->getPrimaryPropertyOnFate($fateCode, $roll);
        } else {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $value = $tables->getInfluenceOfFortuneTable()->getSecondaryPropertyOnFate($fateCode, $roll);
        }

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $basePropertiesFactory->createProperty($value, $propertyCode);
    }

    /**
     * @return int
     */
    public function getStrengthRoll(): int
    {
        return $this->strengthRoll;
    }

    /**
     * @return int
     */
    public function getAgilityRoll(): int
    {
        return $this->agilityRoll;
    }

    /**
     * @return int
     */
    public function getKnackRoll(): int
    {
        return $this->knackRoll;
    }

    /**
     * @return int
     */
    public function getWillRoll(): int
    {
        return $this->willRoll;
    }

    /**
     * @return int
     */
    public function getIntelligenceRoll(): int
    {
        return $this->intelligenceRoll;
    }

    /**
     * @return int
     */
    public function getCharismaRoll(): int
    {
        return $this->charismaRoll;
    }

    /**
     * @return ChoiceCode
     */
    public function getChoiceCode(): ChoiceCode
    {
        return ChoiceCode::getIt(ChoiceCode::FORTUNE);
    }

}