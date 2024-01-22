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

use Linode\Entity\Entity;

/**
 * Account information object.
 *
 * @property string      $first_name         The first name of the person associated with this Account.
 * @property string      $last_name          The last name of the person associated with this Account.
 * @property string      $email              The email address of the person associated with this Account.
 * @property float       $balance            This Account's balance, in US dollars.
 * @property float       $balance_uninvoiced This Account's current estimated invoice in US dollars. This is not
 *                                           your final invoice balance. Bandwidth charges are not included in
 *                                           the estimate.
 * @property string      $company            The company name associated with this Account.
 * @property string      $phone              The phone number associated with this Account.
 * @property null|string $tax_id             The tax identification number associated with this Account,
 *                                           for tax calculations in some countries.
 *                                           If you do not live in a country that collects tax, this should be `null`.
 * @property CreditCard  $credit_card        Credit Card information associated with this Account.
 * @property string      $address_1          First line of this Account's billing address.
 * @property string      $address_2          Second line of this Account's billing address.
 * @property string      $city               The city for this Account's billing address.
 * @property string      $state              If billing address is in the United States, this is the State
 *                                           portion of the Account's billing address. If the address is outside
 *                                           the US, this is the Province associated with the Account's billing
 *                                           address.
 * @property string      $zip                The zip code of this Account's billing address.
 * @property string      $country            The two-letter country code of this Account's billing address.
 * @property string      $active_since       The datetime of when the account was activated.
 * @property string[]    $capabilities       A list of capabilities your account supports.
 */
class AccountInformation extends Entity
{
    // Available fields.
    public const FIELD_FIRST_NAME = 'first_name';
    public const FIELD_LAST_NAME  = 'last_name';
    public const FIELD_EMAIL      = 'email';
    public const FIELD_COMPANY    = 'company';
    public const FIELD_PHONE      = 'phone';
    public const FIELD_TAX_ID     = 'tax_id';
    public const FIELD_ADDRESS_1  = 'address_1';
    public const FIELD_ADDRESS_2  = 'address_2';
    public const FIELD_CITY       = 'city';
    public const FIELD_STATE      = 'state';
    public const FIELD_ZIP        = 'zip';
    public const FIELD_COUNTRY    = 'country';

    public function __get(string $name): mixed
    {
        return match ($name) {
            'credit_card' => new CreditCard($this->client, $this->data['credit_card']),
            default       => parent::__get($name),
        };
    }
}
