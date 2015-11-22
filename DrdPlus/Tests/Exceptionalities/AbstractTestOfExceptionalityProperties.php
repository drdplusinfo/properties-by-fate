<?php
namespace DrdPlus\Cave\UnitBundle\Tests\Person\Attributes\Exceptionalities;

use DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\Exceptionality;
use DrdPlus\Cave\UnitBundle\Person\Attributes\Exceptionalities\ExceptionalityProperties;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use DrdPlus\Cave\UnitBundle\Tests\TestWithMockery;

abstract class AbstractTestOfExceptionalityProperties extends TestWithMockery
{
    /**
     * @return ExceptionalityProperties
     *
     * @test
     */
    public function can_be_created()
    {
        $className = $this->getClassName();
        $instance = new $className(
            $this->getStrength(),
            $this->getAgility(),
            $this->getKnack(),
            $this->getWill(),
            $this->getIntelligence(),
            $this->getCharisma()
        );

        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @return string
     */
    protected function getClassName()
    {
        $testClassName = static::class;

        return preg_replace('~Test(s[\\\])?~', '', $testClassName);
    }

    /**
     * @return \Mockery\MockInterface|Strength
     */
    protected function getStrength()
    {
        return $this->mockery(Strength::class);
    }

    /**
     * @return \Mockery\MockInterface|Agility
     */
    protected function getAgility()
    {
        return $this->mockery(Agility::class);
    }

    /**
     * @return \Mockery\MockInterface|Knack
     */
    protected function getKnack()
    {
        return $this->mockery(Knack::class);
    }

    /**
     * @return \Mockery\MockInterface|Will
     */
    protected function getWill()
    {
        return $this->mockery(Will::class);
    }

    /**
     * @return \Mockery\MockInterface|Intelligence
     */
    protected function getIntelligence()
    {
        return $this->mockery(Intelligence::class);
    }

    /**
     * @return \Mockery\MockInterface|Charisma
     */
    protected function getCharisma()
    {
        return $this->mockery(Charisma::class);
    }

    /**
     * @param ExceptionalityProperties $exceptionalityProperties
     *
     * @test
     * @depends can_be_created
     */
    public function new_instance_has_null_id(ExceptionalityProperties $exceptionalityProperties)
    {
        $this->assertNull($exceptionalityProperties->getId());
    }

    /**
     * @test
     * @depends can_be_created
     */
    public function gives_the_same_strength_as_got()
    {
        $className = $this->getClassName();
        /** @var ExceptionalityProperties $exceptionalityProperties */
        $exceptionalityProperties = new $className(
            $strength = $this->getStrength(),
            $agility = $this->getAgility(),
            $knack = $this->getKnack(),
            $will = $this->getWill(),
            $intelligence = $this->getIntelligence(),
            $charisma = $this->getCharisma()
        );
        $this->assertSame($strength, $exceptionalityProperties->getStrength());
        $this->assertSame($agility, $exceptionalityProperties->getAgility());
        $this->assertSame($knack, $exceptionalityProperties->getKnack());
        $this->assertSame($will, $exceptionalityProperties->getWill());
        $this->assertSame($intelligence, $exceptionalityProperties->getIntelligence());
        $this->assertSame($charisma, $exceptionalityProperties->getCharisma());
    }

    /**
     * @param ExceptionalityProperties $exceptionalityProperties
     * @return ExceptionalityProperties
     *
     * @test
     * @depends can_be_created
     */
    public function new_instance_has_null_exceptionality(ExceptionalityProperties $exceptionalityProperties)
    {
        $this->assertNull($exceptionalityProperties->getExceptionality());

        return $exceptionalityProperties;
    }

    /**
     * @param ExceptionalityProperties $exceptionalityProperties
     *
     * @test
     * @depends new_instance_has_null_exceptionality
     */
    public function exceptionality_can_be_set(ExceptionalityProperties $exceptionalityProperties)
    {
        $exceptionality = $this->mockery(Exceptionality::class);
        $exceptionality->shouldReceive('getExceptionalityProperties')
            ->andReturn($exceptionalityProperties);
        /** @var Exceptionality $exceptionality */
        $exceptionalityProperties->setExceptionality($exceptionality);
        $this->assertSame($exceptionality, $exceptionalityProperties->getExceptionality());
    }

    /**
     * @test
     * @depends exceptionality_can_be_set
     * @expectedException \LogicException
     */
    public function adding_another_new_exceptionality_with_different_properties_cause_exception()
    {
        $className = $this->getClassName();
        /** @var ExceptionalityProperties $exceptionalityProperties */
        $exceptionalityProperties = new $className(
            $strength = $this->getStrength(),
            $agility = $this->getAgility(),
            $knack = $this->getKnack(),
            $will = $this->getWill(),
            $intelligence = $this->getIntelligence(),
            $charisma = $this->getCharisma()
        );

        $exceptionality = $this->mockery(Exceptionality::class);
        $exceptionality->shouldReceive('getExceptionalityProperties')
            ->andReturn($exceptionalityProperties);
        $exceptionality->shouldReceive('getId')
            ->andReturnNull();
        /** @var Exceptionality $exceptionality */
        $exceptionalityProperties->setExceptionality($exceptionality);
        try {
            $exceptionalityProperties->setExceptionality($exceptionality); // setting the same exceptionality should pass
        } catch (\Exception $unwantedException) {
            $this->fail(
                'No exception should occurs on set of the same exceptionality: ' . $unwantedException->getMessage() . '; ' . $unwantedException->getTraceAsString()
            );
        }

        $anotherExceptionality = $this->mockery(Exceptionality::class);
        $anotherExceptionality->shouldReceive('getExceptionalityProperties')
            ->andReturn($anotherExceptionalityProperties = $this->mockery(ExceptionalityProperties::class));
        $anotherExceptionalityProperties->shouldReceive('getId')
            ->andReturnNull();

        /** @var Exceptionality $anotherExceptionality */
        $exceptionalityProperties->setExceptionality($anotherExceptionality);
    }

    /**
     * @test
     * @depends adding_another_new_exceptionality_with_different_properties_cause_exception
     * @expectedException \LogicException
     */
    public function adding_another_exceptionality_with_different_properties_cause_exception()
    {
        $className = $this->getClassName();
        /** @var ExceptionalityProperties $exceptionalityProperties */
        $exceptionalityProperties = new $className(
            $strength = $this->getStrength(),
            $agility = $this->getAgility(),
            $knack = $this->getKnack(),
            $will = $this->getWill(),
            $intelligence = $this->getIntelligence(),
            $charisma = $this->getCharisma()
        );

        $exceptionality = $this->mockery(Exceptionality::class);
        $exceptionality->shouldReceive('getExceptionalityProperties')
            ->andReturn($exceptionalityProperties);
        $exceptionality->shouldReceive('getId')
            ->andReturnNull();
        /** @var Exceptionality $exceptionality */
        $exceptionalityProperties->setExceptionality($exceptionality);
        try {
            $exceptionalityProperties->setExceptionality($exceptionality); // setting the same exceptionality should pass
        } catch (\Exception $unwantedException) {
            $this->fail(
                'No exception should occurs on set of the same exceptionality: ' . $unwantedException->getMessage() . '; ' . $unwantedException->getTraceAsString()
            );
        }

        $exceptionalityPropertiesReflection = new \ReflectionClass($exceptionalityProperties);
        $idReflection = $exceptionalityPropertiesReflection->getProperty('id');
        $idReflection->setAccessible(true);
        $idReflection->setValue($exceptionalityProperties, 'foo'); // filling an ID

        $anotherExceptionality = $this->mockery(Exceptionality::class);
        $anotherExceptionality->shouldReceive('getExceptionalityProperties')
            ->andReturn($anotherExceptionalityProperties = $this->mockery(ExceptionalityProperties::class));
        $anotherExceptionalityProperties->shouldReceive('getId')
            ->andReturn('bar'); // filling an ID

        /** @var Exceptionality $anotherExceptionality */
        $exceptionalityProperties->setExceptionality($anotherExceptionality);
    }

    /**
     * @test
     * @depends adding_another_new_exceptionality_with_different_properties_cause_exception
     * @expectedException \LogicException
     */
    public function adding_different_exceptionality_cause_exception()
    {
        $className = $this->getClassName();
        /** @var ExceptionalityProperties $exceptionalityProperties */
        $exceptionalityProperties = new $className(
            $strength = $this->getStrength(),
            $agility = $this->getAgility(),
            $knack = $this->getKnack(),
            $will = $this->getWill(),
            $intelligence = $this->getIntelligence(),
            $charisma = $this->getCharisma()
        );

        $exceptionality = $this->mockery(Exceptionality::class);
        $exceptionality->shouldReceive('getExceptionalityProperties')
            ->andReturn($exceptionalityProperties);
        $exceptionality->shouldReceive('getId')
            ->andReturn('foo');
        /** @var Exceptionality $exceptionality */
        $exceptionalityProperties->setExceptionality($exceptionality);
        try {
            $exceptionalityProperties->setExceptionality($exceptionality); // setting the same exceptionality should pass
        } catch (\Exception $unwantedException) {
            $this->fail(
                'No exception should occurs on set of the same exceptionality: ' . $unwantedException->getMessage() . '; ' . $unwantedException->getTraceAsString()
            );
        }

        $exceptionalityPropertiesReflection = new \ReflectionClass($exceptionalityProperties);
        $idReflection = $exceptionalityPropertiesReflection->getProperty('id');
        $idReflection->setAccessible(true);
        $idReflection->setValue($exceptionalityProperties, 'foo'); // filling an ID

        $anotherExceptionality = $this->mockery(Exceptionality::class);
        $anotherExceptionality->shouldReceive('getExceptionalityProperties')
            ->andReturn($exceptionalityProperties);
        $anotherExceptionality->shouldReceive('getId')
            ->andReturn('bar');

        /** @var Exceptionality $anotherExceptionality */
        $exceptionalityProperties->setExceptionality($anotherExceptionality);
    }
}
