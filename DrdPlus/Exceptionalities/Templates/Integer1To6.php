<?php
namespace DrdPlus\Exceptionalities\Templates;

use Granam\Integer\IntegerObject;
use Granam\Tools\ValueDescriber;

class Integer1To6 extends IntegerObject
{
    public function __construct($value, $paranoid = false)
    {
        parent::__construct($value);
        $this->guardValueInRange($this->getValue());
    }

    /**
     * @param int $value
     */
    private function guardValueInRange($value)
    {
        if ($value < 1 || $value > 6) {
            throw new Exceptions\ValueNotInRange(
                'Expected value between 1 and 6, got ' . ValueDescriber::describe($value)
            );
        }
    }
}