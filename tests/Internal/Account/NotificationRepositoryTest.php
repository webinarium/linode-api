<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Internal\Account;

use Linode\Entity\Account\Notification;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use PHPUnit\Framework\TestCase;

class NotificationRepositoryTest extends TestCase
{
    use ReflectionTrait;

    /** @var NotificationRepository */
    protected $repository;

    protected function setUp()
    {
        $client = new LinodeClient();

        $this->repository = new NotificationRepository($client);
    }

    public function testGetBaseUri()
    {
        $expected = '/account/notifications';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields()
    {
        $expected = [
            'label',
            'message',
            'severity',
            'when',
            'until',
            'type',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity()
    {
        self::assertInstanceOf(Notification::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
