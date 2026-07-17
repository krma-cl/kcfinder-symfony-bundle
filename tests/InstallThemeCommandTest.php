<?php

declare(strict_types=1);

namespace Krma\KCFinder\Symfony\Tests;

use Krma\KCFinder\Symfony\Command\InstallThemeCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

final class InstallThemeCommandTest extends TestCase
{
    public function testItExplainsTheOptionalPackageRequirement(): void
    {
        $tester = new CommandTester(new InstallThemeCommand(
            sys_get_temp_dir(),
            'public/kcfinder/themes'
        ));

        self::assertSame(Command::FAILURE, $tester->execute(array()));
        self::assertStringContainsString(
            'krma-cl/kcfinder-bootstrap5-theme',
            $tester->getDisplay()
        );
    }
}
