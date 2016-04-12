<?php
namespace DrdPlus\Tests\Exceptionalities\Fates;

use DrdPlus\Exceptionalities\Exceptionality;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use Granam\Tests\Exceptions\Tools\AbstractExceptionsHierarchyTest;

class ExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    protected function getTestedNamespace()
    {
        $reflection = new \ReflectionClass(ExceptionalityFate::class);

        return $reflection->getNamespaceName();
    }

    protected function getRootNamespace()
    {
        $reflection = new \ReflectionClass(Exceptionality::class);

        return $reflection->getNamespaceName();
    }

}
