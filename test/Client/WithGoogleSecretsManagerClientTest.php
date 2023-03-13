<?php declare(strict_types=1);

namespace de\codenamephp\platform\secretsManager\googleSecretsManager\test\Client;

use de\codenamephp\platform\secretsManager\base\Secret\Payload\Factory\FactoryInterface;
use de\codenamephp\platform\secretsManager\base\Secret\Payload\PayloadInterface;
use de\codenamephp\platform\secretsManager\base\Secret\Payload\Sealed;
use de\codenamephp\platform\secretsManager\base\Secret\SecretInterface;
use de\codenamephp\platform\secretsManager\googleSecretsManager\Client\WithGoogleSecretsManagerClient;
use de\codenamephp\platform\secretsManager\googleSecretsManager\Version\VersionInterface;
use Google\Cloud\SecretManager\V1\AccessSecretVersionResponse;
use Google\Cloud\SecretManager\V1\Gapic\SecretManagerServiceGapicClient;
use Google\Cloud\SecretManager\V1\SecretPayload;
use PHPUnit\Framework\TestCase;

final class WithGoogleSecretsManagerClientTest extends TestCase {

  public function test__construct() : void {
    $googleClient = $this->createMock(SecretManagerServiceGapicClient::class);
    $versionFactory = $this->createMock(VersionInterface::class);
    $secretWithPayloadFactory = $this->createMock(FactoryInterface::class);

    $sut = new WithGoogleSecretsManagerClient($googleClient,$versionFactory,$secretWithPayloadFactory);

    self::assertSame($googleClient, $sut->googleClient);
    self::assertSame($versionFactory, $sut->versionFactory);
    self::assertSame($secretWithPayloadFactory, $sut->secretWithPayloadFactory);
  }

  public function testFetchPayload() : void {
    $secret = $this->createMock(SecretInterface::class);

    $googlePayload = $this->createMock(SecretPayload::class);
    $googlePayload->expects(self::once())->method('getData')->willReturn('some data');

    $secretResponse = $this->createMock(AccessSecretVersionResponse::class);
    $secretResponse->expects(self::once())->method('getPayload')->willReturn($googlePayload);

    $googleClient = $this->createMock(SecretManagerServiceGapicClient::class);
    $googleClient->expects(self::once())->method('accessSecretVersion')->with('some secret version')->willReturn($secretResponse);

    $versionFactory = $this->createMock(VersionInterface::class);
    $versionFactory->expects(self::once())->method('secretVersionName')->with($secret)->willReturn('some secret version');

    $payload = $this->createMock(PayloadInterface::class);

    $secretWithPayloadFactory = $this->createMock(FactoryInterface::class);
    $secretWithPayloadFactory->expects(self::once())->method('build')->with('some data')->willReturn($payload);

    $sut = new WithGoogleSecretsManagerClient($googleClient, $versionFactory, $secretWithPayloadFactory);

    self::assertSame($payload, $sut->fetchPayload($secret));
  }
  public function testFetchPayload_whenGooglePayloadIsNull() : void {
    $secret = $this->createMock(SecretInterface::class);

    $secretResponse = $this->createMock(AccessSecretVersionResponse::class);
    $secretResponse->expects(self::once())->method('getPayload')->willReturn(null);

    $googleClient = $this->createMock(SecretManagerServiceGapicClient::class);
    $googleClient->expects(self::once())->method('accessSecretVersion')->with('some secret version')->willReturn($secretResponse);

    $versionFactory = $this->createMock(VersionInterface::class);
    $versionFactory->expects(self::once())->method('secretVersionName')->with($secret)->willReturn('some secret version');

    $payload = $this->createMock(PayloadInterface::class);

    $secretWithPayloadFactory = $this->createMock(FactoryInterface::class);
    $secretWithPayloadFactory->expects(self::once())->method('build')->with('')->willReturn($payload);

    $sut = new WithGoogleSecretsManagerClient($googleClient, $versionFactory, $secretWithPayloadFactory);

    self::assertSame($payload, $sut->fetchPayload($secret));
  }
}
