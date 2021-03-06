<?php

namespace Propel\Generator\Builder\Om\Component\Repository;

use gossi\codegen\model\PhpParameter;
use Mandango\Mondator\Definition\Method;
use Propel\Generator\Builder\ClassDefinition;
use Propel\Generator\Builder\Om\Component\BuildComponent;
use Propel\Generator\Builder\Om\Component\NamingTrait;
use Propel\Tests\Bookstore\BookstoreQuery;

/**
 * Adds the save method.
 *
 * @author Marc J. Schmidt <marc@marcjschmidt.de>
 */
class SaveMethod extends BuildComponent
{
    use NamingTrait;

    public function process()
    {
        $entityClassName = $this->getObjectClassName();

        $body = <<<EOF
\$session = \$this->getConfiguration()->getSession();
\$session->persist(\$entity, true);
\$session->commit();
EOF;

        if ($this->getEntity()->isReadOnly()) {
$body = <<<EOF
throw new BadMethodCallException('Readonly entity cannot be saved');
EOF;
            $this->useClass('Propel\Runtime\Exception\BadMethodCallException');
        }

        $this->addMethod('save')
            ->addSimpleParameter('entity', $entityClassName)
            ->setDescription("Saves a instance of $entityClassName.")
            ->setBody($body);
    }
}