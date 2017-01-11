<?php
namespace DrdPlus\PropertiesByFate;

use Doctrineum\Entity\Entity;
use DrdPlus\Codes\ChoiceCode;
use DrdPlus\Codes\FateCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use Granam\Strict\Object\StrictObject;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class ExceptionalityProperties extends StrictObject implements Entity
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

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Strength
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * @return Agility
     */
    public function getAgility()
    {
        return $this->agility;
    }

    /**
     * @return Knack
     */
    public function getKnack()
    {
        return $this->knack;
    }

    /**
     * @return Will
     */
    public function getWill()
    {
        return $this->will;
    }

    /**
     * @return Intelligence
     */
    public function getIntelligence()
    {
        return $this->intelligence;
    }

    /**
     * @return Charisma
     */
    public function getCharisma()
    {
        return $this->charisma;
    }

    /**
     * @return FateCode
     */
    public function getFateCode()
    {
        return $this->fateCode;
    }

    /**
     * @return ChoiceCode
     */
    abstract public function getChoiceCode();
}