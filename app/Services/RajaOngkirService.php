<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.rajaongkir.key');
        $this->baseUrl = config('services.rajaongkir.base_url');
    }

    /**
     * Get all provinces
     *
     * @return array
     */
    public function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey,
        ])->get("{$this->baseUrl}/province");

        return $response->json();
    }

    /**
     * Get cities by province ID
     *
     * @param int $provinceId
     * @return array
     */
    public function getCities($provinceId)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey,
        ])->get("{$this->baseUrl}/city", [
            'province' => $provinceId,
        ]);
        

        return $response->json();
    }

    public function getShippingCost($origin, $destination, $weight, $courier)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey,
        ])->post("{$this->baseUrl}/cost", [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
        ]);

        return $response->json();
    }
}
