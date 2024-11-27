<?php
namespace App\Services;

use Exception;

class WhatsAppService
{
    public static function sendMessage($nomorHp, $pesan)
    {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => [
                    'target' => $nomorHp,
                    'message' => $pesan,
                    'countryCode' => '62', // Optional, kode negara
                ],
                CURLOPT_HTTPHEADER => [
                    'Authorization: ' . env('FONNTE_API_KEY'), // API Key dari file .env
                ],
            ]);

            $response = curl_exec($curl);
            curl_close($curl);

            
    }
}
