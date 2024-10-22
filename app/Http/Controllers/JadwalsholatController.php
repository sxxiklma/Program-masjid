<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;

class JadwalsholatController extends Controller
{
    public function showForm()
    {
        $cities = $this->getCities();
        $defaultCityId = 1638; // ID kota Surabaya
        $jadwalDefault = $this->getJadwalSholat($defaultCityId); // Use correct method here

        return view('sholat-form', [
            'cities' => $cities,
            'jadwalDefault' => $jadwalDefault,
            'defaultCityId' => $defaultCityId,
        ]);
    }

    // Method to handle prayer schedule retrieval
    public function getJadwalSholat($cityId)
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->format('m');
        $url = "https://api.myquran.com/v2/sholat/jadwal/$cityId/$year/$month";

        try {
            $client = new Client();
            $response = $client->request('GET', $url);
            return json_decode($response->getBody()->getContents(), true);

        } catch (\Exception $e) {
            return ['data' => null, 'error' => $e->getMessage()];
        }
    }

    public function showWelcome()
    {
        $defaultCityId = 1638; // ID kota Surabaya
        $jadwalDefault = $this->getJadwalSholat($defaultCityId); // Use correct method here

        return view('welcome', [
            'jadwalDefault' => $jadwalDefault,
        ]);
    }

    // Method to get cities from API
    private function getCities()
    {
        $client = new Client();
        $url = "https://api.myquran.com/v2/sholat/kota/semua";

        try {
            $response = $client->request('GET', $url);
            $cities = json_decode($response->getBody()->getContents(), true);
            return $cities['data'];
        } catch (\Exception $e) {
            return [];
        }
    }

    // Method to get city ID based on city name
    private function getCityId($cityName)
    {
        $cities = $this->getCities();

        foreach ($cities as $city) {
            if (strcasecmp($city['lokasi'], $cityName) == 0) {
                return $city['id'];
            }
        }

        return null;
    }
}
