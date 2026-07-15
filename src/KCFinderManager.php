<?php

declare(strict_types=1);

namespace Krma\KCFinder\Symfony;

use KCFinder\Application\FileSelectionService;
use KCFinder\Domain\FileDescriptor;
use Krma\KCFinder\Symfony\Event\FileSelectedEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class KCFinderManager
{
    public function __construct(
        private readonly FileSelectionService $selector,
        private readonly EventDispatcherInterface $events
    ) {
    }

    public function select(string $logicalPath): FileDescriptor
    {
        $file = $this->selector->select($logicalPath);
        $this->events->dispatch(new FileSelectedEvent($file));
        return $file;
    }
}
