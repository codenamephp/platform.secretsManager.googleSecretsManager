<?php declare(strict_types=1);

namespace de\codenamephp\platform\secretsManager\googleSecretsManager\Client\Factory;

use de\codenamephp\platform\secretsManager\base\Client\ClientInterface;
use de\codenamephp\platform\secretsManager\base\Secret\Payload\Factory\FactoryInterface;
use de\codenamephp\platform\secretsManager\base\Secret\Payload\Factory\Sealed;
use de\codenamephp\platform\secretsManager\googleSecretsManager\Version\VersionInterface;
use de\codenamephp\platform\secretsManager\googleSecretsManager\Version\WithSecretManagerServiceClient;
use Google\Cloud\SecretManager\V1\Gapic\SecretManagerServiceGapicClient;

/**
 * Creates a WithGoogleSecretsManagerClient instance with the given defaults. Also takes care of the credentials that are filtered. So if the credentials are empty
 * the google client will do its thing and try to find the credentials on its own
 *
 * @psalm-api
 */
final class WithGoogleSecretsManagerClient implements ClientFactoryInterface {

  /**
   * @inheritdoc 
   * @infection-ignore-all
   */
  public function build(string $credentials = null, VersionInterface $versionFactory = new WithSecretManagerServiceClient(), FactoryInterface $payloadFactory = new Sealed()) : ClientInterface {
    return new \de\codenamephp\platform\secretsManager\googleSecretsManager\Client\WithGoogleSecretsManagerClient(
      new SecretManagerServiceGapicClient(array_filter(['credentials' => $credentials])),
      $versionFactory,
      $payloadFactory
    );
  }
}