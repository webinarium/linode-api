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

use GuzzleHttp\Psr7\Response;
use Linode\Entity\Account\AccountInformation;
use Linode\Entity\Account\AccountSettings;
use Linode\Entity\Account\CreditCard;
use Linode\Entity\Account\NetworkUtilization;
use Linode\Internal\Account\EventRepository;
use Linode\Internal\Account\InvoiceRepository;
use Linode\Internal\Account\NotificationRepository;
use Linode\Internal\Account\OAuthClientRepository;
use Linode\Internal\Account\PaymentRepository;
use Linode\Internal\Account\UserRepository;
use Linode\LinodeClient;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    /** @var LinodeClient|\PHPUnit\Framework\MockObject\MockObject */
    protected $client;

    protected function setUp()
    {
        $this->client = $this->createMock(LinodeClient::class);
    }

    public function testProperties()
    {
        $entity = new Account($this->client);

        self::assertInstanceOf(EventRepository::class, $entity->events);
        self::assertInstanceOf(InvoiceRepository::class, $entity->invoices);
        self::assertInstanceOf(NotificationRepository::class, $entity->notifications);
        self::assertInstanceOf(OAuthClientRepository::class, $entity->oauth_clients);
        self::assertInstanceOf(PaymentRepository::class, $entity->payments);
        self::assertInstanceOf(UserRepository::class, $entity->users);

        /** @noinspection PhpUndefinedFieldInspection */
        self::assertNull($entity->unknown);
    }

    public function testGetAccountInformation()
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
            ->method('api')
            ->willReturnMap([
                ['GET', '/account', [], [], new Response(200, [], $response)],
            ]);

        $account = new Account($this->client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $account->getAccountInformation();

        self::assertInstanceOf(AccountInformation::class, $entity);
        self::assertSame('john.smith@linode.com', $entity->email);
        self::assertInstanceOf(CreditCard::class, $entity->credit_card);
        self::assertSame('11/2022', $entity->credit_card->expiry);
    }

    public function testSetAccountInformation()
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
            ->method('api')
            ->willReturnMap([
                ['PUT', '/account', $request, [], new Response(200, [], $response)],
            ]);

        $account = new Account($this->client);

        /** @noinspection PhpUnhandledExceptionInspection */
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

    public function testUpdateCreditCard()
    {
        $request = [
            'card_number'  => '4111111111111111',
            'expiry_month' => '12',
            'expiry_year'  => '2020',
        ];

        $this->client
            ->method('api')
            ->willReturnMap([
                ['POST', '/account/credit-card', $request, [], new Response(200, [], null)],
            ]);

        $account = new Account($this->client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $account->updateCreditCard('4111111111111111', '12', '2020');

        self::assertTrue(true);
    }

    public function testGetAccountSettings()
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
            ->method('api')
            ->willReturnMap([
                ['GET', '/account/settings', [], [], new Response(200, [], $response)],
            ]);

        $account = new Account($this->client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $account->getAccountSettings();

        self::assertInstanceOf(AccountSettings::class, $entity);
        self::assertSame('longview-30', $entity->longview_subscription);
        self::assertTrue($entity->backups_enabled);
    }

    public function testSetAccountSettings()
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
            ->method('api')
            ->willReturnMap([
                ['PUT', '/account/settings', $request, [], new Response(200, [], $response)],
            ]);

        $account = new Account($this->client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $account->setAccountSettings([
            AccountSettings::FIELD_LONGVIEW_SUBSCRIPTION => 'longview-30',
            AccountSettings::FIELD_NETWORK_HELPER        => false,
            AccountSettings::FIELD_BACKUPS_ENABLED       => true,
        ]);

        self::assertInstanceOf(AccountSettings::class, $entity);
        self::assertSame('longview-30', $entity->longview_subscription);
        self::assertTrue($entity->backups_enabled);
    }

    public function testGetNetworkUtilization()
    {
        $response = <<<'JSON'
            {
                "billable": 0,
                "quota": 9141,
                "used": 2
            }
JSON;

        $this->client
            ->method('api')
            ->willReturnMap([
                ['GET', '/account/transfer', [], [], new Response(200, [], $response)],
            ]);

        $account = new Account($this->client);

        /** @noinspection PhpUnhandledExceptionInspection */
        $entity = $account->getNetworkUtilization();

        self::assertInstanceOf(NetworkUtilization::class, $entity);
        self::assertSame(9141, $entity->quota);
        self::assertSame(2, $entity->used);
        self::assertSame(0, $entity->billable);
    }
}
