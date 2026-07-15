<?php

declare(strict_types=1);

namespace Krma\KCFinder\Symfony;

use KCFinder\Contract\UrlResolverInterface;
use KCFinder\Domain\LogicalPath;

final class FlysystemUrlResolver implements UrlResolverInterface
{
    public function __construct(private readonly string $urlPrefix)
    {
    }

    public function resolve(string $logicalPath): string
    {
        $logicalPath = LogicalPath::fromString($logicalPath)->value();
        $segments = array_map('rawurlencode', explode('/', ltrim($logicalPath, '/')));
        return rtrim($this->urlPrefix, '/') . '/' . implode('/', $segments);
    }
}
