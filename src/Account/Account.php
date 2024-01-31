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

use Linode\Account\Repository\EventRepository;
use Linode\Account\Repository\InvoiceRepository;
use Linode\Account\Repository\NotificationRepository;
use Linode\Account\Repository\OAuthClientRepository;
use Linode\Account\Repository\PaymentRepository;
use Linode\Account\Repository\UserRepository;
use Linode\Entity;
use Linode\Exception\LinodeException;
use Linode\LinodeClient;
use Linode\Managed\StatsDataAvailable;

/**
 * Account object.
 *
 * @property string                          $first_name         The first name of the person associated with this Account.
 * @property string                          $last_name          The last name of the person associated with this Account.
 * @property string                          $email              The email address of the person associated with this Account.
 * @property float                           $balance            This Account's balance, in US dollars.
 * @property float                           $balance_uninvoiced This Account's current estimated invoice in US dollars. This is not your final
 *                                                               invoice balance. Bandwidth charges are not included in the estimate.
 * @property string                          $company            The company name associated with this Account.
 * @property string                          $address_1          First line of this Account's billing address.
 * @property string                          $address_2          Second line of this Account's billing address.
 * @property string                          $city               The city for this Account's billing address.
 * @property string                          $state              If billing address is in the United States, this is the State portion of the
 *                                                               Account's billing address. If the address is outside the US, this is the Province
 *                                                               associated with the Account's billing address.
 * @property string                          $zip                The zip code of this Account's billing address.
 * @property string                          $country            The two-letter country code of this Account's billing address.
 * @property string                          $phone              The phone number associated with this Account.
 * @property string                          $tax_id             The tax identification number associated with this Account, for tax calculations
 *                                                               in some countries. If you do not live in a country that collects tax, this should
 *                                                               be `null`.
 * @property CreditCard                      $credit_card        Credit Card information associated with this Account.
 * @property string                          $active_since       The datetime of when the account was activated.
 * @property string[]                        $capabilities       A list of capabilities your account supports.
 * @property Promotion[]                     $active_promotions  A list of active promotions on your account. Promotions generally
 *                                                               offer a set amount of credit that can be used toward your Linode
 *                                                               services, and the promotion expires after a specified date. As well,
 *                                                               a monthly cap on the promotional offer is set.
 *                                                               Simply put, a promotion offers a certain amount of credit every
 *                                                               month, until either the expiration date is passed, or until the total
 *                                                               promotional credit is used, whichever comes first.
 * @property EventRepositoryInterface        $events             List of Event objects representing actions taken on your Account. The Events
 *                                                               returned depends on your grants.
 * @property InvoiceRepositoryInterface      $invoices           List of Invoices against your Account.
 * @property NotificationRepositoryInterface $notifications      List of Notification objects representing important, often time-sensitive items
 *                                                               related to your Account.
 * @property OAuthClientRepositoryInterface  $oauth_clients      List of OAuth Clients registered to your Account. OAuth Clients allow users to log
 *                                                               into applications you write or host using their Linode Account, and may allow them
 *                                                               to grant some level of access to their Linodes or other entities to your
 *                                                               application.
 * @property PaymentRepositoryInterface      $payments           List of Payments made on this Account.
 * @property UserRepositoryInterface         $users              List of Users on your Account. Users may access all or part of your Account based
 *                                                               on their restricted status and grants. An unrestricted User may access everything
 *                                                               on the account, whereas restricted User may only access entities or perform
 *                                                               actions they've been given specific grants to.
 *
 * @codeCoverageIgnore This class was autogenerated.
 */
class Account extends Entity
{
    // Available fields.
    public const FIELD_FIRST_NAME         = 'first_name';
    public const FIELD_LAST_NAME          = 'last_name';
    public const FIELD_EMAIL              = 'email';
    public const FIELD_BALANCE            = 'balance';
    public const FIELD_BALANCE_UNINVOICED = 'balance_uninvoiced';
    public const FIELD_COMPANY            = 'company';
    public const FIELD_ADDRESS_1          = 'address_1';
    public const FIELD_ADDRESS_2          = 'address_2';
    public const FIELD_CITY               = 'city';
    public const FIELD_STATE              = 'state';
    public const FIELD_ZIP                = 'zip';
    public const FIELD_COUNTRY            = 'country';
    public const FIELD_PHONE              = 'phone';
    public const FIELD_TAX_ID             = 'tax_id';
    public const FIELD_CREDIT_CARD        = 'credit_card';
    public const FIELD_ACTIVE_SINCE       = 'active_since';
    public const FIELD_CAPABILITIES       = 'capabilities';
    public const FIELD_ACTIVE_PROMOTIONS  = 'active_promotions';

    /**
     * Returns the contact and billing information related to your Account.
     *
     * @throws LinodeException
     */
    public function __construct(LinodeClient $client)
    {
        parent::__construct($client);

        $response = $this->client->get('/account');
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        $this->data = $json;
    }

    /**
     * @codeCoverageIgnore This method was autogenerated.
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            self::FIELD_CREDIT_CARD       => new CreditCard($this->client, $this->data[$name]),
            self::FIELD_ACTIVE_PROMOTIONS => array_map(fn ($data) => new Promotion($this->client, $data), $this->data[$name]),
            'events'                      => new EventRepository($this->client),
            'invoices'                    => new InvoiceRepository($this->client),
            'notifications'               => new NotificationRepository($this->client),
            'oauth_clients'               => new OAuthClientRepository($this->client),
            'payments'                    => new PaymentRepository($this->client),
            'users'                       => new UserRepository($this->client),
            default                       => parent::__get($name),
        };
    }

    /**
     * Updates contact and billing information related to your Account.
     *
     * @param array $parameters Update contact and billing information.
     *
     * @throws LinodeException
     */
    public function updateAccount(array $parameters = []): self
    {
        $response   = $this->client->put('/account', $parameters);
        $contents   = $response->getBody()->getContents();
        $this->data = json_decode($contents, true);

        return $this;
    }

    /**
     * Cancels an active Linode account. This action will cause Linode to attempt to
     * charge the credit card on file for the remaining balance. An error will occur if
     * Linode fails to charge the credit card on file. Restricted users will not be able
     * to cancel an account.
     *
     * @param string $comments Any reason for cancelling the account, and any other comments you might have about
     *                         your Linode service.
     *
     * @return string A link to Linode's exit survey.
     *
     * @throws LinodeException
     */
    public function cancelAccount(string $comments): string
    {
        $parameters = [
            'comments' => $comments,
        ];

        $response = $this->client->post('/account/cancel', $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return $json['survey_link'];
    }

    /**
     * Adds/edit credit card information to your Account.
     * Only one credit card can be associated with your Account, so using this endpoint
     * will overwrite your currently active card information with the new credit card.
     *
     * @param string $card_number  Your credit card number. No spaces or dashes allowed.
     * @param string $expiry_month A value from 1-12 representing the expiration month of your credit card.
     * @param string $expiry_year  A four-digit integer representing the expiration year of your credit card.
     * @param string $cvv          The Card Verification Value on the back of the card.
     *
     * @throws LinodeException
     */
    public function createCreditCard(string $card_number, string $expiry_month, string $expiry_year, string $cvv): void
    {
        $parameters = [
            'card_number'  => $card_number,
            'expiry_month' => $expiry_month,
            'expiry_year'  => $expiry_year,
            'cvv'          => $cvv,
        ];

        $this->client->post('/account/credit-card', $parameters);
    }

    /**
     * Returns a Transfer object showing your network utilization, in GB, for the current
     * month.
     *
     * @throws LinodeException
     */
    public function getTransfer(): Transfer
    {
        $response = $this->client->get('/account/transfer');
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Transfer($this->client, $json);
    }

    /**
     * Returns information related to your Account settings: Managed service
     * subscription, Longview subscription, and network helper.
     *
     * @throws LinodeException
     */
    public function getAccountSettings(): AccountSettings
    {
        $response = $this->client->get('/account/settings');
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new AccountSettings($this->client, $json);
    }

    /**
     * Updates your Account settings.
     *
     * @param array $parameters Update Account settings information.
     *
     * @throws LinodeException
     */
    public function updateAccountSettings(array $parameters = []): AccountSettings
    {
        $response = $this->client->put('/account/settings', $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new AccountSettings($this->client, $json);
    }

    /**
     * Enables Linode Managed for the entire account and sends a welcome email to the
     * account's associated email address. Linode Managed can monitor any service or
     * software stack reachable over TCP or HTTP. See our Linode Managed guide to learn
     * more.
     *
     * @throws LinodeException
     */
    public function enableAccountManged(): void
    {
        $this->client->post('/account/settings/managed-enable');
    }

    /**
     * Returns a list of Managed Stats on your Account in the form of x and y data
     * points.
     * You can use these data points to plot your own graph visualizations. These stats
     * reflect the last 24 hours of combined usage across all managed Linodes on your
     * account
     * giving you a high-level snapshot of data for the following:
     *
     * * cpu
     * * disk
     * * swap
     * * network in
     * * network out
     *
     * @return StatsDataAvailable A list of Managed Stats from the last 24 hours.
     *
     * @throws LinodeException
     */
    public function getManagedStats(): StatsDataAvailable
    {
        $response = $this->client->get('/managed/stats');
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new StatsDataAvailable($this->client, $json);
    }
}
