<?php
namespace DrdPlus\Exceptionalities\Properties;

use DrdPlus\Exceptionalities\Templates\Integer1To6;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use Doctrine\ORM\Mapping as ORM;

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

    public function __construct(
        Strength $strength,
        Integer1To6 $strengthRoll,
        Agility $agility,
        Integer1To6 $agilityRoll,
        Knack $knack,
        Integer1To6 $knackRoll,
        Will $will,
        Integer1To6 $willRoll,
        Intelligence $intelligence,
        Integer1To6 $intelligenceRoll,
        Charisma $charisma,
        Integer1To6 $charismaRoll
    )
    {
        parent::__construct($strength, $agility, $knack, $will, $intelligence, $charisma);
        $this->strengthRoll = $strengthRoll->getValue();
        $this->agilityRoll = $agilityRoll->getValue();
        $this->knackRoll = $knackRoll->getValue();
        $this->willRoll = $willRoll->getValue();
        $this->intelligenceRoll = $intelligenceRoll->getValue();
        $this->charismaRoll = $charismaRoll->getValue();
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

}
