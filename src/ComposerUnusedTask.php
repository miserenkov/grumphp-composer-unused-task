<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 01.04.2023 00:34
 */

namespace MiSerenkov\GrumPHP\ComposerUnusedTask;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Runner\TaskResultInterface;
use GrumPHP\Task\AbstractExternalTask;
use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\Context\GitPreCommitContext;
use GrumPHP\Task\Context\RunContext;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComposerUnusedTask extends AbstractExternalTask
{
    public static function getConfigurableOptions(): OptionsResolver
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'configuration' => null,
            'exclude_dirs' => [],
            'exclude_packages' => [],
            'output_format' => 'default',
        ]);

        $resolver->addAllowedTypes('configuration', ['null', 'string']);
        $resolver->addAllowedTypes('exclude_dirs', ['array']);
        $resolver->addAllowedTypes('exclude_packages', ['array']);
        $resolver->addAllowedValues('output_format', ['default', 'github', 'json', 'junit']);

        return $resolver;
    }

    /**
     * {@inheritdoc}
     */
    public function canRunInContext(ContextInterface $context): bool
    {
        return $context instanceof GitPreCommitContext || $context instanceof RunContext;
    }

    /**
     * {@inheritdoc}
     */
    public function run(ContextInterface $context): TaskResultInterface
    {
        $config = $this->getConfig()->getOptions();

        $arguments = $this->processBuilder->createArgumentsForCommand('composer-unused');

        $arguments->addOptionalArgument('--configuration=%s', $config['configuration']);
        $arguments->addOptionalArgument('--output-format=%s', $config['output_format']);
        $arguments->add('--no-ansi');
        $arguments->add('--no-interaction');
        $arguments->add('--no-progress');

        if (count($config['exclude_dirs'])) {
            $arguments->addArgumentArray('--excludeDir=%s', $config['exclude_dirs']);
        }

        if (count($config['exclude_packages'])) {
            $arguments->addArgumentArray('--excludePackage=%s', $config['exclude_packages']);
        }

        $arguments->add('composer.json');

        $process = $this->processBuilder->buildProcess($arguments);
        $process->run();

        if (!$process->isSuccessful()) {
            return TaskResult::createFailed($this, $context, $this->formatter->format($process));
        }

        return TaskResult::createPassed($this, $context);
    }
}
