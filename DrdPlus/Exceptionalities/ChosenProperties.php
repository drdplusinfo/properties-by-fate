<?php
namespace DrdPlus\Exceptionalities;

use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;

/**
 * @ORM\Entity()
 */
class ChosenProperties extends ExceptionalityProperties
{

    public function __construct(
        Strength $strength,
        Agility $agility,
        Knack $knack,
        Will $will,
        Intelligence $intelligence,
        Charisma $charisma
    )
    {
        parent::__construct($strength, $agility, $knack, $will, $intelligence, $charisma);
    }
}
