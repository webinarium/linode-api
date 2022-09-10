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

/**
 * A StackScript enables you to quickly deploy a fully-configured application in an automated manner.
 *
 * @property int                      $id                  The unique ID of this StackScript.
 * @property string                   $username            The User who created the StackScript.
 * @property string                   $label               The StackScript's label is for display purposes only.
 * @property string[]                 $images              An array of Image IDs representing the Images that this StackScript
 *                                                         is compatible for deploying with.
 * @property bool                     $is_public           This determines whether other users can use your StackScript.
 *                                                         Once a StackScript is made public, it cannot be made private.
 * @property string                   $created             The date this StackScript was created.
 * @property string                   $updated             The date this StackScript was last updated.
 * @property string                   $user_gravatar_id    The Gravatar ID for the User who created the StackScript.
 * @property string                   $description         A description for the StackScript.
 * @property int                      $deployments_total   The total number of times this StackScript has been deployed.
 * @property int                      $deployments_active  Count of currently active, deployed Linodes created from
 *                                                         this StackScript.
 * @property string                   $rev_note            This field allows you to add notes for the set of revisions made to
 *                                                         this StackScript.
 * @property string                   $script              The script to execute when provisioning a new Linode with this StackScript.
 * @property array|UserDefinedField[] $user_defined_fields This is a list of fields defined with a special syntax inside this StackScript
 *                                                         that allow for supplying customized parameters during deployment.
 */
class StackScript extends Entity
{
    // Available fields.
    public const FIELD_ID                  = 'id';
    public const FIELD_USERNAME            = 'username';
    public const FIELD_LABEL               = 'label';
    public const FIELD_IMAGES              = 'images';
    public const FIELD_IS_PUBLIC           = 'is_public';
    public const FIELD_CREATED             = 'created';
    public const FIELD_UPDATED             = 'updated';
    public const FIELD_USER_GRAVATAR_ID    = 'user_gravatar_id';
    public const FIELD_DESCRIPTION         = 'description';
    public const FIELD_DEPLOYMENTS_TOTAL   = 'deployments_total';
    public const FIELD_DEPLOYMENTS_ACTIVE  = 'deployments_active';
    public const FIELD_REV_NOTE            = 'rev_note';
    public const FIELD_SCRIPT              = 'script';
    public const FIELD_USER_DEFINED_FIELDS = 'user_defined_fields';

    /**
     * {@inheritdoc}
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            self::FIELD_USER_DEFINED_FIELDS => array_map(fn ($data) => new UserDefinedField($this->client, $data), $this->data[self::FIELD_USER_DEFINED_FIELDS]),
            default                         => parent::__get($name),
        };
    }
}
