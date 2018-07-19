<?php
declare(strict_types = 1);

namespace DrdPlus\Tests\PropertiesByFate;

use DrdPlus\PropertiesByFate\PropertiesByFate;
use Granam\Tests\ExceptionsHierarchy\Exceptions\AbstractExceptionsHierarchyTest;

class PropertiesByFateExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    /**
     * @return string
     */
    protected function getTestedNamespace()
    {
        $reflection = new \ReflectionClass(PropertiesByFate::class);

        return $reflection->getNamespaceName();
    }

    /**
     * @return string
     */
    protected function getRootNamespace()
    {
        return $this->getTestedNamespace();
    }

}