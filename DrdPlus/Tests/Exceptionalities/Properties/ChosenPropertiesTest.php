<?php
namespace DrdPlus\Tests\Exceptionalities\Properties;

use DrdPlus\Exceptionalities\Properties\ChosenProperties;

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
