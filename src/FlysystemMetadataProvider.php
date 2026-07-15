<?php

declare(strict_types=1);

namespace Krma\KCFinder\Symfony;

use KCFinder\Contract\FileMetadataProviderInterface;
use KCFinder\Contract\UrlResolverInterface;
use KCFinder\Domain\FileDescriptor;
use KCFinder\Domain\LogicalPath;
use League\Flysystem\FilesystemOperator;
use RuntimeException;

final class FlysystemMetadataProvider implements FileMetadataProviderInterface
{
    public function __construct(
        private readonly FilesystemOperator $filesystem,
        private readonly UrlResolverInterface $urlResolver
    ) {
    }

    public function metadata(string $logicalPath): FileDescriptor
    {
        $logicalPath = LogicalPath::fromString($logicalPath)->value();
        $storagePath = ltrim($logicalPath, '/');
        if (!$this->filesystem->fileExists($storagePath)) {
            throw new RuntimeException('The requested file does not exist.');
        }

        $mime = $this->filesystem->mimeType($storagePath) ?: 'application/octet-stream';
        return new FileDescriptor(
            basename($logicalPath),
            $logicalPath,
            $this->urlResolver->resolve($logicalPath),
            strtolower($mime),
            $this->filesystem->fileSize($storagePath)
        );
    }
}
