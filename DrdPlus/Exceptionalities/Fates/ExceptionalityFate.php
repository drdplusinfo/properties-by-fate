<?php
namespace DrdPlus\Exceptionalities\Fates;

use Doctrineum\Scalar\ScalarEnum;
use DrdPlus\Exceptionalities\Templates\Integer1To6;
use Granam\String\StringTools;
use Granam\Tools\ValueDescriber;

abstract class ExceptionalityFate extends ScalarEnum
{
    /**
     * @param string $code
     * @return ExceptionalityFate
     * @throws \DrdPlus\Exceptionalities\Fates\Exceptions\ClassNotFoundByCode
     */
    public static function getItByCode($code)
    {
        $exceptionalityFateClass = self::determineClassByCode($code);

        return $exceptionalityFateClass::getIt();
    }

    /**
     * @param string $code
     * @return string|ExceptionalityFate
     * @throws \DrdPlus\Exceptionalities\Fates\Exceptions\ClassNotFoundByCode
     */
    protected static function determineClassByCode($code)
    {
        $class = __NAMESPACE__ . '\\' . implode(
                array_map(
                    function ($part) {
                        return ucfirst($part);
                    },
                    preg_split('~_~', $code, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE)
                )
            );
        if (!class_exists($class)) {
            throw new Exceptions\ClassNotFoundByCode(
                'Did not found a class by code ' . ValueDescriber::describe($code)
                . ', were searching for ' . $class
            );
        }

        return $class;
    }

    /**
     * @return ExceptionalityFate
     */
    protected static function getIt()
    {
        return static::getEnum(static::getCode());
    }

    protected static function getCode()
    {
        return StringTools::camelToSnakeCaseBasename(static::class);
    }

    /**
     * @return int
     */
    abstract public function getPrimaryPropertiesBonusOnChoice();

    /**
     * @return int
     */
    abstract public function getSecondaryPropertiesBonusOnChoice();

    /**
     * @param Integer1To6 $roll
     *
     * @return int
     */
    abstract public function getPrimaryPropertyBonusOnFortune(Integer1To6 $roll);

    /**
     * @param Integer1To6 $roll
     *
     * @return int
     */
    abstract public function getSecondaryPropertyBonusOnFortune(Integer1To6 $roll);

    /**
     * @return int
     */
    abstract public function getUpToSingleProperty();

}
