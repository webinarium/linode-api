<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2018 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Linode\Exception;

/**
 * An object for describing a single error that occurred during the processing of a request.
 */
class Error
{
    /**
     * Error constructor.
     */
    public function __construct(protected string $reason, protected ?string $field)
    {
    }

    /**
     * What happened to cause this error. In most cases, this can be fixed immediately by
     * changing the data you sent in the request, but in some cases you will be instructed to
     * open a Support Ticket or perform some other action before you can complete the request
     * successfully.
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * The field in the request that caused this error. This may be a path, separated by
     * periods in the case of nested fields. In some cases this may come back as "null" if the
     * error is not specific to any single element of the request.
     */
    public function getField(): ?string
    {
        return $this->field;
    }
}
