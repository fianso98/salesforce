<?php

namespace App\Services;
use App\Actions\SalesforceLoginAction;
use App\Dto\CandidatAttributeDto;
use App\Dto\CandidatDto;
use App\Dto\CondidatDto;
use App\Dto\SalesforceLoginDto;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class SalesforceService
{
    public SalesforceLoginDto $salesforceLoginDto;
    public function __construct()
    {
        $salesforceLoginAction = new SalesforceLoginAction();
        $this->salesforceLoginDto = $salesforceLoginAction->login();
    }

    public function retrieveAllCandidates()
    {
        $response = $this->query("select First_Name__c, Last_Name__c, Year__c, Year_Of_Experience__c from Candidature__c");
        $data = json_decode($response->getBody());
        
        $candidats = [];
        foreach($data->records as $candidat)
        {
            $attribute = new CandidatAttributeDto(
                type: $candidat->attributes->type,
                url: $candidat->attributes->url
            );
            $userDto = new CandidatDto(
                firstName : $candidat->First_Name__c,
            lastName : $candidat->Last_Name__c,
            year : $candidat->Year__c,
            yearOfExperience : $candidat->Year_Of_Experience__c,
            attribute : $attribute,
            );
            $candidats [] = $userDto;
        }
        
        return $candidats;
    }
    public function retrieveCandidatureById(string $id)
    {
        $response = $this->query("select First_Name__c, Last_Name__c, Year__c, Year_Of_Experience__c from Candidature__c where id = '$id'");
        $data = json_decode($response->getBody());
        $candidat = $data->records[0];
        $attribute = new CandidatAttributeDto(
            type: $candidat->attributes->type,
            url: $candidat->attributes->url
        );
        $userDto = new CandidatDto(
            firstName : $candidat->First_Name__c,
        lastName : $candidat->Last_Name__c,
        year : $candidat->Year__c,
        yearOfExperience : $candidat->Year_Of_Experience__c,
        attribute : $attribute,
        );
        return $userDto;
    }

    public function insertCandidature(CandidatDto $candidat)
    {
        $response = $this->insertCandidatureQuery($candidat);
        $data = json_decode($response->getBody());
        return $data;
    }

    public function updateCandidature(string $id, CandidatDto $candidat)
    {
        $response = $this->updateCandidatureQuery($id, $candidat);
        $data = json_decode($response->getBody());
        return $data;
    }

    
    private function queryAll(string $query) : ResponseInterface
    {
        $client = new Client(['base_uri' => $this->salesforceLoginDto->instanceUrl]);
        $query = config('salesforce.urls.base_query_all_url').$query;
            $response = $client->get($query, [
                RequestOptions::HEADERS => [
                    'Authorization' => 'Bearer ' . $this->salesforceLoginDto->accessToken,
                ],
            ]);
        return $response;
    }
    private function query(string $query) : ResponseInterface
    {
        $client = new Client(['base_uri' => $this->salesforceLoginDto->instanceUrl]);
        $query = config('salesforce.urls.base_query_url').$query;
            $response = $client->get($query, [
                RequestOptions::HEADERS => [
                    'Authorization' => 'Bearer ' . $this->salesforceLoginDto->accessToken,
                ],
            ]);
        return $response;
    }

    private function insertCandidatureQuery(CandidatDto $object)
    {
        $client = new Client(['base_uri' => $this->salesforceLoginDto->instanceUrl]);
        $candidature = config('salesforce.urls.base_composite_sobject_url');
        $body = [
        "records" => [
            [
                "attributes" => ["type" => $object->attribute->type],
                "First_Name__c" => $object->firstName,
                "Last_Name__c" => $object->lastName,
                "Year_Of_Experience__c" => $object->yearOfExperience
            ]
        ]];
            $response = $client->request('POST', $candidature,
                [
                    RequestOptions::JSON  => 
                        $body
                    ,
                    RequestOptions::HEADERS => [
                        'Authorization' => 'Bearer ' . $this->salesforceLoginDto->accessToken,
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ]
                ],
                
        );
        return $response;
    }

    private function updateCandidatureQuery(string $id, CandidatDto $object)
    {
        $client = new Client(['base_uri' => $this->salesforceLoginDto->instanceUrl]);
        $type = $object->attribute->type;
        $url = config('salesforce.urls.base_sobject_url')."/$type/$id";
        $body = [
                "Last_Name__c" => $object->lastName,
        ];
            $response = $client->request('PATCH', $url,
                [
                    RequestOptions::JSON  => 
                        $body
                    ,
                    RequestOptions::HEADERS => [
                        'Authorization' => 'Bearer ' . $this->salesforceLoginDto->accessToken,
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ]
                ],
                
        );
        return $response;
    }
}