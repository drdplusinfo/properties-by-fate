<?php
namespace DrdPlus\Exceptionalities\Choices;

class PlayerDecision extends ExceptionalityChoice
{
    const PLAYER_DECISION = 'player_decision';

    /**
     * @return PlayerDecision
     */
    public static function getIt()
    {
        return parent::getIt();
    }
}
