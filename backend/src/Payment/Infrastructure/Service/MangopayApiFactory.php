<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\Infrastructure\Service;

use MangoPay\MangoPayApi;

final class MangopayApiFactory
{
    public function __construct(
        private readonly string $clientId,
        private readonly string $clientPassword,
        private readonly string $baseUrl,
        private readonly string $tempFolder,
    ) {}

    public function create(): MangoPayApi
    {
        $api = new MangoPayApi();
        $api->Config->ClientId = $this->clientId;
        $api->Config->ClientPassword = $this->clientPassword;
        $api->Config->BaseUrl = $this->baseUrl;
        $api->Config->TemporaryFolder = $this->tempFolder;

        return $api;
    }
}
