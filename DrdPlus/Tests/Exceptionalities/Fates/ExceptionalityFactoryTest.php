<?php
namespace DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities;

use Doctrine\DBAL\Types\Type;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\Choices\Fortune;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\Choices\PlayerDecision;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\Fates\FateOfCombination;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\Fates\FateOfExceptionalProperties;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\Fates\FateOfGoodRear;
use DrdPlus\Cave\UnitBundle\Tests\TestWithMockery;

class ExceptionalityFactoryTest extends TestWithMockery
{
    /**
     * @test
     */
    public function can_be_created()
    {
        $instance = new ExceptionalityFactory();
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @test
     * @depends can_be_created
     */
    public function good_rear_is_registered_after_factory_creation()
    {
        $this->assertTrue(Type::hasType(FateOfGoodRear::getTypeName()));
    }

    /**
     * @test
     * @depends can_be_created
     */
    public function combination_is_registered_after_factory_creation()
    {
        $this->assertTrue(Type::hasType(FateOfCombination::getTypeName()));
    }

    /**
     * @test
     * @depends can_be_created
     */
    public function exceptional_properties_type_is_registered_after_factory_creation()
    {
        $this->assertTrue(Type::hasType(FateOfExceptionalProperties::getTypeName()));
    }

    /**
     * @depends can_be_created
     * @test
     *
     * @param ExceptionalityFactory $factory
     */
    public function can_give_good_rear(ExceptionalityFactory $factory)
    {
        $this->assertInstanceOf(FateOfGoodRear::class, $factory->getGoodRear());
    }

    /**
     * @depends can_be_created
     * @test
     *
     * @param ExceptionalityFactory $factory
     */
    public function can_give_combination(ExceptionalityFactory $factory)
    {
        $this->assertInstanceOf(FateOfCombination::class, $factory->getCombination());
    }

    /**
     * @depends can_be_created
     * @test
     *
     * @param ExceptionalityFactory $factory
     */
    public function can_give_exceptional_properties(ExceptionalityFactory $factory)
    {
        $this->assertInstanceOf(FateOfExceptionalProperties::class, $factory->getExceptionalProperties());
    }

    /**
     * @depends can_be_created
     * @test
     *
     * @param ExceptionalityFactory $factory
     */
    public function can_give_player_decision(ExceptionalityFactory $factory)
    {
        $this->assertInstanceOf(PlayerDecision::class, $factory->getPlayerDecision());
    }
    
    /**
     * @depends can_be_created
     * @test
     *
     * @param ExceptionalityFactory $factory
     */
    public function can_give_fortune(ExceptionalityFactory $factory)
    {
        $this->assertInstanceOf(Fortune::class, $factory->getFortune());
    }
}
