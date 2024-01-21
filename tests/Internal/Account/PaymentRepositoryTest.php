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

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Linode\Entity\Account\Payment;
use Linode\LinodeClient;
use Linode\ReflectionTrait;
use Linode\Repository\Account\PaymentRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \Linode\Internal\Account\PaymentRepository
 */
final class PaymentRepositoryTest extends TestCase
{
    use ReflectionTrait;

    protected PaymentRepositoryInterface $repository;

    protected function setUp(): void
    {
        $client = new LinodeClient();

        $this->repository = new PaymentRepository($client);
    }

    public function testMakeCreditCardPayment(): void
    {
        $request = [
            'json' => [
                'usd' => '120.50',
                'cvv' => '123',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "id": 123,
                            "date": "2018-01-15T00:01:01",
                            "usd": "120.50"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/account/payments', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $entity = $repository->makeCreditCardPayment('120.50', '123');

        self::assertInstanceOf(Payment::class, $entity);
        self::assertSame('120.50', $entity->usd);
    }

    public function testStagePayPalPayment(): void
    {
        $request = [
            'json' => [
                'usd'          => '120.50',
                'redirect_url' => 'https://example.org',
                'cancel_url'   => 'https://example.org',
            ],
        ];

        $response = <<<'JSON'
                        {
                            "payment_id": "PAY-1234567890ABCDEFGHIJKLMN"
                        }
            JSON;

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/account/payments/paypal', $request, new Response(200, [], $response)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $result = $repository->stagePayPalPayment('120.50', 'https://example.org', 'https://example.org');

        self::assertSame('PAY-1234567890ABCDEFGHIJKLMN', $result);
    }

    public function testExecutePayPalPayment(): void
    {
        $request = [
            'json' => [
                'payer_id'   => 'ABCDEFGHIJKLM',
                'payment_id' => 'PAY-1234567890ABCDEFGHIJKLMN',
            ],
        ];

        $client = $this->createMock(Client::class);
        $client
            ->method('request')
            ->willReturnMap([
                ['POST', 'https://api.linode.com/v4/account/payments/paypal/execute', $request, new Response(200, [], null)],
            ])
        ;

        /** @var Client $client */
        $repository = $this->mockRepository($client);

        $repository->executePayPalPayment('ABCDEFGHIJKLM', 'PAY-1234567890ABCDEFGHIJKLMN');

        self::assertTrue(true);
    }

    public function testGetBaseUri(): void
    {
        $expected = '/account/payments';

        self::assertSame($expected, $this->callMethod($this->repository, 'getBaseUri'));
    }

    public function testGetSupportedFields(): void
    {
        $expected = [
            'id',
            'date',
            'usd',
        ];

        self::assertSame($expected, $this->callMethod($this->repository, 'getSupportedFields'));
    }

    public function testJsonToEntity(): void
    {
        self::assertInstanceOf(Payment::class, $this->callMethod($this->repository, 'jsonToEntity', [[]]));
    }

    protected function mockRepository(Client $client): PaymentRepositoryInterface
    {
        $linodeClient = new LinodeClient();
        $this->setProperty($linodeClient, 'client', $client);

        return new PaymentRepository($linodeClient);
    }
}
