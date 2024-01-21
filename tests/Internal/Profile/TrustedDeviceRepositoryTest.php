<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Profile;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Profile\TrustedDevice;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Profile\TrustedDeviceRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Profile\TrustedDeviceRepository
 */
final class TrustedDeviceRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected TrustedDeviceRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new TrustedDeviceRepository($client);
    }

    public function testRevoke(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/profile/devices/123', [], new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->revoke(123);

        self::assertTrue(true);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/profile/devices';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'created',
            'expiry',
            'user_agent',
            'last_authenticated',
            'last_remote_addr',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(TrustedDevice::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): TrustedDeviceRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new TrustedDeviceRepository($linodeClient);
    }
}
