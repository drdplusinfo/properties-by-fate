<?php
namespace DrdPlus\Exceptionalities\Properties;

use Doctrineum\Entity\Entity;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use Granam\Scalar\Tools\ToString;
use Granam\Strict\Object\StrictObject;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class ExceptionalityProperties extends StrictObject implements Entity
{

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Strength
     *
     * @ORM\Column(type="strength")
     */
    protected $strength;

    /**
     * @var Agility
     *
     * @ORM\Column(type="agility")
     */
    protected $agility;

    /**
     * @var Knack
     *
     * @ORM\Column(type="knack")
     */
    protected $knack;

    /**
     * @var Will
     *
     * @ORM\Column(type="will")
     */
    protected $will;

    /**
     * @var Intelligence
     *
     * @ORM\Column(type="intelligence")
     */
    protected $intelligence;

    /**
     * @var Charisma
     *
     * @ORM\Column(type="charisma")
     */
    protected $charisma;

    protected function __construct(
        Strength $strength,
        Agility $agility,
        Knack $knack,
        Will $will,
        Intelligence $intelligence,
        Charisma $charisma
    )
    {
        $this->strength = $strength;
        $this->agility = $agility;
        $this->knack = $knack;
        $this->will = $will;
        $this->intelligence = $intelligence;
        $this->charisma = $charisma;
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

    public function getProperty($propertyCode)
    {
        switch (ToString::toString($propertyCode)) {
            case Strength::STRENGTH :
                return $this->getStrength();
            case Agility::AGILITY :
                return $this->getAgility();
            case Knack::KNACK :
                return $this->getKnack();
            case Will::WILL :
                return $this->getWill();
            case Intelligence::INTELLIGENCE :
                return $this->getIntelligence();
            case Charisma::CHARISMA :
                return $this->getCharisma();
            default :
                throw new Exceptions\UnknownBasePropertyCode($propertyCode);
        }
    }

}
