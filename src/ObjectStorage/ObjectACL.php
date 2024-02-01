<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\ObjectStorage;

use Linode\Entity;

/**
 * The Object's canned ACL and policy.
 *
 * @property string $acl     The Access Control Level of the bucket, as a canned ACL string. For more
 *                           fine-grained control of ACLs, use the S3 API directly.
 * @property string $acl_xml The full XML of the object's ACL policy.
 */
class ObjectACL extends Entity
{
    // Available fields.
    public const FIELD_ACL     = 'acl';
    public const FIELD_ACL_XML = 'acl_xml';

    // `FIELD_ACL` values.
    public const ACL_PRIVATE            = 'private';
    public const ACL_PUBLIC_READ        = 'public-read';
    public const ACL_AUTHENTICATED_READ = 'authenticated-read';
    public const ACL_PUBLIC_READ_WRITE  = 'public-read-write';
    public const ACL_CUSTOM             = 'custom';
}
