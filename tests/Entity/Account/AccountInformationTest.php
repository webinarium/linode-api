<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\Account;

use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

class AccountInformationTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties()
    {
        $data = [
            'address_1'   => '123 Main Street',
            'address_2'   => 'Suite A',
            'balance'     => 200,
            'city'        => 'Philadelphia',
            'credit_card' => [
                'last_four' => 1111,
                'expiry'    => '11/2022',
            ],
            'company'     => 'Linode LLC',
            'country'     => 'US',
            'email'       => 'john.smith@linode.com',
            'first_name'  => 'John',
            'last_name'   => 'Smith',
            'phone'       => '215-555-1212',
            'state'       => 'Pennsylvania',
            'tax_id'      => 'ATU99999999',
            'zip'         => 19102,
        ];

        $entity = new AccountInformation($this->client, $data);

        self::assertInstanceOf(CreditCard::class, $entity->credit_card);
        self::assertSame('Linode LLC', $entity->company);
    }
}
