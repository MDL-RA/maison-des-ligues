<?php

namespace App\Service;

use App\Entity\Hotel;
use App\Repository\HotelRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HotelService {
    public function __construct(private readonly ContainerInterface $container, private readonly HotelRepository $hotelRepository) {}

}
