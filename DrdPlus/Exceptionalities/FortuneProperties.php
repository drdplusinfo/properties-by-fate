<?php
namespace DrdPlus\Exceptionalities;

use Drd\DiceRoll\RollInterface;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;

/**
 * @ORM\Entity()
 */
class FortuneProperties extends ExceptionalityProperties
{
    /**
     * @var int
     * @ORM\Column(type="int")
     */
    private $strengthRoll;
    /**
     * @var int
     * @ORM\Column(type="int")
     */
    private $agilityRoll;
    /**
     * @var int
     * @ORM\Column(type="int")
     */
    private $knackRoll;
    /**
     * @var int
     * @ORM\Column(type="int")
     */
    private $willRoll;
    /**
     * @var int
     * @ORM\Column(type="int")
     */
    private $intelligenceRoll;
    /**
     * @var int
     * @ORM\Column(type="int")
     */
    private $charismaRoll;

    public function __construct(
        Strength $strength,
        RollInterface $strengthRoll,
        Agility $agility,
        RollInterface $agilityRoll,
        Knack $knack,
        RollInterface $knackRoll,
        Will $will,
        RollInterface $willRoll,
        Intelligence $intelligence,
        RollInterface $intelligenceRoll,
        Charisma $charisma,
        RollInterface $charismaRoll
    )
    {
        parent::__construct($strength, $agility, $knack, $will, $intelligence, $charisma);
        $this->strengthRoll = $strengthRoll->getLastRollSummary();
        $this->agilityRoll = $agilityRoll->getLastRollSummary();
        $this->knackRoll = $knackRoll->getLastRollSummary();
        $this->willRoll = $willRoll->getLastRollSummary();
        $this->intelligenceRoll = $intelligenceRoll->getLastRollSummary();
        $this->charismaRoll = $charismaRoll->getLastRollSummary();
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
