<?php declare(strict_types=1);

namespace de\codenamephp\platform\secretsManager\googleSecretsManager\Client\Factory;

use de\codenamephp\platform\secretsManager\base\Client\ClientInterface;
use de\codenamephp\platform\secretsManager\base\Secret\Payload\Factory\FactoryInterface;
use de\codenamephp\platform\secretsManager\base\Secret\Payload\Factory\Sealed;
use de\codenamephp\platform\secretsManager\googleSecretsManager\Version\VersionInterface;
use de\codenamephp\platform\secretsManager\googleSecretsManager\Version\WithSecretManagerServiceClient;
use Google\ApiCore\ValidationException;

/**
 * Interface to create a client that can fetch secrets from google secrets manager on the fly using a configuration
 *
 * @psalm-api
 */
interface ClientFactoryInterface {

  /**
   * Creates a client instance with the given defaults. Implementations MUST make sure the credentials are handled correctly and that automatic lookup of
   * the google credentials is supported.
   *
   * @param string|null $credentials The credentials as json string, a path to a json file or empty so the google client can find the credentials on its own
   * @param VersionInterface $versionFactory Factory to create the version string to get the secret with
   * @param FactoryInterface $payloadFactory Factory to create the payload from the secret data
   * @return ClientInterface
   * @throws ValidationException when the credentials are invalid
   */
  public function build(
    string $credentials = null,
    VersionInterface $versionFactory = new WithSecretManagerServiceClient(),
    FactoryInterface $payloadFactory = new Sealed()
  ) : ClientInterface;
}