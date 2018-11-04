<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Entity\NodeBalancers;

use Linode\Entity\Entity;
use Linode\Internal\NodeBalancers\NodeBalancerNodeRepository;

/**
 * A NodeBalancer config represents the configuration of this NodeBalancer
 * on a single port. For example, a NodeBalancer Config on port 80 would
 * typically represent how this NodeBalancer response to HTTP requests.
 *
 * NodeBalancer configs have a list of backends, called "nodes," that they
 * forward requests between based on their configuration.
 *
 * @property int         $id              This config's unique ID.
 * @property int         $port            The port this Config is for. These values must be unique across configs
 *                                        on a single NodeBalancer (you can't have two configs for port 80, for
 *                                        example). While some ports imply some protocols, no enforcement is done
 *                                        and you may configure your NodeBalancer however is useful to you. For
 *                                        example, while port 443 is generally used for HTTPS, you do not need
 *                                        SSL configured to have a NodeBalancer listening on port 443.
 * @property string      $protocol        The protocol this port is configured to serve. If this is set to `https`
 *                                        you must include an `ssl_cert` and an `ssl_key`.
 * @property string      $algorithm       What algorithm this NodeBalancer should use for routing traffic to backends.
 * @property string      $stickiness      Controls how session stickiness is handled on this port.
 * @property string      $check           The type of check to perform against backends to ensure they are serving
 *                                        requests. This is used to determine if backends are up or down.
 * @property int         $check_interval  How often, in seconds, to check that backends are up and serving requests.
 * @property int         $check_timeout   How long, in seconds, to wait for a check attempt before considering it failed.
 * @property int         $check_attempts  How many times to attempt a check before considering a backend to be down.
 * @property string      $check_path      The URL path to check on each backend. If the backend does not respond
 *                                        to this request it is considered to be down.
 * @property string      $check_body      This value must be present in the response body of the check in order for
 *                                        it to pass. If this value is not present in the response body of a check
 *                                        request, the backend is considered to be down.
 * @property bool        $check_passive   If true, any response from this backend with a `5xx` status code will be
 *                                        enough for it to be considered unhealthy and taken out of rotation.
 * @property string      $cipher_suite    What ciphers to use for SSL connections served by this NodeBalancer.
 * @property string      $ssl_commonname  The common name for the SSL certification this port is serving
 *                                        if this port is not configured to use SSL.
 * @property string      $ssl_fingerprint The fingerprint for the SSL certification this port is serving
 *                                        if this port is not configured to use SSL.
 * @property string      $ssl_cert        The certificate this port is serving. This is not returned. If set,
 *                                        this field will come back as "<REDACTED>".
 * @property string      $ssl_key         The private key corresponding to this port's certificate. This is not
 *                                        returned. If set, this field will come back as "<REDACTED>".
 * @property int         $nodebalancer_id The ID for the NodeBalancer this config belongs to.
 * @property NodesStatus $nodes_status    A structure containing information about the health of the backends
 *                                        for this port. This information is updated periodically as checks
 *                                        are performed against backends.
 * @property \Linode\Repository\NodeBalancers\NodeBalancerNodeRepositoryInterface $nodes Nodes of the config.
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

    // Extra field for create/update operations.
    public const FIELD_NODES = 'nodes';

    // Protocols.
    public const PROTOCOL_HTTP  = 'http';
    public const PROTOCOL_HTTPS = 'https';
    public const PROTOCOL_TCP   = 'tcp';

    // Rotation algorithms.
    public const ALGORITHM_ROUNDROBIN = 'roundrobin';
    public const ALGORITHM_LEASTCONN  = 'leastconn';
    public const ALGORITHM_SOURCE     = 'source';

    // Session stickiness.
    public const STICKINESS_NONE        = 'none';
    public const STICKINESS_TABLE       = 'table';
    public const STICKINESS_HTTP_COOKIE = 'http_cookie';

    // Check types.
    public const CHECK_NONE       = 'none';
    public const CHECK_CONNECTION = 'connection';
    public const CHECK_HTTP       = 'http';
    public const CHECK_HTTP_BODY  = 'http_body';

    // Cipher suites.
    public const CIPHER_RECOMMENDED = 'recommended';
    public const CIPHER_LEGACY      = 'legacy';

    /**
     * {@inheritdoc}
     */
    public function __get(string $name)
    {
        if ($name === 'nodes_status') {
            return new NodesStatus($this->client, $this->data[$name]);
        }

        if ($name === 'nodes') {
            return new NodeBalancerNodeRepository($this->client, $this->nodebalancer_id, $this->id);
        }

        return parent::__get($name);
    }
}
