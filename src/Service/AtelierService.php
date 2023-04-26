<?php

namespace App\Service;

use App\Entity\Atelier;
use App\Repository\AtelierRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AtelierService {
    public function __construct(private readonly ContainerInterface $container, private readonly AtelierRepository $atelierRepository) {}

}
