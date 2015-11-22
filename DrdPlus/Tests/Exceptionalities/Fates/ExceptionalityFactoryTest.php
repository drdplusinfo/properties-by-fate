<?php
namespace DrdPlus\Exceptionalities;

use DrdPlus\Exceptionalities\Choices\Fortune;
use DrdPlus\Exceptionalities\Choices\PlayerDecision;
use DrdPlus\Exceptionalities\Fates\FateOfCombination;
use DrdPlus\Exceptionalities\Fates\FateOfExceptionalProperties;
use DrdPlus\Exceptionalities\Fates\FateOfGoodRear;
use DrdPlus\Tools\Tests\TestWithMockery;

class ExceptionalityFactoryTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_create_it()
    {
        $instance = new ExceptionalityFactory();
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @depends I_can_create_it
     * @test
     *
     * @param ExceptionalityFactory $factory
     */
    public function I_can_get_good_rear(ExceptionalityFactory $factory)
    {
        $this->assertInstanceOf(FateOfGoodRear::class, $factory->getGoodRear());
    }

    /**
     * @depends I_can_create_it
     * @test
     *
     * @param ExceptionalityFactory $factory
     */
    public function I_can_get_combination(ExceptionalityFactory $factory)
    {
        $this->assertInstanceOf(FateOfCombination::class, $factory->getCombination());
    }

    /**
     * @depends I_can_create_it
     * @test
     *
     * @param ExceptionalityFactory $factory
     */
    public function I_can_get_exceptional_properties(ExceptionalityFactory $factory)
    {
        $this->assertInstanceOf(FateOfExceptionalProperties::class, $factory->getExceptionalProperties());
    }

    /**
     * @depends I_can_create_it
     * @test
     *
     * @param ExceptionalityFactory $factory
     */
    public function I_can_get_player_decision(ExceptionalityFactory $factory)
    {
        $this->assertInstanceOf(PlayerDecision::class, $factory->getPlayerDecision());
    }
    
    /**
     * @depends I_can_create_it
     * @test
     *
     * @param ExceptionalityFactory $factory
     */
    public function I_can_get_fortune(ExceptionalityFactory $factory)
    {
        $this->assertInstanceOf(Fortune::class, $factory->getFortune());
    }
}
