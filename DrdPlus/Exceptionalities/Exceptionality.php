<?php
namespace DrdPlus\Exceptionalities;

use DrdPlus\Exceptionalities\Choices\ExceptionalityChoice;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use Granam\Strict\Object\StrictObject;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Exceptionality extends StrictObject
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
     * @var ExceptionalityChoice
     *
     * @ORM\Column(type="exceptionality_choice")
     */
    private $exceptionalityChoice;

    /**
     * @var ExceptionalityChoice
     *
     * @ORM\Column(type="exceptionality_fate")
     */
    private $exceptionalityFate;

    /**
     * @var ExceptionalityProperties
     *
     * @ORM\OneToOne(targetEntity="DrdPlus\Exceptionalities\ExceptionalityProperties")
     */
    private $exceptionalityProperties;

    public function __construct(
        ExceptionalityChoice $exceptionalityChoice,
        ExceptionalityFate $exceptionalityKind,
        ExceptionalityProperties $exceptionalityProperties
    )
    {
        $this->exceptionalityChoice = $exceptionalityChoice;
        $this->exceptionalityFate = $exceptionalityKind;
        $this->exceptionalityProperties = $exceptionalityProperties;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ExceptionalityChoice
     */
    public function getExceptionalityChoice()
    {
        return $this->exceptionalityChoice;
    }

    /**
     * @return ExceptionalityFate
     */
    public function getExceptionalityFate()
    {
        return $this->exceptionalityFate;
    }

    /**
     * @return ExceptionalityProperties
     */
    public function getExceptionalityProperties()
    {
        return $this->exceptionalityProperties;
    }

}
