<?php

declare(strict_types=1);

namespace Krma\KCFinder\Symfony;

use KCFinder\Contract\AuthorizationInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class SecurityAuthorization implements AuthorizationInterface
{
    public function __construct(
        private readonly AuthorizationCheckerInterface $authorization,
        private readonly string $attribute
    ) {
    }

    public function can(string $operation, string $logicalPath): bool
    {
        return $this->authorization->isGranted($this->attribute, array(
            'operation' => $operation,
            'path' => $logicalPath,
        ));
    }
}
