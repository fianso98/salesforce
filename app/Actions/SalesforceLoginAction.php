<?php 

namespace App\Actions;
use App\Dto\SalesforceLoginDto;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class SalesforceLoginAction{
    public function login() : SalesforceLoginDto
    {
        $client = new Client(['base_uri' => config('salesforce.urls.base_login_url')]);
        try {
            $response = $client->post(config('salesforce.urls.get_token'), [
                RequestOptions::FORM_PARAMS => [
                    'grant_type' => 'password',
                    'client_id' => config('salesforce.client_id'),
                    'client_secret' => config('salesforce.client_secret'),
                    'username' => config('salesforce.username'),
                    'password' => config('salesforce.password'),
                ]
            ]);
        
        $data = json_decode($response->getBody());
        $hash = hash_hmac(
            'sha256',
            $data->id . $data->issued_at,
            config('salesforce.client_secret'),
            true
        );
        
        if (base64_encode($hash) !== $data->signature) {
            throw new \Exception('The Salesforce Access Token is invalid');
        }

        return new SalesforceLoginDto(
            accessToken: $data->access_token,
            instanceUrl: $data->instance_url,
            tokenType: $data->token_type,
            signature: $data->signature,
            id: $data->id,
            issuedAt: $data->issued_at
        );
        
        } catch (\Exception $e) {
            throw new \Exception(
                    sprintf('Could not connect to the Salesforce API: %s', $e->getMessage())
                );
        }
    }
}