<?php
namespace DrdPlus\Tests\Exceptionalities;

use DrdPlus\Exceptionalities\ChosenProperties;

class ChosenPropertiesTest extends ExceptionalityPropertiesTest
{
    protected function createExceptionalityProperties()
    {
        return new ChosenProperties(
            $this->getStrength(),
            $this->getAgility(),
            $this->getKnack(),
            $this->getWill(),
            $this->getIntelligence(),
            $this->getCharisma()
        );
    }

}
