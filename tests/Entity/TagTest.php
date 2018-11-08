<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity;

use Linode\Internal\Tags\TaggedObjectRepository;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties()
    {
        $entity = new Tag($this->client, ['label' => 'example tag']);

        self::assertInstanceOf(TaggedObjectRepository::class, $entity->objects);
    }
}
