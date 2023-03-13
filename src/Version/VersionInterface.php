<?php declare(strict_types=1);

namespace de\codenamephp\platform\secretsManager\googleSecretsManager\Version;

use de\codenamephp\platform\secretsManager\base\Secret\SecretInterface;

/**
 * Interface to get the secret version name from a secret that google understands
 */
interface VersionInterface {

  /**
   * Takes in the secret and constructs a secret string that is used to access a specific secret version:
   *
   * projects/{project}/secrets/{name}/versions/{version}
   *
   * @param SecretInterface $secret
   * @return string
   */
  public function secretVersionName(SecretInterface $secret) : string;
}