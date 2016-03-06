<?php
namespace DrdPlus\Tests\Exceptionalities\Templates;

use DrdPlus\Exceptionalities\Exceptionality;
use DrdPlus\Exceptionalities\Templates\Integer1To6;
use Granam\Exceptions\Tests\Tools\AbstractTestOfExceptionsHierarchy;

class ExceptionsHierarchyTest extends AbstractTestOfExceptionsHierarchy
{
    protected function getTestedNamespace()
    {
        $reflection = new \ReflectionClass(Integer1To6::class);

        return $reflection->getNamespaceName();
    }

    protected function getRootNamespace()
    {
        $reflection = new \ReflectionClass(Exceptionality::class);

        return $reflection->getNamespaceName();
    }

}