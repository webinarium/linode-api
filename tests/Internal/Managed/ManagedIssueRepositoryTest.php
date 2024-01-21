<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Internal\Managed;

use Linode\Entity\Managed\ManagedIssue;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Managed\ManagedIssueRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Managed\ManagedIssueRepository
 */
final class ManagedIssueRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected ManagedIssueRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new ManagedIssueRepository($client);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/managed/issues';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(ManagedIssue::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }
}
