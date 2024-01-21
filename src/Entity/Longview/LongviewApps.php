<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Entity\Longview;

use Linode\Entity\Entity;

/**
 * @property bool $apache If `true`, the Apache Longview Client module is monitoring Apache on your server.
 * @property bool $nginx  If `true`, the Nginx Longview Client module is monitoring Nginx on your server.
 * @property bool $mysql  If `true`, the MySQL Longview Client modules is monitoring MySQL on your server.
 */
class LongviewApps extends Entity
{
}
