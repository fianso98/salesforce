<?php 
namespace App\Dto;

class CandidatDto
{
    public function __construct(
        public ?string $firstName,
        public ?string $lastName,
        public ?string $year,
        public ?string $yearOfExperience,
        public CandidatAttributeDto $attribute,
        )
    {}
}

