<?php
namespace DrdPlus\Tests\Exceptionalities\Properties;

use DrdPlus\Exceptionalities\Exceptionality;
use DrdPlus\Exceptionalities\Properties\ExceptionalityProperties;
use Granam\Tests\Exceptions\Tools\AbstractExceptionsHierarchyTest;

class PropertyExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    protected function getTestedNamespace()
    {
        $reflection = new \ReflectionClass(ExceptionalityProperties::class);

        return $reflection->getNamespaceName();
    }

    protected function getRootNamespace()
    {
        $reflection = new \ReflectionClass(Exceptionality::class);

        return $reflection->getNamespaceName();
    }

}
