<?php declare(strict_types=1);

namespace de\codenamephp\platform\secretsManager\googleSecretsManager\Client;

use de\codenamephp\platform\secretsManager\base\Client\ClientInterface;
use de\codenamephp\platform\secretsManager\base\Secret\Payload\Factory\FactoryInterface;
use de\codenamephp\platform\secretsManager\base\Secret\Payload\PayloadInterface;
use de\codenamephp\platform\secretsManager\base\Secret\SecretInterface;
use de\codenamephp\platform\secretsManager\googleSecretsManager\Version\VersionInterface;
use Google\ApiCore\ApiException;
use Google\Cloud\SecretManager\V1\Gapic\SecretManagerServiceGapicClient;

/**
 * Simple client that uses the GoogleSecretsManagerClient from the google cloud sdk
 */
final class WithGoogleSecretsManagerClient implements ClientInterface {

  public function __construct(
    public readonly SecretManagerServiceGapicClient $googleClient,
    public readonly VersionInterface $versionFactory,
    public readonly FactoryInterface $secretWithPayloadFactory
  ) {}

  /**
   * Builds the secret name from the secret using the factory, fetches the secret using the google client and builds the payload from the secret data
   * using the payload factory. If the payload is null an empty string is used instead.
   *
   * @inheritdoc
   *
   * @throws ApiException when the google client encounters an error
   */
  public function fetchPayload(SecretInterface $secret) : PayloadInterface {
    return $this->secretWithPayloadFactory->build(
      $this->googleClient->accessSecretVersion($this->versionFactory->secretVersionName($secret))->getPayload()?->getData() ?? ''
    );
  }
}