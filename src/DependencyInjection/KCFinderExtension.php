<?php

declare(strict_types=1);

namespace Krma\KCFinder\Symfony\DependencyInjection;

use KCFinder\Application\FileSelectionService;
use KCFinder\Contract\AuthorizationInterface;
use KCFinder\Contract\FileMetadataProviderInterface;
use KCFinder\Contract\UrlResolverInterface;
use Krma\KCFinder\Symfony\FlysystemMetadataProvider;
use Krma\KCFinder\Symfony\FlysystemUrlResolver;
use Krma\KCFinder\Symfony\KCFinderManager;
use Krma\KCFinder\Symfony\SecurityAuthorization;
use Krma\KCFinder\Symfony\Command\InstallThemeCommand;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

final class KCFinderExtension extends Extension
{
    /** @param array<array<string, mixed>> $configs */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $container->setParameter('kcfinder.browser_url', $config['browser_url']);
        $container->setDefinition(UrlResolverInterface::class, new Definition(
            FlysystemUrlResolver::class,
            array($config['url_prefix'])
        ));
        $container->setDefinition(FileMetadataProviderInterface::class, new Definition(
            FlysystemMetadataProvider::class,
            array(new Reference($config['filesystem_service']), new Reference(UrlResolverInterface::class))
        ));
        $container->setDefinition(AuthorizationInterface::class, new Definition(
            SecurityAuthorization::class,
            array(new Reference('security.authorization_checker'), $config['security_attribute'])
        ));
        $container->setDefinition(FileSelectionService::class, new Definition(
            FileSelectionService::class,
            array(new Reference(FileMetadataProviderInterface::class), new Reference(AuthorizationInterface::class))
        ));
        $container->setDefinition(KCFinderManager::class, (new Definition(
            KCFinderManager::class,
            array(new Reference(FileSelectionService::class), new Reference('event_dispatcher'))
        ))->setPublic(true));
        $container->setDefinition(InstallThemeCommand::class, (new Definition(
            InstallThemeCommand::class,
            array('%kernel.project_dir%', $config['theme_directory'])
        ))->addTag('console.command'));
    }
}
