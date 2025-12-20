<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  api-monagil
 */
declare(strict_types=1);

namespace App\Authentication\UI\Http\Rest\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Authentication\UI\Http\Rest\ApiPlatform\Processor\LoginProcessor;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/login',
            inputFormats: ['json' => ['application/json']],
            status: 201,
            openapi: new Operation(
                summary: 'Login',
                description: 'Login',
            ),
            validationContext: ['groups' => ['login']],
            read: false,
            processor: LoginProcessor::class
        )
    ]
)]
class LoginResource {
    #[ApiProperty(
        description: 'The username',
    )]
    #[Groups(['login'])]
    public string $username;
    
    #[ApiProperty(
        description: 'The password',
    )]
    #[Groups(['login'])]
    public string $password;
    
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
}