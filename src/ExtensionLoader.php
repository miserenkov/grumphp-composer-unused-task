<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 01.04.2023 00:33
 */

namespace MiSerenkov\GrumPHP\ComposerUnusedTask;

use GrumPHP\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ExtensionLoader implements ExtensionInterface
{
    public function load(ContainerBuilder $container): void
    {
        $container->register('task.composer_unused', ComposerUnusedTask::class)
            ->addArgument(new Reference('process_builder'))
            ->addArgument(new Reference('formatter.raw_process'))
            ->addTag('grumphp.task', ['task' => 'composer_unused']);
    }
}
