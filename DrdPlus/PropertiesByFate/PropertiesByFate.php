<?php
namespace DrdPlus\PropertiesByFate;

use Doctrineum\Entity\Entity;
use DrdPlus\Codes\History\ChoiceCode;
use DrdPlus\Codes\History\FateCode;
use DrdPlus\Codes\Properties\PropertyCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\BaseProperty;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use Granam\Strict\Object\StrictObject;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="choice", type="string")
 * @ORM\DiscriminatorMap({
 *     "fortune" = "\DrdPlus\PropertiesByFate\FortuneProperties",
 *     "chosen" = "\DrdPlus\PropertiesByFate\ChosenProperties",
 * })
 */
abstract class PropertiesByFate extends StrictObject implements Entity
{

    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var Strength
     * @ORM\Column(type="strength")
     */
    private $strength;
    /**
     * @var Agility
     * @ORM\Column(type="agility")
     */
    private $agility;
    /**
     * @var Knack
     * @ORM\Column(type="knack")
     */
    private $knack;
    /**
     * @var Will
     * @ORM\Column(type="will")
     */
    private $will;
    /**
     * @var Intelligence
     * @ORM\Column(type="intelligence")
     */
    private $intelligence;
    /**
     * @var Charisma
     * @ORM\Column(type="charisma")
     */
    private $charisma;
    /**
     * @var FateCode
     * @ORM\Column(type="fate_code")
     */
    private $fateCode;

    /**
     * @param Strength $strength
     * @param Agility $agility
     * @param Knack $knack
     * @param Will $will
     * @param Intelligence $intelligence
     * @param Charisma $charisma
     * @param FateCode $fateCode
     */
    protected function __construct(
        Strength $strength,
        Agility $agility,
        Knack $knack,
        Will $will,
        Intelligence $intelligence,
        Charisma $charisma,
        FateCode $fateCode
    )
    {
        $this->strength = $strength;
        $this->agility = $agility;
        $this->knack = $knack;
        $this->will = $will;
        $this->intelligence = $intelligence;
        $this->charisma = $charisma;
        $this->fateCode = $fateCode;
    }

    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @return Strength
     */
    public function getStrength(): Strength
    {
        return $this->strength;
    }

    /**
     * @return Agility
     */
    public function getAgility(): Agility
    {
        return $this->agility;
    }

    /**
     * @return Knack
     */
    public function getKnack(): Knack
    {
        return $this->knack;
    }

    /**
     * @return Will
     */
    public function getWill(): Will
    {
        return $this->will;
    }

    /**
     * @return Intelligence
     */
    public function getIntelligence(): Intelligence
    {
        return $this->intelligence;
    }

    /**
     * @return Charisma
     */
    public function getCharisma(): Charisma
    {
        return $this->charisma;
    }

    /**
     * @return FateCode
     */
    public function getFateCode(): FateCode
    {
        return $this->fateCode;
    }

    /**
     * @return ChoiceCode
     */
    abstract public function getChoiceCode(): ChoiceCode;

    /**
     * @param PropertyCode $propertyCode
     * @return BaseProperty
     * @throws \DrdPlus\PropertiesByFate\Exceptions\NotFateAffectedProperty
     */
    public function getProperty(PropertyCode $propertyCode): BaseProperty
    {
        switch ($propertyCode->getValue()) {
            case PropertyCode::STRENGTH :
                return $this->getStrength();
            case PropertyCode::AGILITY :
                return $this->getAgility();
            case PropertyCode::KNACK :
                return $this->getKnack();
            case PropertyCode::WILL :
                return $this->getWill();
            case PropertyCode::INTELLIGENCE :
                return $this->getIntelligence();
            case PropertyCode::CHARISMA :
                return $this->getCharisma();
            default :
                throw new Exceptions\NotFateAffectedProperty(
                    "Required property {$propertyCode} is not affected by fate"
                );
        }
    }
}