<?php

declare(strict_types=1);

namespace Krma\KCFinder\Symfony\Event;

use KCFinder\Domain\FileDescriptor;

final readonly class FileSelectedEvent
{
    public function __construct(public FileDescriptor $file)
    {
    }
}
