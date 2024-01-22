<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Account;

use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Entity\Account\AccountInformation
 */
final class AccountInformationTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties(): void
    {
        $data = [
            'active_promotions' => [
                [
                    'credit_monthly_cap'          => '10.00',
                    'credit_remaining'            => '50.00',
                    'description'                 => 'Receive up to $10 off your services every month for 6 months! Unused credits will expire once this promotion period ends.',
                    'expire_dt'                   => '2018-01-31T23:59:59',
                    'image_url'                   => 'https://linode.com/10_a_month_promotion.svg',
                    'summary'                     => '$10 off your Linode a month!',
                    'this_month_credit_remaining' => '10.00',
                ],
            ],
            'active_since'       => '2018-01-01T00:01:01',
            'address_1'          => '123 Main Street',
            'address_2'          => 'Suite A',
            'balance'            => 200,
            'balance_uninvoiced' => 145,
            'capabilities'       => [
                'Linodes',
                'NodeBalancers',
                'Block Storage',
                'Object Storage',
            ],
            'city'        => 'Philadelphia',
            'company'     => 'Linode LLC',
            'country'     => 'US',
            'credit_card' => [
                'last_four' => 1111,
                'expiry'    => '11/2022',
            ],
            'email'      => 'john.smith@linode.com',
            'first_name' => 'John',
            'last_name'  => 'Smith',
            'phone'      => '215-555-1212',
            'state'      => 'Pennsylvania',
            'tax_id'     => 'ATU99999999',
            'zip'        => 19102,
        ];

        $entity = new AccountInformation($this->client, $data);

        self::assertInstanceOf(CreditCard::class, $entity->credit_card);
        self::assertSame('Linode LLC', $entity->company);

        self::assertCount(1, $entity->promotions);
        self::assertInstanceOf(Promotion::class, $entity->promotions[0]);
        self::assertSame('2018-01-31T23:59:59', $entity->promotions[0]->expire_dt);
        self::assertSame('50.00', $entity->promotions[0]->credit_remaining);
        self::assertSame('10.00', $entity->promotions[0]->this_month_credit_remaining);
        self::assertSame('10.00', $entity->promotions[0]->credit_monthly_cap);
        self::assertSame('$10 off your Linode a month!', $entity->promotions[0]->summary);
        self::assertSame('https://linode.com/10_a_month_promotion.svg', $entity->promotions[0]->image_url);
        self::assertSame('Receive up to $10 off your services every month for 6 months! Unused credits will expire once this promotion period ends.', $entity->promotions[0]->description);
    }
}
