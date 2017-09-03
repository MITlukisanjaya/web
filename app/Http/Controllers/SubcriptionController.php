<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Alert;
use Session;

class SubcriptionController extends Controller
{
    //
    private $urlApi   = "http://127.0.0.1:8080/api/";

    private function clientApiGuest()
    {
        return new Client([
            'base_uri' => $this->urlApi,
            'headers'  => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . Session::get('login')->meta->api_token
            ],
        ]);
    }

    public function listSubcription()
    {
        try {
            $body = $this->clientApiGuest()
                        ->request('GET', "subcription/price")
                        ->getBody()->getContents();

        } catch (GuzzleException $e) {
            $body = $e->getResponse();
            $body = json_decode($body->getBody()->getContents());
            $body = $body->error->message;
            flash($body)->error()->important();
        }

        $subcription = json_decode($body);

        return view('admin.subcription.subcription')
            ->with('subcription', $subcription);
    }

    public function updateSubcription(Request $request)
    {

        $data = [
            'month1' => $request->month1,
            'month3' => $request->month3,
            'month6' => $request->month6,
        ];

        try {
            $body = $this->clientApiGuest()
                        ->request('PUT', "guest/subcription/price",
                        ['query' => $data])->getBody()->getContents();

            $body = json_decode($body);
            flash($body->success->message)->success();

        } catch (GuzzleException $e) {
            $body = $e->getResponse();
            $body = $body->getBody()->getContents();
            $body = json_decode($body);
            $body = $body->error->message;
            flash($body)->error()->important();
        }

        return redirect()->route('admin.subcription.index');
    }

    public function listTransaction()
    {
        try {
            $body = $this->clientApiGuest()
                        ->request('GET', "guest/subcription/transactions")
                        ->getBody()->getContents();
            $body = json_decode($body);
        } catch (GuzzleException $e) {
            $body = $e->getResponse();
            $body = $body->getBody()->getContents();
            $body = json_decode($body);
            // $body = $body->error->message;
            // flash($body)->error()->important();
        }

        return view('admin.subcription.transaction')
            ->with('transaction', $body);
    }

    public function detailTransaction($id)
    {
        try {
            $body = $this->clientApiGuest()
                        ->request('GET', "guest/subcription/transactions/" . $id)
                        ->getBody()->getContents();

            $transaction = json_decode($body);

            return view('admin.subcription.detail.transaction')
                ->with('detail', $body);

        } catch (GuzzleException $e) {
            $body = $e->getResponse();
            $body = json_decode($body->getBody()->getContents());
            $body = $body->error->message;
            flash($body)->error()->important();

            return redirect()->route('admin.transaction.index');

        }

    }
}
