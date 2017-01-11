<?php
namespace DrdPlus\Tests\PropertiesByFate;

use Doctrineum\Tests\Entity\AbstractDoctrineEntitiesTest;
use Drd\DiceRoll\Templates\Rolls\Roll1d6;
use DrdPlus\Codes\FateCode;
use DrdPlus\PropertiesByFate\ChosenProperties;
use DrdPlus\PropertiesByFate\EnumTypes\ExceptionalitiesEnumRegistrar;
use DrdPlus\PropertiesByFate\ExceptionalityProperties;
use DrdPlus\PropertiesByFate\FortuneProperties;
use DrdPlus\Professions\Fighter;
use DrdPlus\Professions\Thief;
use DrdPlus\Professions\Wizard;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\BasePropertiesFactory;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use DrdPlus\Tables\History\InfluenceOfFortuneTable;
use DrdPlus\Tables\History\PlayerDecisionsTable;

class PropertiesByFateDoctrineEntitiesTest extends AbstractDoctrineEntitiesTest
{
    protected function setUp()
    {
        ExceptionalitiesEnumRegistrar::registerAll();
        parent::setUp();
    }

    protected function getDirsWithEntities()
    {
        $exceptionalityReflection = new \ReflectionClass(ExceptionalityProperties::class);

        return [
            dirname($exceptionalityReflection->getFileName()),
        ];
    }

    protected function getExpectedEntityClasses()
    {
        return [
            ChosenProperties::class,
            FortuneProperties::class,
        ];
    }

    protected function createEntitiesToPersist()
    {
        return self::createEntities();
    }

    public static function createEntities()
    {
        return [
            new ChosenProperties(
                Strength::getIt(1),
                Agility::getIt(1),
                Knack::getIt(1),
                Will::getIt(0),
                Intelligence::getIt(2),
                Charisma::getIt(1),
                FateCode::getIt(FateCode::COMBINATION_OF_PROPERTIES_AND_BACKGROUND),
                Fighter::getIt(),
                new PlayerDecisionsTable()
            ),
            new ChosenProperties(
                Strength::getIt(1),
                Agility::getIt(1),
                Knack::getIt(1),
                Will::getIt(2),
                Intelligence::getIt(1),
                Charisma::getIt(3),
                FateCode::getIt(FateCode::EXCEPTIONAL_PROPERTIES),
                Wizard::getIt(),
                new PlayerDecisionsTable()
            ),
            new FortuneProperties(
                self::createRoll1d6(1),
                self::createRoll1d6(3),
                self::createRoll1d6(6),
                self::createRoll1d6(5),
                self::createRoll1d6(4),
                self::createRoll1d6(2),
                FateCode::getIt(FateCode::EXCEPTIONAL_PROPERTIES),
                Thief::getIt(),
                new InfluenceOfFortuneTable(),
                new BasePropertiesFactory()
            ),
        ];
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|Roll1d6
     */
    private static function createRoll1d6($value)
    {
        $roll = \Mockery::mock(Roll1d6::class);
        $roll->shouldReceive('getValue')
            ->andReturn($value);
        $roll->shouldReceive('__toString')
            ->andReturn((string)$value);

        return $roll;
    }

}