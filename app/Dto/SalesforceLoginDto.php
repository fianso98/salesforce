<?php 
namespace App\Dto;

class SalesforceLoginDto
{
    public function __construct(
        public string $accessToken,
        public string $instanceUrl,
        public string $id,
        public string $tokenType,
        public string $signature,
        public string $issuedAt
        )
    {}
}