<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Profile;

use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity\Profile\ProfileInformation
 */
final class ProfileInformationTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $data = [
            'uid'                  => 1234,
            'username'             => 'exampleUser',
            'email'                => 'example-user@gmail.com',
            'timezone'             => 'US/Eastern',
            'email_notifications'  => true,
            'referrals'            => [
                'code'      => '871be32f49c1411b14f29f618aaf0c14637fb8d3',
                'url'       => 'https://www.linode.com/?r=871be32f49c1411b14f29f618aaf0c14637fb8d3',
                'total'     => 0,
                'completed' => 0,
                'pending'   => 0,
                'credit'    => 0,
            ],
            'ip_whitelist_enabled' => false,
            'lish_auth_method'     => 'keys_only',
            'authorized_keys'      => null,
            'two_factor_auth'      => true,
            'restricted'           => false,
        ];

        $entity = new ProfileInformation($this->client, $data);

        self::assertInstanceOf(ProfileReferrals::class, $entity->referrals);
        self::assertSame('871be32f49c1411b14f29f618aaf0c14637fb8d3', $entity->referrals->code);
        self::assertSame('US/Eastern', $entity->timezone);
    }
}
