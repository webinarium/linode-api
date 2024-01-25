<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity;

use GuzzleHttp\Psr7\Response;
use Linode\Account\Account;
use Linode\Account\AccountInformation;
use Linode\Account\AccountSettings;
use Linode\Account\CreditCard;
use Linode\Account\NetworkUtilization;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Account\Account
 */
final class AccountTest extends TestCase
{
    protected LinodeClient $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testGetAccountInformation(): void
    {
        $response = <<<'JSON'
                        {
                            "address_1": "123 Main Street",
                            "address_2": "Suite A",
                            "balance": 200,
                            "city": "Philadelphia",
                            "credit_card": {
                                "last_four": 1111,
                                "expiry": "11/2022"
                            },
                            "company": "Linode LLC",
                            "country": "US",
                            "email": "john.smith@linode.com",
                            "first_name": "John",
                            "last_name": "Smith",
                            "phone": "215-555-1212",
                            "state": "Pennsylvania",
                            "tax_id": "ATU99999999",
                            "zip": 19102
                        }
            JSON;

        $this->client
            ->method('get')
            ->willReturnMap([
                ['/account', [], [], new Response(200, [], $response)],
            ])
        ;

        $account = new Account($this->client);

        $entity = $account->getAccountInformation();

        self::assertInstanceOf(AccountInformation::class, $entity);
        self::assertSame('john.smith@linode.com', $entity->email);
        self::assertInstanceOf(CreditCard::class, $entity->credit_card);
        self::assertSame('11/2022', $entity->credit_card->expiry);
    }

    public function testSetAccountInformation(): void
    {
        $request = [
            'address_1'  => '123 Main Street',
            'address_2'  => 'Suite A',
            'city'       => 'Philadelphia',
            'company'    => 'Linode LLC',
            'country'    => 'US',
            'email'      => 'john.smith@linode.com',
            'first_name' => 'John',
            'last_name'  => 'Smith',
            'phone'      => '215-555-1212',
            'state'      => 'Pennsylvania',
            'tax_id'     => 'ATU99999999',
            'zip'        => 19102,
        ];

        $response = <<<'JSON'
                        {
                            "address_1": "123 Main Street",
                            "address_2": "Suite A",
                            "balance": 200,
                            "city": "Philadelphia",
                            "credit_card": {
                                "last_four": 1111,
                                "expiry": "11/2022"
                            },
                            "company": "Linode LLC",
                            "country": "US",
                            "email": "john.smith@linode.com",
                            "first_name": "John",
                            "last_name": "Smith",
                            "phone": "215-555-1212",
                            "state": "Pennsylvania",
                            "tax_id": "ATU99999999",
                            "zip": 19102
                        }
            JSON;

        $this->client
            ->method('put')
            ->willReturnMap([
                ['/account', $request, new Response(200, [], $response)],
            ])
        ;

        $account = new Account($this->client);

        $entity = $account->setAccountInformation([
            AccountInformation::FIELD_ADDRESS_1  => '123 Main Street',
            AccountInformation::FIELD_ADDRESS_2  => 'Suite A',
            AccountInformation::FIELD_CITY       => 'Philadelphia',
            AccountInformation::FIELD_COMPANY    => 'Linode LLC',
            AccountInformation::FIELD_COUNTRY    => 'US',
            AccountInformation::FIELD_EMAIL      => 'john.smith@linode.com',
            AccountInformation::FIELD_FIRST_NAME => 'John',
            AccountInformation::FIELD_LAST_NAME  => 'Smith',
            AccountInformation::FIELD_PHONE      => '215-555-1212',
            AccountInformation::FIELD_STATE      => 'Pennsylvania',
            AccountInformation::FIELD_TAX_ID     => 'ATU99999999',
            AccountInformation::FIELD_ZIP        => 19102,
        ]);

        self::assertInstanceOf(AccountInformation::class, $entity);
        self::assertSame('john.smith@linode.com', $entity->email);
        self::assertInstanceOf(CreditCard::class, $entity->credit_card);
        self::assertSame('11/2022', $entity->credit_card->expiry);
    }

    public function testCancel(): void
    {
        $request = [
            'comments' => 'I am consolidating my accounts.',
        ];

        $response = <<<'JSON'
                        {
                            "survey_link": "https://alinktothesurvey.com"
                        }
            JSON;

        $this->client
            ->method('post')
            ->willReturnMap([
                ['/account/cancel', $request, new Response(200, [], $response)],
            ])
        ;

        $account = new Account($this->client);

        $link = $account->cancel('I am consolidating my accounts.');

        self::assertSame('https://alinktothesurvey.com', $link);
    }

    public function testUpdateCreditCard(): void
    {
        $request = [
            'card_number'  => '4111111111111111',
            'expiry_month' => '12',
            'expiry_year'  => '2020',
            'cvv'          => '123',
        ];

        $this->client
            ->method('post')
            ->willReturnMap([
                ['/account/credit-card', $request, new Response(200, [], null)],
            ])
        ;

        $account = new Account($this->client);

        $account->updateCreditCard('4111111111111111', '12', '2020', '123');

        self::assertTrue(true);
    }

    public function testGetAccountSettings(): void
    {
        $response = <<<'JSON'
                        {
                            "managed": true,
                            "longview_subscription": "longview-30",
                            "network_helper": false,
                            "backups_enabled": true
                        }
            JSON;

        $this->client
            ->method('get')
            ->willReturnMap([
                ['/account/settings', [], [], new Response(200, [], $response)],
            ])
        ;

        $account = new Account($this->client);

        $entity = $account->getAccountSettings();

        self::assertInstanceOf(AccountSettings::class, $entity);
        self::assertSame('longview-30', $entity->longview_subscription);
        self::assertTrue($entity->backups_enabled);
    }

    public function testSetAccountSettings(): void
    {
        $request = [
            'longview_subscription' => 'longview-30',
            'network_helper'        => false,
            'backups_enabled'       => true,
        ];

        $response = <<<'JSON'
                        {
                            "managed": true,
                            "longview_subscription": "longview-30",
                            "network_helper": false,
                            "backups_enabled": true
                        }
            JSON;

        $this->client
            ->method('put')
            ->willReturnMap([
                ['/account/settings', $request, new Response(200, [], $response)],
            ])
        ;

        $account = new Account($this->client);

        $entity = $account->setAccountSettings([
            AccountSettings::FIELD_LONGVIEW_SUBSCRIPTION => 'longview-30',
            AccountSettings::FIELD_NETWORK_HELPER        => false,
            AccountSettings::FIELD_BACKUPS_ENABLED       => true,
        ]);

        self::assertInstanceOf(AccountSettings::class, $entity);
        self::assertSame('longview-30', $entity->longview_subscription);
        self::assertTrue($entity->backups_enabled);
    }

    public function testGetNetworkUtilization(): void
    {
        $response = <<<'JSON'
                        {
                            "billable": 0,
                            "quota": 9141,
                            "used": 2
                        }
            JSON;

        $this->client
            ->method('get')
            ->willReturnMap([
                ['/account/transfer', [], [], new Response(200, [], $response)],
            ])
        ;

        $account = new Account($this->client);

        $entity = $account->getNetworkUtilization();

        self::assertInstanceOf(NetworkUtilization::class, $entity);
        self::assertSame(9141, $entity->quota);
        self::assertSame(2, $entity->used);
        self::assertSame(0, $entity->billable);
    }
}
