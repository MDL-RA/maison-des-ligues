<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class APIService {

    public function __construct(HttpClientInterface $httpClient, private readonly ContainerInterface $container) {
        $this->httpClient = $httpClient->withOptions([
        'headers' => ['Accept' => 'application/json']
        ]);
    }

    /**
     * Méthode permettant de déchiffrer les données de l'API
     * @param $data
     * @return array
     */
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

    /**
     * Méthode permettant de récuperer la liste des clubs
     * @return array|null
     */
    public function getClub(): ?array {
            $response = $this->httpClient->request(
                    'GET',
                    'http://api/api/clubs/'
//                'http://php-symfony-api:80/api/clubs/',

            );

        if($response->getStatusCode() === 200)
        {
            return $this->decryptData($response->toArray());
        }else {
            return null;
        }
    }

    /**
     * Méthode permettant de récupérer lo liste des licencies
     * @return array|null
     */
    public function getLicencie(): ?array {
            $response = $this->httpClient->request(
                    'GET',
                   'http://api/api/licencies/'
 //                'http://php-symfony-api:80/api/licencies/',
            );
        if($response->getStatusCode() === 200)
        {
            return $this->decryptData($response->toArray());
        }else {
            return null;
        }

    }

    /**
     * Méthode permettant de récupérer la liste des Qualites
     * @return array|null
     */
    public function getQualite(): ?array {

            $response = $this->httpClient->request(
                    'GET',
                  'http://api/api/qualites',
//                'http://php-symfony-api:80/api/qualites/',

            );
            if($response->getStatusCode() === 200)
            {
                return $this->decryptData($response->toArray());
            }else {
                return null;
            }
    }

    /**
     * Méthode permettant de récuperer les informations d'un licencié par son numéro de licencié
     * @param int $id
     * @return array|null
     */
    public function getLicencieById(int $id): ?array
    {
            $response = $this->httpClient->request(
                'GET',
 //                'http://php-symfony-api:80/api/licencies/'.$id,
              'http://api/api/licencies/'.$id,
            );
            if($response->getStatusCode() === 200)
            {
                return $this->decryptData($response->toArray());
            }else {
                return null;
            }
    }

}
