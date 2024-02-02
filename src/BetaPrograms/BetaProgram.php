<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\BetaPrograms;

use Linode\Entity;

/**
 * An object representing Beta Program information.
 *
 * @property string      $id              The unique identifier of the Beta Program.
 * @property string      $label           The name of the Beta Program.
 * @property null|string $description     Additional details regarding the Beta Program.
 * @property bool        $greenlight_only Whether the Beta Program requires Green Light participation for enrollment.
 * @property string      $started         The start date-time of the Beta Program.
 * @property null|string $ended           The date-time that the Beta Program ended.
 *                                        `null` indicates that the Beta Program is ongoing.
 * @property null|string $more_info       Additional source of information for the Beta Program.
 */
class BetaProgram extends Entity
{
    // Available fields.
    public const FIELD_ID              = 'id';
    public const FIELD_LABEL           = 'label';
    public const FIELD_DESCRIPTION     = 'description';
    public const FIELD_GREENLIGHT_ONLY = 'greenlight_only';
    public const FIELD_STARTED         = 'started';
    public const FIELD_ENDED           = 'ended';
    public const FIELD_MORE_INFO       = 'more_info';
}
