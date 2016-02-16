<?php
namespace DrdPlus\Exceptionalities;

use DrdPlus\Exceptionalities\Choices\Fortune;
use DrdPlus\Exceptionalities\Choices\PlayerDecision;
use DrdPlus\Exceptionalities\Fates\FateOfCombination;
use DrdPlus\Exceptionalities\Fates\FateOfExceptionalProperties;
use DrdPlus\Exceptionalities\Fates\FateOfGoodRear;
use DrdPlus\Tests\Tools\TestWithMockery;

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

    // CHOICES

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

    /**
     * @test
     * @dataProvider provideChoiceCodeAndExpectedClass
     *
     * @param string $code
     * @param string $expectedChoiceClass
     */
    public function I_can_get_choice_by_code($code, $expectedChoiceClass)
    {
        $exceptionalityFactory = new ExceptionalityFactory();
        $this->assertInstanceOf($expectedChoiceClass, $exceptionalityFactory->getChoice($code));
    }

    public function provideChoiceCodeAndExpectedClass()
    {
        return [
            [PlayerDecision::PLAYER_DECISION, PlayerDecision::class],
            [Fortune::FORTUNE, Fortune::class],
        ];
    }

    /**
     * @test
     * @depends I_can_create_it
     * @expectedException \DrdPlus\Exceptionalities\Exceptions\UnknownExceptionalityChoice
     * @param ExceptionalityFactory $factory
     */
    public function I_can_not_create_choice_from_unknown_code(ExceptionalityFactory $factory)
    {
        $factory->getChoice('Gardener');
    }

    /**
     * @test
     * @depends I_can_create_it
     * @expectedException \DrdPlus\Exceptionalities\Exceptions\UnknownExceptionalityChoice
     * @param ExceptionalityFactory $factory
     */
    public function I_can_not_create_choice_from_true_as_code(ExceptionalityFactory $factory)
    {
        $factory->getChoice(true);
    }

    // FATES

    /**
     * @depends I_can_create_it
     * @test
     *
     * @param ExceptionalityFactory $factory
     */
    public function I_can_get_good_rear(ExceptionalityFactory $factory)
    {
        $this->assertInstanceOf(FateOfGoodRear::class, $factory->getFateOfGoodRear());
    }

    /**
     * @depends I_can_create_it
     * @test
     *
     * @param ExceptionalityFactory $factory
     */
    public function I_can_get_combination(ExceptionalityFactory $factory)
    {
        $this->assertInstanceOf(FateOfCombination::class, $factory->getFateOfCombination());
    }

    /**
     * @depends I_can_create_it
     * @test
     *
     * @param ExceptionalityFactory $factory
     */
    public function I_can_get_exceptional_properties(ExceptionalityFactory $factory)
    {
        $this->assertInstanceOf(FateOfExceptionalProperties::class, $factory->getFateOfExceptionalProperties());
    }

    /**
     * @test
     * @dataProvider provideFateCodeAndExpectedClass
     *
     * @param string $fateCode
     * @param string $expectedFateClass
     */
    public function I_can_get_fate_by_code($fateCode, $expectedFateClass)
    {
        $factory = new ExceptionalityFactory();
        $this->assertInstanceOf($expectedFateClass, $factory->getFate($fateCode));
    }

    public function provideFateCodeAndExpectedClass()
    {
        return [
            [FateOfGoodRear::FATE_OF_GOOD_REAR, FateOfGoodRear::class],
            [FateOfCombination::FATE_OF_COMBINATION, FateOfCombination::class],
            [FateOfExceptionalProperties::FATE_OF_EXCEPTIONAL_PROPERTIES, FateOfExceptionalProperties::class],
        ];
    }

    /**
     * @test
     * @depends I_can_create_it
     * @expectedException \DrdPlus\Exceptionalities\Exceptions\UnknownExceptionalityFate
     * @param ExceptionalityFactory $factory
     */
    public function I_can_not_create_fate_from_unknown_code(ExceptionalityFactory $factory)
    {
        $factory->getFate('Conquer of the words');
    }

    /**
     * @test
     * @depends I_can_create_it
     * @expectedException \DrdPlus\Exceptionalities\Exceptions\UnknownExceptionalityFate
     * @param ExceptionalityFactory $factory
     */
    public function I_can_not_create_fate_from_true_as_code(ExceptionalityFactory $factory)
    {
        $factory->getFate(true);
    }
}
