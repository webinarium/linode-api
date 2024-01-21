<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Account;

use Linode\Entity\Account\Notification;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Account\NotificationRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Account\NotificationRepository
 */
final class NotificationRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected NotificationRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new NotificationRepository($client);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/account/notifications';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
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

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(Notification::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
