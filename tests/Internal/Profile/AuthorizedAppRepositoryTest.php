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
use Linode\Entity\Profile\AuthorizedApp;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Profile\AuthorizedAppRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Profile\AuthorizedAppRepository
 */
final class AuthorizedAppRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected AuthorizedAppRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new AuthorizedAppRepository($client);
    }

    public function testRevoke(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['DELETE', 'https://api.linode.com/v4/profile/apps/123', [], new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->revoke(123);

        self::assertTrue(true);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/profile/apps';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'label',
            'scopes',
            'website',
            'created',
            'expiry',
            'thumbnail_url',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(AuthorizedApp::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): AuthorizedAppRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new AuthorizedAppRepository($linodeClient);
    }
}
