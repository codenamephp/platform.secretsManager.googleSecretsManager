<?php declare(strict_types=1);

namespace de\codenamephp\platform\secretsManager\googleSecretsManager\test\Version;

use de\codenamephp\platform\secretsManager\base\Secret\Sealed;
use de\codenamephp\platform\secretsManager\googleSecretsManager\Version\WithSecretManagerServiceClient;
use PHPUnit\Framework\TestCase;

final class WithSecretManagerServiceClientTest extends TestCase {

  public function testSecretVersionName() : void {
    self::assertSame('projects/some project/secrets/some name/versions/some version', (new WithSecretManagerServiceClient())->secretVersionName(new Sealed('some name', 'some project', 'some version')));
  }
}
