<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  api-monagil-new
 */
declare(strict_types=1);

namespace App\ServiceType\UI\Http\Rest\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\RequestBody;
use App\ServiceType\UI\Http\Rest\ApiPlatform\Controller\CreateServiceTypeController;
use App\ServiceType\UI\Http\Rest\ApiPlatform\Controller\GetServiceTypesController;
use App\ServiceType\UI\Http\Rest\ApiPlatform\Input\CreateServiceTypeInput;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/service-types',
            status: 200,
            controller: GetServiceTypesController::class,
            openapi: new Operation(
                summary: 'Get service types',
                description: 'Get service types',
            ),
            read: false
        ),
        new Post(
            uriTemplate: '/service-types',
            formats: ['multipart' => ['multipart/form-data']],
            inputFormats: ['multipart' => ['multipart/form-data']],
            controller: CreateServiceTypeController::class,

            input: CreateServiceTypeInput::class,
            deserialize: false,
            validate: false,
            read: false,
            write: false,
            status: 201,
            openapi: new Operation(
                tags: ['ServiceTypes'],
                summary: 'Créer un nouveau type de service',
                description: 'Crée un type de service avec un fichier image, nom, description et paramètres',
                requestBody: new RequestBody(
                    content: new \ArrayObject([
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                        'description' => 'Image du type de service (JPEG, PNG, WebP, max 5MB)'
                                    ],
                                    'name' => [
                                        'type' => 'string',
                                        'description' => 'Nom du type de service (2-255 caractères)',
                                        'example' => 'Réparation automobile'
                                    ],
                                    'description' => [
                                        'type' => 'string',
                                        'description' => 'Description détaillée (10-1000 caractères)',
                                        'example' => 'Services de réparation et maintenance pour véhicules'
                                    ],
                                    'taxRate' => [
                                        'type' => 'number',
                                        'format' => 'float',
                                        'nullable' => true,
                                        'description' => 'Taux de taxe en pourcentage (0-100)',
                                        'example' => 20.0
                                    ],
                                    'additionalPercentage' => [
                                        'type' => 'number',
                                        'format' => 'float',
                                        'description' => 'Pourcentage additionnel (0-100)',
                                        'example' => 15.0
                                    ],
                                    'isQuotationEnable' => [
                                        'type' => 'boolean',
                                        'description' => 'Activer la fonctionnalité de devis',
                                        'example' => true
                                    ],
                                    'order' => [
                                        'type' => 'integer',
                                        'description' => 'Ordre d\'affichage (≥ 0)',
                                        'example' => 1
                                    ]
                                ],
                                'required' => ['file', 'name', 'description', 'additionalPercentage', 'isQuotationEnable', 'order']
                            ]
                        ]
                    ])
                )
            ),
        )
    ],
)]
class ServiceTypeResource {}
