<?php

declare(strict_types=1);

namespace Krma\KCFinder\Symfony\Tests;

use Krma\KCFinder\Symfony\SecurityAuthorization;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class SecurityAuthorizationTest extends TestCase
{
    public function testItPassesOperationAndPathToSymfonySecurity(): void
    {
        $checker = $this->createMock(AuthorizationCheckerInterface::class);
        $checker->expects(self::once())
            ->method('isGranted')
            ->with('KCFINDER_SELECT', array('operation' => 'select', 'path' => '/docs/report.pdf'))
            ->willReturn(true);

        self::assertTrue((new SecurityAuthorization($checker, 'KCFINDER_SELECT'))->can('select', '/docs/report.pdf'));
    }
}
