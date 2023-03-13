# platform.secretsManager.googleSecretsManager

![Packagist Version](https://img.shields.io/packagist/v/codenamephp/platform.secretsManager.googleSecretsManager)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/codenamephp/platform.secretsManager.googleSecretsManager)
![Lines of code](https://img.shields.io/tokei/lines/github/codenamephp/platform.secretsManager.googleSecretsManager)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/codenamephp/platform.secretsManager.googleSecretsManager)
![CI](https://github.com/codenamephp/platform.secretsManager.googleSecretsManager/workflows/CI/badge.svg)
![Packagist Downloads](https://img.shields.io/packagist/dt/codenamephp/platform.secretsManager.googleSecretsManager)
![GitHub](https://img.shields.io/github/license/codenamephp/platform.secretsManager.googleSecretsManager)

## Installation

Easiest way is via composer. Just run `composer require codenamephp/platform.secretsManager.googleSecretsManager` in your cli which should install the latest
version for you.

## Usage

Just create a client using the factory and start fetching secrets. Note that you need to have a google authentication setup. Since we just
use the google client by default the instructions from Google apply: https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md

You can also pass the path to the credentials file to the factory if you so prefer. Whatever string you pass to the factory is just
passed on to the google client so it can do its thing. So check the google doc for details.

```php

use de\codenamephp\platform\secretsManager\googleSecretsManager\Client\Factory\WithGoogleSecretsManagerClient;

$client = (new WithGoogleSecretsManagerClient())->build();
$client = (new WithGoogleSecretsManagerClient())->build('/path/to/credentials.json');

// payload is fetched as string
$payload = $client->fetchPayload(new \de\codenamephp\platform\secretsManager\base\Secret\Sealed('mySecret', 'myProject')); //fetch the latest version
$payload = $client->fetchPayload(new \de\codenamephp\platform\secretsManager\base\Secret\Sealed('mySecret', 'myProject', '3')); //fetch a specific version
```