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

use Linode\Account\Repository\AccountAvailabilityRepository;
use Linode\Account\Repository\BetaProgramEnrolledRepository;
use Linode\Account\Repository\EventRepository;
use Linode\Account\Repository\InvoiceRepository;
use Linode\Account\Repository\NotificationRepository;
use Linode\Account\Repository\OAuthClientRepository;
use Linode\Account\Repository\PaymentMethodRepository;
use Linode\Account\Repository\PaymentRepository;
use Linode\Account\Repository\ServiceTransferRepository;
use Linode\Account\Repository\UserRepository;
use Linode\Entity;
use Linode\Exception\LinodeException;
use Linode\LinodeClient;
use Linode\Longview\LongviewSubscription;
use Linode\Managed\StatsDataAvailable;

/**
 * Account object.
 *
 * @property string                                 $first_name         The first name of the person associated with this Account.
 *                                                                      Must not include any of the following characters: `<` `>` `(` `)` `"` `=`
 * @property string                                 $last_name          The last name of the person associated with this Account.
 *                                                                      Must not include any of the following characters: `<` `>` `(` `)` `"` `=`
 * @property string                                 $email              The email address of the person associated with this Account.
 * @property float                                  $balance            This Account's balance, in US dollars.
 * @property float                                  $balance_uninvoiced This Account's current estimated invoice in US dollars. This is not your final
 *                                                                      invoice balance. Transfer charges are not included in the estimate.
 * @property string                                 $company            The company name associated with this Account.
 *                                                                      Must not include any of the following characters: `<` `>` `(` `)` `"` `=`
 * @property string                                 $address_1          First line of this Account's billing address.
 * @property string                                 $address_2          Second line of this Account's billing address.
 * @property string                                 $city               The city for this Account's billing address.
 * @property string                                 $state              If billing address is in the United States (US) or Canada (CA), only the
 *                                                                      two-letter ISO 3166 State or Province code are accepted. If entering a US military
 *                                                                      address, state abbreviations (AA, AE, AP) should be entered. If the address is
 *                                                                      outside the US or CA, this is the Province associated with the Account's billing
 *                                                                      address.
 * @property string                                 $zip                The zip code of this Account's billing address. The following restrictions apply:
 *                                                                      - May only consist of letters, numbers, spaces, and hyphens.
 *                                                                      - Must not contain more than 9 letter or number characters.
 * @property string                                 $country            The two-letter ISO 3166 country code of this Account's billing address.
 * @property string                                 $phone              The phone number associated with this Account.
 * @property string                                 $tax_id             The tax identification number associated with this Account, for tax calculations
 *                                                                      in some countries. If you do not live in a country that collects tax, this should
 *                                                                      be an empty string (`""`).
 * @property CreditCardData                         $credit_card        Credit Card information associated with this Account.
 * @property string                                 $active_since       The datetime of when the account was activated.
 * @property string[]                               $capabilities       A list of capabilities your account supports.
 * @property Promotion[]                            $active_promotions  A list of active promotions on your account.
 * @property string                                 $billing_source     The source of service charges for this Account, as determined by its relationship
 *                                                                      with Akamai.
 *                                                                      Accounts that are associated with Akamai-specific customers return a value of
 *                                                                      `akamai`.
 *                                                                      All other Accounts return a value of `linode`.
 * @property string                                 $euuid              An external unique identifier for this account.
 * @property AccountAvailabilityRepositoryInterface $availability       Account Service Availability.
 * @property BetaProgramEnrolledRepositoryInterface $betaPrograms       List of all enrolled Beta Program objects for the Account.
 * @property EventRepositoryInterface               $events             List of Event objects representing actions taken on your Account. The Events
 *                                                                      returned depends on your grants.
 * @property InvoiceRepositoryInterface             $invoices           List of Invoices against your Account.
 * @property NotificationRepositoryInterface        $notifications      List of Notification objects representing important, often time-sensitive items
 *                                                                      related to your Account.
 * @property OAuthClientRepositoryInterface         $oauth_clients      List of OAuth Clients registered to your Account. OAuth Clients allow users to log
 *                                                                      into applications you write or host using their Linode Account, and may allow them
 *                                                                      to grant some level of access to their Linodes or other entities to your
 *                                                                      application.
 * @property PaymentRepositoryInterface             $payments           List of Payments made on this Account.
 * @property PaymentMethodRepositoryInterface       $paymentMethods     List of Payment Methods for this Account.
 * @property ServiceTransferRepositoryInterface     $serviceTransfers   List of Service Transfer objects containing the details of all transfers that have
 *                                                                      been created and accepted by this account.
 * @property UserRepositoryInterface                $users              List of Users on your Account. Users may access all or part of your Account based
 *                                                                      on their restricted status and grants. An unrestricted User may access everything
 *                                                                      on the account, whereas restricted User may only access entities or perform
 *                                                                      actions they've been given specific grants to.
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
    public const FIELD_BILLING_SOURCE     = 'billing_source';
    public const FIELD_EUUID              = 'euuid';

    // `FIELD_BILLING_SOURCE` values.
    public const BILLING_SOURCE_AKAMAI = 'akamai';
    public const BILLING_SOURCE_LINODE = 'linode';

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
            self::FIELD_CREDIT_CARD       => new CreditCardData($this->client, $this->data[$name]),
            self::FIELD_ACTIVE_PROMOTIONS => array_map(fn ($data) => new Promotion($this->client, $data), $this->data[$name]),
            'availability'                => new AccountAvailabilityRepository($this->client),
            'betaPrograms'                => new BetaProgramEnrolledRepository($this->client),
            'events'                      => new EventRepository($this->client),
            'invoices'                    => new InvoiceRepository($this->client),
            'notifications'               => new NotificationRepository($this->client),
            'oauth_clients'               => new OAuthClientRepository($this->client),
            'payments'                    => new PaymentRepository($this->client),
            'paymentMethods'              => new PaymentMethodRepository($this->client),
            'serviceTransfers'            => new ServiceTransferRepository($this->client),
            'users'                       => new UserRepository($this->client),
            default                       => parent::__get($name),
        };
    }

    /**
     * Updates contact and billing information related to your Account.
     *
     * @param array $parameters Update contact and billing information.
     *
     * Account properties that are excluded from a request remain unchanged.
     *
     * When updating an Account's `country` to "US", an error is returned if the
     * Account's `zip` is not a valid US zip code.
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
     * **DEPRECATED**. Please use Payment Method Add (POST /account/payment-methods).
     *
     * Adds a credit card Payment Method to your account and sets it as the default
     * method.
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
     * Returns a collection of successful logins for all users on the account during the
     * last 90 days. This command can only be accessed by the unrestricted users of an
     * account.
     *
     * @return Login[] A collection of successful logins for all users on the account during the last 90
     *                 days.
     *
     * @throws LinodeException
     */
    public function getAccountLogins(): array
    {
        $response = $this->client->get('/account/logins');
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return array_map(fn ($data) => new Login($this->client, $data), $json['data']);
    }

    /**
     * Returns a Login object that displays information about a successful login. The
     * logins that can be viewed can be for any user on the account, and are not limited
     * to only the logins of the user that is accessing this API endpoint. This command
     * can only be accessed by the unrestricted users of the account.
     *
     * @param int $loginId The ID of the login object to access.
     *
     * @throws LinodeException
     */
    public function getAccountLogin(int $loginId): Login
    {
        $response = $this->client->get("/account/logins/{$loginId}");
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Login($this->client, $json);
    }

    /**
     * Returns a collection of Maintenance objects for any entity a user has permissions
     * to view. Canceled Maintenance objects are not returned.
     *
     * Currently, Linodes are the only entities available for viewing.
     *
     * @throws LinodeException
     */
    public function getMaintenance(): array
    {
        $response = $this->client->get('/account/maintenance');
        $contents = $response->getBody()->getContents();

        return json_decode($contents, true);
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
     * To update your Longview subscription plan, send a request to Update Longview Plan.
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
    public function enableAccountManaged(): void
    {
        $this->client->post('/account/settings/managed-enable');
    }

    /**
     * Send a one-time verification code via SMS message to the submitted phone number.
     * Providing your phone number helps ensure you can securely access your Account in
     * case other ways to connect are lost. Your phone number is only used to verify your
     * identity by sending an SMS message. Standard carrier messaging fees may apply.
     *
     * * By accessing this command you are opting in to receive SMS messages. You can opt
     * out of SMS messages by using the **Phone Number Delete** (DELETE
     * /profile/phone-number) command after your phone number is verified.
     *
     * * Verification codes are valid for 10 minutes after they are sent.
     *
     * * Subsequent requests made prior to code expiration result in sending the same
     * code.
     *
     * Once a verification code is received, verify your phone number with the **Phone
     * Number Verify** (POST /profile/phone-number/verify) command.
     *
     * @param string $iso_code     The two-letter ISO 3166 country code associated with the phone number.
     * @param string $phone_number A valid phone number.
     *
     * @throws LinodeException
     */
    public function postProfilePhoneNumber(string $iso_code, string $phone_number): void
    {
        $parameters = [
            'iso_code'     => $iso_code,
            'phone_number' => $phone_number,
        ];

        $this->client->post('/profile/phone-number', $parameters);
    }

    /**
     * Verify a phone number by confirming the one-time code received via SMS message
     * after accessing the **Phone Verification Code Send** (POST /profile/phone-number)
     * command.
     *
     * * Verification codes are valid for 10 minutes after they are sent.
     *
     * * Only the same User that made the verification code request can use that code
     * with this command.
     *
     * Once completed, the verified phone number is assigned to the User making the
     * request. To change the verified phone number for a User, first use the **Phone
     * Number Delete** (DELETE /profile/phone-number) command, then begin the
     * verification process again with the **Phone Verification Code Send** (POST
     * /profile/phone-number) command.
     *
     * @param string $otp_code The one-time code received via SMS message after accessing the **Phone
     *                         Verification Code Send** (POST /profile/phone-number) command.
     *
     * @throws LinodeException
     */
    public function postProfilePhoneNumberVerify(string $otp_code): void
    {
        $parameters = [
            'otp_code' => $otp_code,
        ];

        $this->client->post('/profile/phone-number/verify', $parameters);
    }

    /**
     * Delete the verified phone number for the User making this request.
     *
     * Use this command to opt out of SMS messages for the requesting User after a phone
     * number has been verified with the **Phone Number Verify** (POST
     * /profile/phone-number/verify) command.
     *
     * @throws LinodeException
     */
    public function deleteProfilePhoneNumber(): void
    {
        $this->client->delete('/profile/phone-number');
    }

    /**
     * Returns a collection of security questions and their responses, if any, for your
     * User Profile.
     *
     * @return SecurityQuestion[] List of security questions.
     *
     * @throws LinodeException
     */
    public function getSecurityQuestions(): array
    {
        $response = $this->client->get('/profile/security-questions');
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return array_map(fn ($data) => new SecurityQuestion($this->client, $data), $json['security_questions']);
    }

    /**
     * Adds security question responses for your User.
     *
     * Requires exactly three unique questions.
     *
     * Previous responses are overwritten if answered or reset to `null` if unanswered.
     *
     * **Note**: Security questions must be answered for your User prior to accessing the
     * **Two Factor Secret Create** (POST /profile/tfa-enable) command.
     *
     * @param array $parameters Answer Security Questions
     *
     * @return SecurityQuestion[] List of security questions.
     *
     * @throws LinodeException
     */
    public function postSecurityQuestions(array $parameters = []): array
    {
        $response = $this->client->post('/profile/security-questions', $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return array_map(fn ($data) => new SecurityQuestion($this->client, $data), $json['security_questions']);
    }

    /**
     * Get the details of your current Longview plan. This returns a
     * `LongviewSubscription` object for your current Longview Pro plan, or an empty set
     * `{}` if your current plan is Longview Free.
     *
     * You must have at least one of the following `global` User Grants in order to
     * access this endpoint:
     *
     *   - `"account_access": read_write`
     *   - `"account_access": read_only`
     *   - `"longview_subscription": true`
     *   - `"add_longview": true`
     *
     * To update your subscription plan, send a request to Update Longview Plan.
     *
     * @throws LinodeException
     */
    public function getLongviewPlan(): LongviewSubscription
    {
        $response = $this->client->get('/longview/plan');
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new LongviewSubscription($this->client, $json);
    }

    /**
     * Update your Longview plan to that of the given subcription ID. This returns a
     * `LongviewSubscription` object for the updated Longview Pro plan, or an empty set
     * `{}` if the updated plan is Longview Free.
     *
     * You must have `"longview_subscription": true` configured as a `global` User Grant
     * in order to access this endpoint.
     *
     * You can send a request to the List Longview Subscriptions endpoint to receive the
     * details, including `id`'s, of each plan.
     *
     * @param array $parameters Update your Longview subscription plan.
     *
     * @throws LinodeException
     */
    public function updateLongviewPlan(array $parameters = []): LongviewSubscription
    {
        $response = $this->client->put('/longview/plan', $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new LongviewSubscription($this->client, $json);
    }

    /**
     * Adds an expiring Promo Credit to your account.
     *
     * The following restrictions apply:
     *
     * * Your account must be less than 90 days old.
     * * There must not be an existing Promo Credit already on your account.
     * * The requesting User must be unrestricted. Use the User Update
     *   (PUT /account/users/{username}) to change a User's restricted status.
     * * The `promo_code` must be valid and unexpired.
     *
     * @param array $parameters Enter a Promo Code to add its associated credit to your Account.
     *
     * @throws LinodeException
     */
    public function createPromoCredit(array $parameters = []): Promotion
    {
        $response = $this->client->post('/account/promo-codes', $parameters);
        $contents = $response->getBody()->getContents();
        $json     = json_decode($contents, true);

        return new Promotion($this->client, $json);
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
     * This command can only be accessed by the unrestricted users of an account.
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
