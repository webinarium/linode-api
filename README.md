# Linode API Client Library

[![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://secure.php.net/migration81)
[![Latest Stable Version](https://poser.pugx.org/webinarium/linode-api/v/stable)](https://packagist.org/packages/webinarium/linode-api)
[![Build Status](https://travis-ci.com/webinarium/linode-api.svg?branch=master)](https://travis-ci.com/github/webinarium/linode-api)
[![Code Coverage](https://scrutinizer-ci.com/g/webinarium/linode-api/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/webinarium/linode-api/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/webinarium/linode-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/webinarium/linode-api/?branch=master)

This package provides a PHP client library for [Linode API](https://www.linode.com/docs/api/).
The library is up-to-date with API [4.85.0](https://www.linode.com/docs/products/tools/api/release-notes/) released on 2021-03-01.

## Requirements

PHP needs to be a minimum version of PHP 8.1.

## Installation

The recommended way to install is via Composer:

```bash
composer require webinarium/linode-api
```

## Usage

<details>
<summary>Basic Usage</summary>
<br>

Access to all API endpoints goes through an instance of `LinodeClient` class, which you have to create first:

```php
use Linode\LinodeClient;

$client = new LinodeClient();

$regions = $client->regions->findAll();
```

The example above creates an unauthenticated client which is enough to access few public endpoints like _regions_ or _kernels_.
To access your private data you need to provide `LinodeClient` with your access token:

```php
use Linode\LinodeClient;

$client = new LinodeClient('03d084436a6c91fbafd5c4b20c82e5056a2e9ce1635920c30dc8d81dc7a6665c');

$linodes = $client->linodes->findAll();
```

Access token can be a manually generated _Personal Access Token_ or a retrieved one from OAuth workflow.
You can use [oauth2-linode](https://github.com/webinarium/oauth2-linode) library to authenticate in Linode using OAuth.
</details>

<details>
<summary>Errors</summary>
<br>

Any API request to Linode can fail.
In this case Linode API returns list of errors, each consists of `reason` (a human-readable error message, always included) and `field` (a specific field in the submitted JSON, `null` when not applicable).

The library throws a `LinodeException` each time a request is failed.
The message of the exception is always a message of the first error in the errors list.
You can also get all errors from the exception using its `getErrors` function.

```php
use Linode\Exception\LinodeException;
use Linode\LinodeClient;
use Linode\LinodeInstances\Linode;

$client = new LinodeClient('03d084436a6c91fbafd5c4b20c82e5056a2e9ce1635920c30dc8d81dc7a6665c');

try {
    $linode = $client->linodes->create([
        Linode::FIELD_TYPE   => 'g6-standard-2',
        Linode::FIELD_REGION => 'us-east',
    ]);
}
catch (LinodeException $exception) {
    // This is the same as the reason of the very first error below.
    $message = $exception->getMessage();

    foreach ($exception->getErrors() as $error) {
        echo $error->field;
        echo $error->reason;
    }
}
```
</details>

<details>
<summary>Entities and Repositories</summary>
<br>

The library provides an _entity_ class for every object returned by Linode API - _linodes_, _images_, _nodebalancers_, whatever.
All entities are read-only, the data are accessible through properties.

Also, there is a dedicated repository for entity of each type. Most of the repositories are available through the `LinodeClient` class:

```php
use Linode\LinodeClient;
use Linode\LinodeInstances\Linode;
use Linode\LinodeInstances\LinodeRepositoryInterface;

$client = new LinodeClient('03d084436a6c91fbafd5c4b20c82e5056a2e9ce1635920c30dc8d81dc7a6665c');

/** @var LinodeRepositoryInterface $repository */
$repository = $client->linodes;

/** @var Linode $linode */
$linode = $repository->find(123);

echo $linode->label;
echo $linode->hypervisor;
```

Some entities are nested, for example `DomainRecord` objects always belong to some `Domain` object.
A repository for such nested entities should be taken from corresponding parent entity.
The `LinodeClient` class contains repositories for root entities only.

```php
use Linode\Domains\Domain;
use Linode\Domains\DomainRecord;
use Linode\LinodeClient;

$client = new LinodeClient('03d084436a6c91fbafd5c4b20c82e5056a2e9ce1635920c30dc8d81dc7a6665c');

/** @var Domain $domain */
$domain = $client->domains->findOneBy([
    Domain::FIELD_DOMAIN => 'example.com',
]);

/** @var DomainRecord[] $records */
$records = $domain->records->findAll();

foreach ($records as $record) {
    echo $record->type;
}
```

To make it easier to find corresponding entity and repository, the library sources are structured the same way as the original API documentation.
</details>

<details>
<summary>Repositories and Collections</summary>
<br>

Each repository implements `Linode\RepositoryInterface` and provides two following functions.

The `find` function searches for an entity by its ID:

```php
use Linode\LinodeClient;
use Linode\LinodeInstances\Linode;

$client = new LinodeClient('03d084436a6c91fbafd5c4b20c82e5056a2e9ce1635920c30dc8d81dc7a6665c');

/** @var Linode $linode */
$linode = $client->linodes->find(123);
```

The `findAll` function returns all entities of the type as a `Linode\EntityCollection` object.
Such object implements standard `Countable` and `Iterator` interfaces:

```php
use Linode\LinodeClient;
use Linode\LinodeInstances\Linode;

$client = new LinodeClient('03d084436a6c91fbafd5c4b20c82e5056a2e9ce1635920c30dc8d81dc7a6665c');

/** @var Linode[] $linodes */
$linodes = $client->linodes->findAll();

printf('Found %d linode(s).', count($linodes));

foreach ($linodes as $linode) {
    // ...
}
```
</details>

<details>
<summary>Pagination</summary>
<br>

When you are retrieving a list of objects from Linode API, the API returns the list paginated.
To make your life easier, the library manages the pagination for you internally, so you can work with a list of entities as with a simple array.

For example, let's assume you have 270 linodes in your account and need to enumerate their labels:

```php
use Linode\LinodeClient;

$client = new LinodeClient('03d084436a6c91fbafd5c4b20c82e5056a2e9ce1635920c30dc8d81dc7a6665c');

$linodes = $client->linodes->findAll();

foreach ($linodes as $linode) {
    echo $linode->label;
}
```

When you call `findAll` function in this example, only first 100 entities are loaded (100 is a default page size in the API).
Once you reach 101st entity in your enumeration, the library makes another call for next 100 linodes, and so on.
As result, the library will make three API requests for your 270 linodes, but it's completely transparent for you.
Of course, extra requests are performed only when needed, so if you break your enumeration in the middle, remaining entities won't be requested at all.

Also, the retrieved entities are cached per collection, so it's safe to enumerate the same collection multiple times:

```php
use Linode\LinodeClient;

$client = new LinodeClient('03d084436a6c91fbafd5c4b20c82e5056a2e9ce1635920c30dc8d81dc7a6665c');

$linodes = $client->linodes->findAll();

// This will make three API requests.
foreach ($linodes as $linode) {
    echo $linode->label;
}

// This will make no API requests at all.
foreach ($linodes as $linode) {
    echo $linode->type;
}

$linodes2 = $client->linodes->findAll();

// This will make three API requests again, as this is another collection.
foreach ($linodes2 as $linode) {
    echo $linode->type;
}
```
</details>

<details>
<summary>Sorting</summary>
<br>

The Linode API supports sorting of the requested objects, which can be specified in two optional parameters of the `findAll` function:

```php
use Linode\LinodeClient;
use Linode\LinodeInstances\Linode;
use Linode\RepositoryInterface;

$client = new LinodeClient('03d084436a6c91fbafd5c4b20c82e5056a2e9ce1635920c30dc8d81dc7a6665c');

$linodes = $client->linodes->findAll(Linode::FIELD_LABEL, RepositoryInterface::SORT_DESC);
```

The first parameter is the name of the field to sort entities by.
Every entity class contains useful constants so you don't have to hardcode field names.

The second parameter is a sorting direction and equals to `Linode\RepositoryInterface::SORT_ASC` if omitted.
</details>

<details>
<summary>Filtering (simple queries)</summary>
<br>

The Linode API supports filtering of the requested objects, which is addressed by the same `Linode\RepositoryInterface` interface via `findBy`, `findOneBy`, and `query` functions.

The `findBy` function accepts array of criterias as the first parameter.
All the criterias are joined via logical `AND` operation.

```php
use Linode\LinodeClient;
use Linode\LinodeInstances\Linode;

$client = new LinodeClient('03d084436a6c91fbafd5c4b20c82e5056a2e9ce1635920c30dc8d81dc7a6665c');

$linodes = $client->linodes->findBy([
    Linode::FIELD_REGION => 'us-west',
    Linode::FIELD_TAGS   => 'app-server',
]);
```

Second and third parameters of the function are for sorting and work exactly as the corresponding parameters of the `findAll` function.

The `findBy` function returns a collection, which can be empty if nothing is found.
When you need to retrieve a single object using filters, you may use the `findOneBy` function, which accepts an array of criterias as the only parameter.

```php
use Linode\LinodeClient;
use Linode\LinodeInstances\Linode;

$client = new LinodeClient('03d084436a6c91fbafd5c4b20c82e5056a2e9ce1635920c30dc8d81dc7a6665c');

$linode = $client->linodes->findOneBy([
    Linode::FIELD_LABEL => 'mysql-server-02',
]);
```

If nothing is found, the function returns `null`.
If more than one entity is found, the function raises a `LinodeException`.
</details>

<details>
<summary>Filtering (complex queries)</summary>
<br>

The last of functions mentioned above - `query` - lets you make complex requests using query language of the Linode API.

The API query language assumes you convert your conditions to JSON, which actually makes them hard to read, debug, and maintain.
For example, current API documentation suggests the following JSON object to get all Linode Types which are either _standard_ or _highmem_ class, or have between 12 and 20 vcpus:

```json
{
  "+or": [
    {
      "+or": [
        {
          "class": "standard"
        },
        {
          "class": "highmem"
        }
      ]
    },
    {
      "+and": [
        {
          "vcpus": {
            "+gte": 12
          }
        },
        {
          "vcpus": {
            "+lte": 20
          }
        }
      ]
    }
  ]
}
```

The `query` function lets you write your conditions using more human-readable expressions which are passed as a string to the first parameter.
The above example can be implemented as following:

```php
use Linode\LinodeClient;

$client = new LinodeClient();

$types = $client->linodeTypes->query('(class == "standard" or class == "highmem") or (vcpus >= 12 and vcpus <= 20)');

foreach ($types as $type) {
    echo $type->class;
    echo $type->vcpus;
}
```

All Linode API operators are supported by the library using following lexems:

<table>
<tr><td>==</td><td>equals</td></tr>
<tr><td>!=</td><td>doesn't equal</td></tr>
<tr><td><</td><td>is greater than</td></tr>
<tr><td><=</td><td>is less than or equal to</td></tr>
<tr><td>></td><td>is greater than</td></tr>
<tr><td>>=</td><td>is greater than or equal to</td></tr>
<tr><td>~</td><td>contains a substring</td></tr>
</table>

In case of syntax error in your expression, the library will raise a `LinodeException` with a list of all found errors.

If you need to create your expression using some variables, you may use parameterized expression, as in the example below:

```php
use Linode\LinodeClient;

$client = new LinodeClient();

$parameters = [
    'class1' => 'standard',
    'class2' => 'highmem',
    'min'    => 12,
    'max'    => 20,
];

$types = $client->linodeTypes->query('(class == :class1 or class == :class2) or (vcpus >= :min and vcpus <= :max)', $parameters);
```

Each parameter starts with a colon, and the whole set of parameters is provided once as an array.

And, just like `findAll` and `findBy` functions, the `query` function has two last optional parameters for sorting:

```php
use Linode\LinodeClient;
use Linode\LinodeTypes\LinodeType;
use Linode\RepositoryInterface;

$client = new LinodeClient();

$parameters = [
    'class1' => 'standard',
    'class2' => 'highmem',
    'min'    => 12,
    'max'    => 20,
];

$types = $client->linodeTypes->query(
    '(class == :class1 or class == :class2) or (vcpus >= :min and vcpus <= :max)',
    $parameters,
    LinodeType::FIELD_MEMORY,
    RepositoryInterface::SORT_DESC);
```
</details>

## Development

```bash
./bin/php-cs-fixer fix
XDEBUG_MODE=coverage ./bin/phpunit --coverage-text
```

## Contributing

Please see [CONTRIBUTING](https://github.com/webinarium/linode-api/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Artem Rodygin](https://github.com/webinarium)

## License

The MIT License (MIT). Please see [License File](https://github.com/webinarium/linode-api/blob/master/LICENSE) for more information.
