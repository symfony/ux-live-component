<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\LiveComponent\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\UX\LiveComponent\LiveComponentHydrator;
use Symfony\UX\LiveComponent\Metadata\LiveComponentMetadataFactory;
use Symfony\UX\TwigComponent\ComponentFactory;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @experimental
 *
 * @internal
 */
final class LiveComponentRuntime
{
    public function __construct(
        private LiveComponentHydrator $hydrator,
        private ComponentFactory $factory,
        private UrlGeneratorInterface $urlGenerator,
        private LiveComponentMetadataFactory $metadataFactory,
    ) {
    }

    public function getComponentUrl(string $name, array $props = []): string
    {
        $mounted = $this->factory->create($name, $props);
        $props = $this->hydrator->dehydrate(
            $mounted->getComponent(),
            $mounted->getAttributes(),
            $this->metadataFactory->getMetadata($mounted->getName())
        );
        $params = ['_live_component' => $name] + ['props' => json_encode($props->getProps())];

        $metadata = $this->factory->metadataFor($mounted->getName());

        return $this->urlGenerator->generate($metadata->get('route'), $params, $metadata->get('url_reference_type'));
    }
}
