<?php
namespace DrdPlus\Exceptionalities\Choices;

class Fortune extends ExceptionalityChoice
{
    const FORTUNE = 'fortune';

    /**
     * @return Fortune
     */
    public static function getIt()
    {
        return parent::getIt();
    }
}
