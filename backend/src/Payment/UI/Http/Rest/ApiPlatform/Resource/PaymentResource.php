<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\Payment\UI\Http\Rest\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Payment\UI\Http\Rest\ApiPlatform\Controller\CreatePaymentAccountController;
use App\Payment\UI\Http\Rest\ApiPlatform\Input\CreatePaymentAccountInput;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/payments/accounts/create',
            inputFormats: ['json' => ['application/json']],
            status: 201,
            controller: CreatePaymentAccountController::class,
            input: CreatePaymentAccountInput::class
        )
    ]
)]
class PaymentResource {}
