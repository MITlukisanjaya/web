<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Alert;
use Session;

class HomeController extends Controller
{
    private $url = "http://127.0.0.1:8080/api/";

    public function index(Client $client)
    {
        try {
            $paket = $client->request('GET', $this->url . "subcription/price", [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->getBody()->getContents();
        } catch (Exception $e) {
            $paket = null;
        }
        $paket = json_decode($paket);

        return view('front.home', compact('paket'));
    }

    public function guestDashboard()
    {
        return view('admin.dashboard');
    }
}