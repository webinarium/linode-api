<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Longview;

use Linode\Entity\Longview\LongviewSubscription;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Longview\LongviewSubscriptionRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Longview\LongviewSubscriptionRepository
 */
final class LongviewSubscriptionRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected LongviewSubscriptionRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new LongviewSubscriptionRepository($client);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/longview/subscriptions';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'label',
            'clients_included',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(LongviewSubscription::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
