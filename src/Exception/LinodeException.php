<?php

// ---------------------------------------------------------------------
//
//  Copyright (C) 2018-2024 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <https://opensource.org/licenses/MIT>.
//
// ---------------------------------------------------------------------

namespace Linode\Exception;

use Psr\Http\Message\ResponseInterface;

/**
 * This type of exception is raised on every failed request and contains list of errors.
 *
 * Within each error object, the `field` parameter will be included if the error pertains to
 * a specific field in the JSON you’ve submitted. This will be omitted if there is no relevant
 * field. The `reason` is a human-readable explanation of the error, and will always be included.
 *
 * The exception code is an HTTP status code of the request. The exception message is a `reason`
 * of the first error object.
 */
class LinodeException extends \Exception
{
    /**
     * @var Error[] List of errors associated with the exception.
     */
    protected array $errors;

    /**
     * @param ResponseInterface $response Failed response.
     * @param null|\Throwable   $previous The previous throwable used for the exception chaining.
     */
    public function __construct(ResponseInterface $response, \Throwable $previous = null)
    {
        $code = $response->getStatusCode();
        $json = json_decode($response->getBody()->getContents() ?? '', true);

        $errors = $json['errors'] ?? [['reason' => 'Unknown error']];

        $this->errors = array_map(static fn ($error) => new Error($error['reason'], $error['field'] ?? null), $errors);

        parent::__construct($this->errors[0]->reason, $code, $previous);
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
