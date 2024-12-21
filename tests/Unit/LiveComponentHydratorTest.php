<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\LiveComponent\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\UX\LiveComponent\LiveComponentHydrator;
use Symfony\UX\LiveComponent\Metadata\LiveComponentMetadataFactory;

final class LiveComponentHydratorTest extends TestCase
{
    public function testConstructWithEmptySecret(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('A non-empty secret is required.');

        new LiveComponentHydrator(
            [],
            $this->createMock(PropertyAccessorInterface::class),
            $this->createMock(LiveComponentMetadataFactory::class),
            $this->createMock(NormalizerInterface::class),
            '',
        );
    }
}
