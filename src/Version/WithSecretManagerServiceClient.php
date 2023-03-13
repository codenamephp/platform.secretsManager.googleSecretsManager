<?php declare(strict_types=1);

namespace de\codenamephp\platform\secretsManager\googleSecretsManager\Version;

use de\codenamephp\platform\secretsManager\base\Secret\SecretInterface;
use Google\Cloud\SecretManager\V1\Gapic\SecretManagerServiceGapicClient;

/**
 * Uses the static helper method in the google client to get the secret version name
 */
final class WithSecretManagerServiceClient implements VersionInterface {

  public function secretVersionName(SecretInterface $secret) : string {
    return SecretManagerServiceGapicClient::secretVersionName($secret->getProject(), $secret->getName(), $secret->getVersion());
  }
}