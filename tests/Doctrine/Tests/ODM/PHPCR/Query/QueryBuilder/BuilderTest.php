<?php

namespace Doctrine\Tests\ODM\PHPCR\Query\QueryBuilder;

use Doctrine\ODM\PHPCR\Query\QueryBuilder\Builder;

class BuilderTest extends NodeTestCase
{
    public function provideInterface()
    {
        return array(
            array('where', 'Where'),
            array('from', 'From'),
            array('orderBy', 'OrderBy'),
            array('select', 'Select'),
        );
    }

    // this test serves no other purpose than to demonstrate
    // the API
    public function testApi1()
    {
        $this->node
            ->select()
                ->property('foobar', 'a')
                ->property('barfoo', 'a')
            ->end()
            ->from()
                ->joinInner()
                    ->left()->document('foobar', 'a')->end()
                    ->right()->document('barfoo', 'b')->end()
                    ->condition()->equi('prop_1', 'a', 'prop_2', 'b')->end()
                ->end()
            ->end()
            ->where()
                ->andX()
                    ->eq()
                        ->lop()->propertyValue('foobar', 'a')->end()
                        ->rop()->literal('foo_value')->end()
                    ->end()
                    ->like()
                        ->lop()->documentName('my_doc')->end()
                        ->rop()->bindVariable('my_var')->end()
                    ->end()
                ->end()
            ->end()
            ->orderBy()
                ->ascending()->documentName('a')->end()
                ->descending()->documentName('b')->end()
            ->end();
    }

    public function testFirstMaxResult()
    {
        $this->node->setMaxResults(123);
        $this->node->setFirstResult(4);

        $this->assertEquals(123, $this->node->getMaxResults());
        $this->assertEquals(4, $this->node->getFirstResult());
    }
}
