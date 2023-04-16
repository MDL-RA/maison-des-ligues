<?php

namespace App\Service;

use App\Entity\Compte;
use App\Repository\CompteRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SecurityService {
    public function __construct(private readonly ContainerInterface $container, private readonly CompteRepository $compteRepository) {}

}
