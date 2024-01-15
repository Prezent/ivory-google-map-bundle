<?php

declare(strict_types=1);

namespace Ivory\GoogleMapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PublicForTestsCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$this->isPHPUnit()) {
            return;
        }

        foreach ($container->getDefinitions() as $definition) {
            if (strpos($definition, 'Ivory\\') !== false) {
                $definition->setPublic(true);
            }
        }

        foreach ($container->getAliases() as $definition) {
            if (strpos($definition, 'Ivory\\') !== false) {
                $definition->setPublic(true);
            }
        }
    }

    private function isPHPUnit(): bool
    {
        // there constants are defined by PHPUnit
        return defined('PHPUNIT_COMPOSER_INSTALL') || defined('__PHPUNIT_PHAR__');
    }
}
