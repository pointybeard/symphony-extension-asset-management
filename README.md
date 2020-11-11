# Symphony CMS: Extension Asset Management

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pointybeard/symphony-extension-asset-management/badges/quality-score.png?b=master)][ext-scrutinizer]
[![Code Coverage](https://scrutinizer-ci.com/g/pointybeard/symphony-extension-asset-management/badges/coverage.png?b=master)][ext-scrutinizer]
[![Build Status](https://scrutinizer-ci.com/g/pointybeard/symphony-extension-asset-management/badges/build.png?b=master)][ext-scrutinizer]

Provides classes and interfaces to help manage custom Events, Datasources, Commands, Fields, and Content when enabling, disabling, installing, and uninstalling an Extension.

-   [Installation](#installation)
-   [Basic Usage](#basic-usage)
-   [About](#about)
    -   [Requirements](#dependencies)
    -   [Dependencies](#dependencies)
-   [Documentation](#documentation)
-   [Support](#support)
-   [Contributing](#contributing)
-   [License](#license)

## Installation

This libary can be used standalone or as part of a [Symphony CMS][ext-Symphony] installation (including Extension) via composer.

### Standalone

Use the following commands to clone this repository and install required packages

```bash
$ git clone https://github.com/pointybeard/symphony-extension-asset-management.git
$ composer update -vv --profile -d ./symphony-extension-asset-management
```

### Via Composer

To install via [Composer](http://getcomposer.org/), use 

```bash
$ composer require pointybeard/symphony-extension-asset-management
```

## Basic Usage

@todo

## About

### Requirements

- This library works with PHP 7.4 or above.

### Dependencies

Section Builder depends on the following Composer libraries:

-   [pointybeard/symphony-pdo][dep-symphony-pdo]
-   [pointybeard/helpers][dep-helpers]

As well as the following dev libraries

-   [squizlabs/php_codesniffer][dep-php_codesniffer]
-   [friendsofphp/php-cs-fixer][dep-friendsofphp/php-cs-fixer]
-   [damianopetrungaro/php-commitizen][dep-php-commitizen]
-   [php-parallel-lint/php-parallel-lint][dep-php-parallel-lint]

## Documentation

Read the [full documentation here][ext-docs].

## Support

If you believe you have found a bug, please report it using the [GitHub issue tracker][ext-issues],
or better yet, fork the library and submit a pull request.

## Contributing

We encourage you to contribute to this project. Please check out the [Contributing to this project][doc-CONTRIBUTING] documentation for guidelines about how to get involved.

## Author
-   Alannah Kearney - http://github.com/pointybeard
-   See also the list of [contributors][ext-contributor] who participated in this project

## License
"Symphony CMS: Extension Asset Management" is released under the MIT License. See [LICENCE][doc-LICENCE] for details.

[doc-CONTRIBUTING]: https://github.com/pointybeard/symphony-extension-asset-management/blob/master/CONTRIBUTING.md
[doc-LICENCE]: http://www.opensource.org/licenses/MIT
[dep-helpers]: https://github.com/pointybeard/helpers
[dep-symphony-pdo]: https://github.com/pointybeard/symphony-pdo
[dep-property-bag]: https://github.com/pointybeard/property-bag
[dep-php_codesniffer]: https://github.com/squizlabs/php_codesniffer
[dep-friendsofphp/php-cs-fixer]: https://github.com/friendsofphp/php-cs-fixer
[dep-php-commitizen]: https://github.com/damianopetrungaro/php-commitizen
[dep-php-parallel-lint]: https://github.com/php-parallel-lint/php-parallel-lint
[ext-issues]: https://github.com/pointybeard/symphony-extension-asset-management/issues
[ext-Symphony]: http://getsymphony.com
[ext-contributor]: https://github.com/pointybeard/symphony-extension-asset-management/contributors
[ext-docs]: https://github.com/pointybeard/symphony-extension-asset-management/blob/master/.docs/toc.md
[ext-scrutinizer]: https://scrutinizer-ci.com/g/pointybeard/symphony-extension-asset-management/?branch=master
