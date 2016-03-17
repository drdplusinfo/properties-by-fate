<?php
namespace DrdPlus\Tests\Exceptionalities\Templates;

use DrdPlus\Exceptionalities\Exceptionality;
use DrdPlus\Exceptionalities\Templates\Integer1To6;
use Granam\Tests\Exceptions\Tools\AbstractExceptionsHierarchyTest;

class TemplateExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
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
