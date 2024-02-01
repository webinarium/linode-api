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
 * PaymentMethod repository.
 *
 * @method PaymentMethod   find(int|string $id)
 * @method PaymentMethod[] findAll(string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method PaymentMethod[] findBy(array $criteria, string $orderBy = null, string $orderDir = self::SORT_ASC)
 * @method PaymentMethod   findOneBy(array $criteria)
 * @method PaymentMethod[] query(string $query, array $parameters = [], string $orderBy = null, string $orderDir = self::SORT_ASC)
 */
interface PaymentMethodRepositoryInterface extends RepositoryInterface
{
    /**
     * Adds a Payment Method to your Account with the option to set it as the default
     * method.
     *
     * * Adding a default Payment Method removes the default status from any other
     * Payment Method.
     *
     * * An Account can have up to 6 active Payment Methods.
     *
     * * Up to 60 Payment Methods can be added each day.
     *
     * * Prior to adding a Payment Method, ensure that your billing address information
     * is up-to-date
     * with a valid `zip` by using the Account Update (PUT /account) endpoint.
     *
     * * A `payment_method_add` event is generated when a payment is successfully
     * submitted.
     *
     * @param array $parameters The details of the Payment Method to add.
     *
     * @throws LinodeException
     */
    public function createPaymentMethod(array $parameters = []): void;

    /**
     * Deactivate the specified Payment Method.
     *
     * The default Payment Method can not be deleted. To add a new default Payment
     * Method, access the Payment Method
     * Add (POST /account/payment-methods) endpoint. To designate an existing
     * Payment Method as the default method, access the Payment Method Make Default
     * (POST /account/payment-methods/{paymentMethodId}/make-default)
     * endpoint.
     *
     * @param int $paymentMethodId The ID of the Payment Method to look up.
     *
     * @throws LinodeException
     */
    public function deletePaymentMethod(int $paymentMethodId): void;

    /**
     * Make the specified Payment Method the default method for automatically processing
     * payments.
     *
     * Removes the default status from any other Payment Method.
     *
     * @param int $paymentMethodId The ID of the Payment Method to make default.
     *
     * @throws LinodeException
     */
    public function makePaymentMethodDefault(int $paymentMethodId): void;
}
