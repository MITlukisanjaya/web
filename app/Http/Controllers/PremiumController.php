<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Alert;
use Session;

class PremiumController extends Controller
{
    private $urlApi   = "http://127.0.0.1:8080/api/";

    public function register(Client $client, $month)
    {

        try {
            $body   = $client->request('GET', $this->urlApi . "guest/premium/register/". $month, [
                    'headers' => [
                        'Accept' => 'application/json',
                        'authorization' => ['Bearer ' . Session::get('login')->meta->api_token],
                    ],
                ])->getBody()->getContents();
        } catch (Exception $e) {
            $body   = $e->getResponse();
        }

       
        $body = json_decode($body, true);
        
        return view('front.payment', compact('body'));   
    }

    public function get(Client $client)
    {
        try {
            $paket = $client->request('GET', $this->urlApi . "subcription/price", [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->getBody()->getContents();
            $paket = json_decode($paket);
// var_dump($paket);die;
            // foreach ($paket['data'] as $key => $val) {
            //     try {
            //         $paket['data'][$key] =(array) $val;
            //         $body   = $client->request('GET', $this->url . "guest/premium/register/". intval(preg_replace('/[^0-9]+/', '', $val->period)), [
            //                 'headers' => [
            //                 'Accept' => 'application/json',
            //                 'authorization' => ['Bearer ' . Session::get('login')->meta->api_token],
            //                 ],])->getBody()->getContents();
            //         $paket['data'][$key]['token'] = json_decode($body)->token;
            //     } catch (Exception $e) {
            //         $body   = $e->getResponse();
            //     }
            // }
            
        } catch (Exception $e) {
            $paket = null;
        }
        // $paket = json_decode($paket);

        return view('front.premium', compact('paket'));
    }
}