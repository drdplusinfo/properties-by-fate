<?php
namespace DrdPlus\Tests\PropertiesByFate;

use DrdPlus\Codes\FateCode;
use DrdPlus\Codes\PropertyCode;
use DrdPlus\PropertiesByFate\ExceptionalityProperties;
use DrdPlus\Professions\Profession;
use Granam\Tests\Tools\TestWithMockery;

abstract class ExceptionalityPropertiesTest extends TestWithMockery
{

    /**
     * @param array $primaryPropertyCodes
     * @return Profession|\Mockery\MockInterface
     */
    protected function createProfession(array $primaryPropertyCodes)
    {
        $profession = $this->mockery(Profession::class);
        $profession->shouldReceive('isPrimaryProperty')
            ->with($this->type(PropertyCode::class))
            ->andReturnUsing(function (PropertyCode $propertyCode) use ($primaryPropertyCodes) {
                return in_array($propertyCode->getValue(), $primaryPropertyCodes, true);
            });
        $profession->shouldReceive('getValue')
            ->andReturn('foo');

        return $profession;
    }

    /**
     * @param ExceptionalityProperties $exceptionalityProperties
     */
    abstract protected function I_get_null_as_id_before_persist(ExceptionalityProperties $exceptionalityProperties);

    abstract protected function I_get_expected_choice_code(ExceptionalityProperties $exceptionalityProperties);

    abstract protected function I_get_fate_code_created_with(
        ExceptionalityProperties $exceptionalityProperties,
        FateCode $expectedFateCode
    );

}