<?php 
namespace App\Dto;

class CandidatAttributeDto
{
    public function __construct(
        public ?string $type,
        public ?string $url,
        )
    {}
}