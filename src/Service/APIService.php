<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class APIService {

    private $api;

    public function __construct(HttpClientInterface $httpClient, private readonly ContainerInterface $container) {
        $this->httpClient = $httpClient->withOptions([
        'headers' => ['Accept' => 'application/json']
        ]);
    }

    public function decryptData($data) : array
    {
        $path= 'file://'.$this->container->getParameter('kernel.project_dir').'/config/keys/private.pem';
        $privateKey=openssl_pkey_get_private($path, 'geronimo');
        $encryptedData = base64_decode($data['value']);
        $blockSize = 256;
        $blocks = str_split($encryptedData, $blockSize);
        $decryptedBlocks = [];
        foreach ($blocks as $block) {
            $decryptedBlock = '';
            openssl_private_decrypt($block, $decryptedBlock, $privateKey);
            $decryptedBlocks[] = $decryptedBlock;
        }
        $decryptedData = implode('', $decryptedBlocks);
        return json_decode($decryptedData, true);
    }

    public function getClub(): array {
        try {
            $response = $this->httpClient->request(
                    'GET',
                    'http://api/api/clubs/'
                    
            );

            return $response->toArray();
        } catch (Exception $ex) {
            
        }
    }

    public function getLicencie(): array {
        try {
            $response = $this->httpClient->request(
                    'GET',
                    'http://api/api/licencies/'
                //'http://php-symfony-api:80/api/licencies/',
            );

            return $this->decryptData($response->toArray());;
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

    /**
     * @throws \Exception
     */
    public function getLicencieById(int $id): array
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                //'http://php-symfony-api:80/api/licencies/'.$id,
                'http://api/api/licencies/'.$id,
            );
          return $this->decryptData($response->toArray());
        }catch (\Exception $ex)
        {
            throw new \Exception('Aucun licencié n\'a été trouvé');
        }
    }


}
