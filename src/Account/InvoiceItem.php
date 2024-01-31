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

use Linode\Entity;

/**
 * An InvoiceItem object.
 *
 * @property string $label     The Invoice Item's display label.
 * @property string $from      The date the Invoice Item started, based on month.
 * @property string $to        The date the Invoice Item ended, based on month.
 * @property float  $amount    The price, in US dollars, of the Invoice Item. Equal to the unit price multiplied
 *                             by quantity.
 * @property float  $tax       The amount of tax levied on this Item in US Dollars.
 * @property float  $total     The price of this Item after taxes in US Dollars.
 * @property int    $quantity  The quantity of this Item for the specified Invoice.
 * @property float  $unitprice The monthly service fee in US Dollars for this Item.
 * @property string $type      The type of service, ether `hourly` or `misc`.
 */
class InvoiceItem extends Entity
{
    // Available fields.
    public const FIELD_LABEL     = 'label';
    public const FIELD_FROM      = 'from';
    public const FIELD_TO        = 'to';
    public const FIELD_AMOUNT    = 'amount';
    public const FIELD_TAX       = 'tax';
    public const FIELD_TOTAL     = 'total';
    public const FIELD_QUANTITY  = 'quantity';
    public const FIELD_UNITPRICE = 'unitprice';
    public const FIELD_TYPE      = 'type';

    // `FIELD_TYPE` values.
    public const TYPE_HOURLY = 'hourly';
    public const TYPE_MISC   = 'misc';
}
