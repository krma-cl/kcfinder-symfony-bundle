<?php

declare(strict_types=1);

namespace Krma\KCFinder\Symfony\Tests;

use Krma\KCFinder\Symfony\FlysystemMetadataProvider;
use Krma\KCFinder\Symfony\FlysystemUrlResolver;
use League\Flysystem\FilesystemOperator;
use PHPUnit\Framework\TestCase;

final class FlysystemMetadataProviderTest extends TestCase
{
    public function testItBuildsTheStableSelectorPayload(): void
    {
        $filesystem = $this->createMock(FilesystemOperator::class);
        $filesystem->expects(self::once())->method('fileExists')->with('docs/report.pdf')->willReturn(true);
        $filesystem->expects(self::once())->method('fileSize')->with('docs/report.pdf')->willReturn(184320);
        $filesystem->expects(self::once())->method('mimeType')->with('docs/report.pdf')->willReturn('application/pdf');

        $provider = new FlysystemMetadataProvider($filesystem, new FlysystemUrlResolver('/storage/transparencia'));
        self::assertSame(array(
            'name' => 'report.pdf',
            'path' => '/docs/report.pdf',
            'url' => '/storage/transparencia/docs/report.pdf',
            'mime' => 'application/pdf',
            'size' => 184320,
        ), $provider->metadata('/docs/report.pdf')->toArray());
    }
}
