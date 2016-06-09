<?php
namespace DrdPlus\Exceptionalities;

use Doctrineum\Entity\Entity;
use DrdPlus\Exceptionalities\Choices\ExceptionalityChoice;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use DrdPlus\Exceptionalities\Properties\ExceptionalityProperties;
use Granam\Strict\Object\StrictObject;
use Doctrine\ORM\Mapping AS ORM;

/**
 * Container for all the pieces making together the exceptionality
 *
 * @ORM\Entity()
 */
class Exceptionality extends StrictObject implements Entity
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
     * @var ExceptionalityFate
     *
     * @ORM\Column(type="exceptionality_fate")
     */
    private $exceptionalityFate;

    /**
     * @var ExceptionalityProperties
     *
     * @ORM\OneToOne(targetEntity="DrdPlus\Exceptionalities\Properties\ExceptionalityProperties", cascade={"persist"})
     */
    private $exceptionalityProperties;

    public function __construct(
        ExceptionalityChoice $exceptionalityChoice,
        ExceptionalityFate $exceptionalityFate,
        ExceptionalityProperties $exceptionalityProperties
    )
    {
        $this->exceptionalityChoice = $exceptionalityChoice;
        $this->exceptionalityFate = $exceptionalityFate;
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
