<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Account;

use Linode\Exception\LinodeException;
use Linode\RepositoryInterface;

/**
 * Payment repository.
 *
 * @method Payment   find(int|string $id)
 * @method Payment[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Payment[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method Payment   findOneBy(array $criteria)
 * @method Payment[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface PaymentRepositoryInterface extends RepositoryInterface
{
    /**
     * Makes a Payment to your Account.
     *
     * * The requested amount is charged to the default Payment Method if no
     * `payment_method_id` is specified.
     *
     * * A `payment_submitted` event is generated when a payment is successfully
     * submitted.
     *
     * @param string $usd The amount in US Dollars of the Payment. The maximum credit card payment that can
     *                    be made is $50,000 dollars.
     * @param string $cvv CVV (Card Verification Value) of the credit card to be used for the Payment.
     *
     * @throws LinodeException
     */
    public function createPayment(string $usd, string $cvv): Payment;

    /**
     * **Note**: This endpoint is disabled and no longer accessible. PayPal can be
     * designated as a Payment Method for automated payments using
     * Cloud Manager.
     *
     * @param string $usd          The payment amount in USD. Minimum accepted value of $5 USD. Maximum accepted
     *                             value of $500 USD or credit card payment limit; whichever value is highest.
     *                             PayPal's maximum transaction limit is $10,000 USD.
     * @param string $redirect_url The URL to have PayPal redirect to when Payment is approved.
     * @param string $cancel_url   The URL to have PayPal redirect to when Payment is cancelled.
     *
     * @return PayPalPayment PayPal Payment staged.
     *
     * @throws LinodeException
     */
    public function createPayPalPayment(string $usd, string $redirect_url, string $cancel_url): PayPalPayment;

    /**
     * **Note**: This endpoint is disabled and no longer accessible. PayPal can be
     * designated as a Payment Method for automated payments using
     * Cloud Manager.
     *
     * @param string $payer_id   The PayerID returned by PayPal during the transaction authorization process.
     * @param string $payment_id The PaymentID returned from `createPayPalPayment` that has been approved with
     *                           PayPal.
     *
     * @throws LinodeException
     */
    public function executePayPalPayment(string $payer_id, string $payment_id): void;
}
