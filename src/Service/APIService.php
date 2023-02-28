<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class APIService {

    private $api;

    public function __construct(HttpClientInterface $httpClient) {
        $this->httpClient = $httpClient->withOptions([
        'headers' => ['Accept' => 'application/json']
        ]);
    }

    public function getClub(): array {
        try {
            $response = $this->httpClient->request(
                    'GET',
                    'http://api/api/clubs?page=1'
                    
            );

            return $response->toArray();
        } catch (Exception $ex) {
            
        }
    }

    public function getLicencie(): array {
        try {
            $response = $this->httpClient->request(
                    'GET',
                    'http://api/api/licencies?page=1'
            );

            return $response->toArray();
        } catch (Exception $ex) {
            
        }
    }

    public function getQualite(): array {
        try {
            $response = $this->httpClient->request(
                    'GET',
                    'http://api/api/qualites?page=1',
            );

            return $response->toArray();
        } catch (Exception $ex) {
            
        }
    }

}
