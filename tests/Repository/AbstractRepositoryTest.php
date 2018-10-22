<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Repository;

use GuzzleHttp\Client;
use Linode\Entity\Entity;
use Linode\Internal\ApiTrait;
use PHPUnit\Framework\TestCase;

class AbstractRepositoryTest extends TestCase
{
    protected function mockRepository(Client $client)
    {
        return new class($client) extends AbstractRepository {
            use ApiTrait;

            public function __construct(Client $client)
            {
                parent::__construct('secret');

                $this->client = $client;
            }

            protected function jsonToEntity(array $json): Entity
            {
                return new class($json) extends Entity {};
            }
        };
    }
}
