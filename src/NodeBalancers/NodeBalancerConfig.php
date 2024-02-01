<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\NodeBalancers;

use Linode\Entity;
use Linode\NodeBalancers\Repository\NodeBalancerNodeRepository;

/**
 * A NodeBalancer config represents the configuration of this NodeBalancer on a
 * single port. For example, a NodeBalancer Config on port 80 would typically
 * represent how this NodeBalancer response to HTTP requests.
 *
 * NodeBalancer configs have a list of backends, called "nodes," that they forward
 * requests between based on their configuration.
 *
 * @property int                                 $id              This config's unique ID
 * @property int                                 $port            The port this Config is for. These values must be unique across configs on a
 *                                                                single NodeBalancer (you can't have two configs for port 80, for example). While
 *                                                                some ports imply some protocols, no enforcement is done and you may configure your
 *                                                                NodeBalancer however is useful to you. For example, while port 443 is generally
 *                                                                used for HTTPS, you do not need SSL configured to have a NodeBalancer listening on
 *                                                                port 443.
 * @property string                              $protocol        The protocol this port is configured to serve.
 *                                                                * If using `http` or `tcp` protocol, `ssl_cert` and `ssl_key` are not supported.
 *                                                                * If using `https` protocol, `ssl_cert` and `ssl_key` are required.
 * @property string                              $algorithm       What algorithm this NodeBalancer should use for routing traffic to backends.
 * @property string                              $stickiness      Controls how session stickiness is handled on this port.
 *                                                                * If set to `none` connections will always be assigned a backend based on the
 *                                                                algorithm configured.
 *                                                                * If set to `table` sessions from the same remote address will be routed to the
 *                                                                same
 *                                                                backend.
 *                                                                * For HTTP or HTTPS clients, `http_cookie` allows sessions to be
 *                                                                routed to the same backend based on a cookie set by the NodeBalancer.
 * @property string                              $check           The type of check to perform against backends to ensure they are serving requests.
 *                                                                This is used to determine if backends are up or down.
 *                                                                * If `none` no check is performed.
 *                                                                * `connection` requires only a connection to the backend to succeed.
 *                                                                * `http` and `http_body` rely on the backend serving HTTP, and that
 *                                                                the response returned matches what is expected.
 * @property int                                 $check_interval  How often, in seconds, to check that backends are up and serving requests.
 * @property int                                 $check_timeout   How long, in seconds, to wait for a check attempt before considering it failed.
 * @property int                                 $check_attempts  How many times to attempt a check before considering a backend to be down.
 * @property string                              $check_path      The URL path to check on each backend. If the backend does not respond to this
 *                                                                request it is considered to be down.
 * @property string                              $check_body      This value must be present in the response body of the check in order for it to
 *                                                                pass. If this value is not present in the response body of a check request, the
 *                                                                backend is considered to be down.
 * @property bool                                $check_passive   If true, any response from this backend with a `5xx` status code will be enough
 *                                                                for it to be considered unhealthy and taken out of rotation.
 * @property string                              $cipher_suite    What ciphers to use for SSL connections served by this NodeBalancer.
 *                                                                * `legacy` is considered insecure and should only be used if necessary.
 * @property string                              $ssl_commonname  The read-only common name automatically derived from the SSL certificate assigned
 *                                                                to this NodeBalancerConfig. Please refer to this field to verify that the
 *                                                                appropriate certificate is assigned to your NodeBalancerConfig.
 * @property string                              $ssl_fingerprint The read-only fingerprint automatically derived from the SSL certificate assigned
 *                                                                to this NodeBalancerConfig. Please refer to this field to verify that the
 *                                                                appropriate certificate is assigned to your NodeBalancerConfig.
 * @property null|string                         $ssl_cert        The PEM-formatted public SSL certificate (or the combined PEM-formatted SSL
 *                                                                certificate and Certificate Authority chain) that should be served on this
 *                                                                NodeBalancerConfig's port.
 *                                                                The contents of this field will not be shown in any responses that display
 *                                                                the NodeBalancerConfig. Instead, `<REDACTED>` will be printed where the field
 *                                                                appears.
 *                                                                The read-only `ssl_commonname` and `ssl_fingerprint` fields in a
 *                                                                NodeBalancerConfig
 *                                                                response are automatically derived from your certificate. Please refer to these
 *                                                                fields to
 *                                                                verify that the appropriate certificate was assigned to your NodeBalancerConfig.
 * @property null|string                         $ssl_key         The PEM-formatted private key for the SSL certificate set in the `ssl_cert` field.
 *                                                                The contents of this field will not be shown in any responses that display
 *                                                                the NodeBalancerConfig. Instead, `<REDACTED>` will be printed where the field
 *                                                                appears.
 *                                                                The read-only `ssl_commonname` and `ssl_fingerprint` fields in a
 *                                                                NodeBalancerConfig
 *                                                                response are automatically derived from your certificate. Please refer to these
 *                                                                fields to
 *                                                                verify that the appropriate certificate was assigned to your NodeBalancerConfig.
 * @property NodesStatus                         $nodes_status    A structure containing information about the health of the backends for this port.
 *                                                                This information is updated periodically as checks are performed against backends.
 * @property string                              $proxy_protocol  ProxyProtocol is a TCP extension that sends initial TCP connection information
 *                                                                such as source/destination IPs and ports to backend devices. This information
 *                                                                would be lost otherwise. Backend devices must be configured to work with
 *                                                                ProxyProtocol if enabled.
 *                                                                * If ommited, or set to `none`, the NodeBalancer doesn't send any auxilary data
 *                                                                over TCP connections. This is the default.
 *                                                                * If set to `v1`, the human-readable header format (Version 1) is used.
 *                                                                * If set to `v2`, the binary header format (Version 2) is used.
 * @property int                                 $nodebalancer_id The ID for the NodeBalancer this config belongs to.
 * @property NodeBalancerNodeRepositoryInterface $nodes           NodeBalancer nodes.
 */
class NodeBalancerConfig extends Entity
{
    // Available fields.
    public const FIELD_ID              = 'id';
    public const FIELD_PORT            = 'port';
    public const FIELD_PROTOCOL        = 'protocol';
    public const FIELD_ALGORITHM       = 'algorithm';
    public const FIELD_STICKINESS      = 'stickiness';
    public const FIELD_CHECK           = 'check';
    public const FIELD_CHECK_INTERVAL  = 'check_interval';
    public const FIELD_CHECK_TIMEOUT   = 'check_timeout';
    public const FIELD_CHECK_ATTEMPTS  = 'check_attempts';
    public const FIELD_CHECK_PATH      = 'check_path';
    public const FIELD_CHECK_BODY      = 'check_body';
    public const FIELD_CHECK_PASSIVE   = 'check_passive';
    public const FIELD_CIPHER_SUITE    = 'cipher_suite';
    public const FIELD_SSL_COMMONNAME  = 'ssl_commonname';
    public const FIELD_SSL_FINGERPRINT = 'ssl_fingerprint';
    public const FIELD_SSL_CERT        = 'ssl_cert';
    public const FIELD_SSL_KEY         = 'ssl_key';
    public const FIELD_NODES_STATUS    = 'nodes_status';
    public const FIELD_PROXY_PROTOCOL  = 'proxy_protocol';
    public const FIELD_NODEBALANCER_ID = 'nodebalancer_id';

    // Extra fields for POST/PUT requests.
    public const FIELD_NODES = 'nodes';

    // `FIELD_PROTOCOL` values.
    public const PROTOCOL_HTTP  = 'http';
    public const PROTOCOL_HTTPS = 'https';
    public const PROTOCOL_TCP   = 'tcp';

    // `FIELD_ALGORITHM` values.
    public const ALGORITHM_ROUNDROBIN = 'roundrobin';
    public const ALGORITHM_LEASTCONN  = 'leastconn';
    public const ALGORITHM_SOURCE     = 'source';

    // `FIELD_STICKINESS` values.
    public const STICKINESS_NONE        = 'none';
    public const STICKINESS_TABLE       = 'table';
    public const STICKINESS_HTTP_COOKIE = 'http_cookie';

    // `FIELD_CHECK` values.
    public const CHECK_NONE       = 'none';
    public const CHECK_CONNECTION = 'connection';
    public const CHECK_HTTP       = 'http';
    public const CHECK_HTTP_BODY  = 'http_body';

    // `FIELD_CIPHER_SUITE` values.
    public const CIPHER_SUITE_RECOMMENDED = 'recommended';
    public const CIPHER_SUITE_LEGACY      = 'legacy';

    // `FIELD_PROXY_PROTOCOL` values.
    public const PROXY_PROTOCOL_NONE = 'none';
    public const PROXY_PROTOCOL_V1   = 'v1';
    public const PROXY_PROTOCOL_V2   = 'v2';

    /**
     * @codeCoverageIgnore This method was autogenerated.
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            self::FIELD_NODES_STATUS => new NodesStatus($this->client, $this->data[$name]),
            self::FIELD_NODES        => new NodeBalancerNodeRepository($this->client, $this->nodebalancer_id, $this->id),
            default                  => parent::__get($name),
        };
    }
}
