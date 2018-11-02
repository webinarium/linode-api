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

use Linode\Entity\Account\AccountInformation;
use Linode\Entity\Account\AccountSettings;
use Linode\Entity\Account\NetworkUtilization;
use Linode\Internal\Account\EventRepository;
use Linode\Internal\Account\InvoiceRepository;
use Linode\Internal\Account\NotificationRepository;
use Linode\Internal\Account\OAuthClientRepository;
use Linode\Internal\Account\PaymentRepository;
use Linode\Internal\Account\UserRepository;
use Linode\Internal\Longview\LongviewClientRepository;
use Linode\Internal\Managed\ManagedContactRepository;
use Linode\Internal\Managed\ManagedCredentialRepository;
use Linode\Internal\Managed\ManagedIssueRepository;
use Linode\Internal\Managed\ManagedLinodeSettingsRepository;
use Linode\Internal\Managed\ManagedServiceRepository;
use Linode\LinodeClient;
use Linode\Repository\RepositoryInterface;

/**
 * Current user account.
 *
 * @property \Linode\Repository\Account\EventRepositoryInterface                 $events
 * @property \Linode\Repository\Account\InvoiceRepositoryInterface               $invoices
 * @property \Linode\Repository\Longview\LongviewClientRepositoryInterface       $longviews_clients
 * @property \Linode\Repository\Managed\ManagedContactRepositoryInterface        $managed_contacts
 * @property \Linode\Repository\Managed\ManagedCredentialRepositoryInterface     $managed_credentials
 * @property \Linode\Repository\Managed\ManagedIssueRepositoryInterface          $managed_issues
 * @property \Linode\Repository\Managed\ManagedLinodeSettingsRepositoryInterface $managed_linode_settings
 * @property \Linode\Repository\Managed\ManagedServiceRepositoryInterface        $managed_services
 * @property \Linode\Repository\Account\NotificationRepositoryInterface          $notifications
 * @property \Linode\Repository\Account\OAuthClientRepositoryInterface           $oauth_clients
 * @property \Linode\Repository\Account\PaymentRepositoryInterface               $payments
 * @property \Linode\Repository\Account\UserRepositoryInterface                  $users
 */
class Account
{
    protected $client;

    /**
     * Account constructor.
     *
     * @param LinodeClient $client Linode API client.
     */
    public function __construct(LinodeClient $client)
    {
        $this->client = $client;
    }

    /**
     * Returns requested repository.
     *
     * @param string $name Repository name.
     *
     * @return null|RepositoryInterface
     */
    public function __get(string $name)
    {
        switch ($name) {

            case 'events':
                return new EventRepository($this->client);

            case 'invoices':
                return new InvoiceRepository($this->client);

            case 'longviews_clients':
                return new LongviewClientRepository($this->client);

            case 'managed_contacts':
                return new ManagedContactRepository($this->client);

            case 'managed_credentials':
                return new ManagedCredentialRepository($this->client);

            case 'managed_issues':
                return new ManagedIssueRepository($this->client);

            case 'managed_linode_settings':
                return new ManagedLinodeSettingsRepository($this->client);

            case 'managed_services':
                return new ManagedServiceRepository($this->client);

            case 'notifications':
                return new NotificationRepository($this->client);

            case 'oauth_clients':
                return new OAuthClientRepository($this->client);

            case 'payments':
                return new PaymentRepository($this->client);

            case 'users':
                return new UserRepository($this->client);
        }

        return null;
    }

    /**
     * Returns the contact and billing information related to your Account.
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return AccountInformation
     */
    public function getAccountInformation(): AccountInformation
    {
        $response = $this->client->api($this->client::REQUEST_GET, '/account');
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new AccountInformation($this->client, $json);
    }

    /**
     * Updates contact and billing information related to your Account.
     *
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return AccountInformation
     */
    public function setAccountInformation(array $parameters): AccountInformation
    {
        $response = $this->client->api($this->client::REQUEST_PUT, '/account', $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new AccountInformation($this->client, $json);
    }

    /**
     * Adds/edit credit card information to your Account.
     *
     * Only one credit card can be associated with your Account, so using this
     * endpoint will overwrite your currently active card information with the
     * new credit card.
     *
     * @param string $card_number  Your credit card number. No spaces or dashes allowed.
     * @param string $expiry_month A value from 1-12 representing the expiration month of your credit card.
     * @param string $expiry_year  A four-digit integer representing the expiration year of your credit card.
     *
     * @throws \Linode\Exception\LinodeException
     */
    public function updateCreditCard(string $card_number, string $expiry_month, string $expiry_year): void
    {
        $parameters = [
            'card_number'  => $card_number,
            'expiry_month' => $expiry_month,
            'expiry_year'  => $expiry_year,
        ];

        $this->client->api($this->client::REQUEST_POST, '/account/credit-card', $parameters);
    }

    /**
     * Returns information related to your Account settings: Managed service
     * subscription, Longview subscription, and network helper.
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return AccountSettings
     */
    public function getAccountSettings(): AccountSettings
    {
        $response = $this->client->api($this->client::REQUEST_GET, '/account/settings');
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new AccountSettings($this->client, $json);
    }

    /**
     * Updates your Account settings.
     *
     * @param array $parameters
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return AccountSettings
     */
    public function setAccountSettings(array $parameters): AccountSettings
    {
        $response = $this->client->api($this->client::REQUEST_PUT, '/account/settings', $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new AccountSettings($this->client, $json);
    }

    /**
     * Returns a Transfer object showing your network utilization, in GB, for the current month.
     *
     * @throws \Linode\Exception\LinodeException
     *
     * @return NetworkUtilization
     */
    public function getNetworkUtilization(): NetworkUtilization
    {
        $response = $this->client->api($this->client::REQUEST_GET, '/account/transfer');
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new NetworkUtilization($this->client, $json);
    }
}
