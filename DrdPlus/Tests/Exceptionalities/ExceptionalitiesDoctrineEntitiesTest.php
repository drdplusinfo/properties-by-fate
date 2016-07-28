<?php
namespace DrdPlus\Tests\Exceptionalities;

use Doctrineum\Tests\Entity\AbstractDoctrineEntitiesTest;
use DrdPlus\Exceptionalities\Choices\PlayerDecision;
use DrdPlus\Exceptionalities\EnumTypes\ExceptionalitiesEnumRegistrar;
use DrdPlus\Exceptionalities\Exceptionality;
use DrdPlus\Exceptionalities\Fates\FateOfCombination;
use DrdPlus\Exceptionalities\Fates\FateOfExceptionalProperties;
use DrdPlus\Exceptionalities\Fates\FateOfGoodRear;
use DrdPlus\Exceptionalities\Properties\ChosenProperties;
use DrdPlus\Exceptionalities\Properties\ExceptionalityPropertiesFactory;
use DrdPlus\Exceptionalities\Properties\FortuneProperties;
use DrdPlus\Person\ProfessionLevels\ProfessionFirstLevel;
use DrdPlus\Professions\Fighter;
use DrdPlus\Professions\Thief;
use DrdPlus\Professions\Wizard;
use DrdPlus\Properties\Base\BasePropertiesFactory;

class ExceptionalitiesDoctrineEntitiesTest extends AbstractDoctrineEntitiesTest
{
    protected function setUp()
    {
        ExceptionalitiesEnumRegistrar::registerAll();
        parent::setUp();
    }

    protected function getDirsWithEntities()
    {
        $exceptionalityReflection = new \ReflectionClass(Exceptionality::class);

        return [
            dirname($exceptionalityReflection->getFileName())
        ];
    }

    protected function getExpectedEntityClasses()
    {
        return [
            Exceptionality::class,
            ChosenProperties::class,
            FortuneProperties::class
        ];
    }

    protected function createEntitiesToPersist()
    {
        return self::createEntities();
    }

    public static function createEntities()
    {
        $factory = new ExceptionalityPropertiesFactory();

        return [
            new Exceptionality(
                PlayerDecision::getIt(),
                $fate = FateOfGoodRear::getIt(),
                $factory->createChosenProperties(
                    $fate,
                    ProfessionFirstLevel::createFirstLevel(Fighter::getIt()),
                    0,
                    1,
                    1,
                    0,
                    0,
                    1
                )
            ),
            $factory->createChosenProperties(
                FateOfCombination::getIt(),
                ProfessionFirstLevel::createFirstLevel(Wizard::getIt()),
                1,
                1,
                1,
                1,
                1,
                1
            ),
            $factory->createFortuneProperties(
                FateOfExceptionalProperties::getIt(),
                ProfessionFirstLevel::createFirstLevel(Thief::getIt()),
                1,
                3,
                6,
                5,
                4,
                2,
                new BasePropertiesFactory()
            )
        ];
    }

}