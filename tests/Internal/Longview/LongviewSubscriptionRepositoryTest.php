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
use PHPUnit\Framework\TestCase;

class LongviewSubscriptionRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var LongviewSubscriptionRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new LongviewSubscriptionRepository($client);
    }

    public function testGetBaseUri()
    {
        $expected = '/longview/subscriptions';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'id',
            'label',
            'clients_included',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(LongviewSubscription::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
