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

use Linode\Account\Repository\InvoiceItemRepository;
use Linode\Entity;

/**
 * Account Invoice object.
 *
 * @property int                            $id       The Invoice's unique ID.
 * @property string                         $date     When this Invoice was generated.
 * @property string                         $label    The Invoice's display label.
 * @property float                          $subtotal The amount of the Invoice before taxes in US Dollars.
 * @property float                          $tax      The amount of tax levied on the Invoice in US Dollars.
 * @property float                          $total    The amount of the Invoice after taxes in US Dollars.
 * @property InvoiceItemRepositoryInterface $items    Invoice items.
 */
class Invoice extends Entity
{
    // Available fields.
    public const FIELD_ID       = 'id';
    public const FIELD_DATE     = 'date';
    public const FIELD_LABEL    = 'label';
    public const FIELD_SUBTOTAL = 'subtotal';
    public const FIELD_TAX      = 'tax';
    public const FIELD_TOTAL    = 'total';

    /**
     * @codeCoverageIgnore This method was autogenerated.
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'items' => new InvoiceItemRepository($this->client, $this->id),
            default => parent::__get($name),
        };
    }
}