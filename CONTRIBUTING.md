# Contributing

Contributions are **welcome** and will be fully **credited**.
Contributions are accepted via Pull Requests on [Github](https://github.com/webinarium/linode-api).

## Pull Requests

- **Add tests** - Your patch won't be accepted if your changes are not covered with tests.
- **Document any change in behaviour** - Make sure the README and any other relevant documentation are kept up-to-date.
- **Create topic branches** - Don't ask us to pull from your master branch.
- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.
- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please squash them before submitting.
- **Ensure tests pass** - Please run the tests (see below) before submitting your pull request, and make sure they pass. A patch won't be accepted until all tests pass.
- **Ensure no coding standards violations** - Please run PHP CS Fixer (see below) before submitting your pull request.

## Running Tests

``` bash
./bin/phpunit --coverage-text
```

## Running PHP CS Fixer

``` bash
./bin/php-cs-fixer fix
```

**Happy coding**!
