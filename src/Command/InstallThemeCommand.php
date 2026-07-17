<?php

declare(strict_types=1);

namespace Krma\KCFinder\Symfony\Command;

use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'kcfinder:install-theme',
    description: 'Publish the installed KCFinder Bootstrap 5 theme without modifying vendor packages'
)]
final class InstallThemeCommand extends Command
{
    public function __construct(
        private readonly string $projectDirectory,
        private readonly string $themeDirectory
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('force', null, InputOption::VALUE_NONE, 'Replace an existing Bootstrap 5 theme');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $publisherClass = 'Krma\\KCFinder\\Bootstrap5Theme\\ThemePublisher';
        if (!class_exists($publisherClass)) {
            $io->error('Install krma-cl/kcfinder-bootstrap5-theme before running this command.');
            return self::FAILURE;
        }

        $target = $this->absoluteTarget();
        try {
            $publisher = new $publisherClass();
            $publish = array($publisher, 'publish');
            if (!is_callable($publish)) {
                throw new RuntimeException('The installed theme package has no compatible publisher.');
            }
            $result = $publish($target, (bool) $input->getOption('force'));
            if (!is_array($result) || !isset($result['version'], $result['path'])) {
                throw new RuntimeException('The theme publisher returned an invalid result.');
            }
        } catch (\Throwable $exception) {
            $io->error($exception->getMessage());
            return self::FAILURE;
        }

        $io->success(sprintf(
            'KCFinder Bootstrap 5 theme %s published to %s.',
            $result['version'],
            $result['path']
        ));
        return self::SUCCESS;
    }

    private function absoluteTarget(): string
    {
        if (preg_match('#^(?:[A-Za-z]:[\\\\/]|/)#', $this->themeDirectory) === 1) {
            return $this->themeDirectory;
        }
        return rtrim($this->projectDirectory, "/\\") . DIRECTORY_SEPARATOR
            . str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $this->themeDirectory);
    }
}
