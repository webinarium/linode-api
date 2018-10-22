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

use Psr\Http\Message\ResponseInterface;

/**
 * An exception raised on every failed request and contains list of errors.
 *
 * Within each error object, the `field` parameter will be included if the error pertains to
 * a specific field in the JSON you've submitted. This will be omitted if there is no relevant
 * field. The `reason` is a human-readable explanation of the error, and will always be included.
 *
 * The exception code is an HTTP status code of the request. The exception message is a `reason`
 * of the first error object.
 */
class LinodeException extends \Exception
{
    /** @var Error[] */
    protected $errors = [];

    /**
     * LinodeException constructor.
     *
     * @param ResponseInterface $response Failed response.
     * @param null|\Throwable   $previous The previous throwable used for the exception chaining.
     */
    public function __construct(ResponseInterface $response, \Throwable $previous = null)
    {
        $code = $response->getStatusCode();
        $json = json_decode($response->getBody()->getContents(), true);

        $errors = $json['errors'] ?? [['reason' => 'Unknown error']];

        foreach ($errors as $error) {
            $this->errors[] = new Error($error['reason'], $error['field'] ?? null);
        }

        parent::__construct($this->errors[0]->getReason(), $code, $previous);
    }

    /**
     * Returns list of errors associated with the exception.
     *
     * @return Error[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
