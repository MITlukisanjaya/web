<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Alert;
use Session;

class LessonPartController extends Controller
{

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Client $client, Request $request, $slug)
    {
        $page = explode('page=', $request->fullUrl());

        if (!isset($page[1])) {
            try {
                $body = $client->request('GET', $this->urlApi . "guest/lesson/"
                    . $slug . "/part" , [
                    'headers' => [
                        'Authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                        'Accept'        => 'application/json',
                        'paginator'     => 10
                    ]
                ])->getBody()->getContents();

            } catch (GuzzleException $e) {
                $body = $e->getResponse()->getBody()->getContents();
                $body = $body->error->message;
                flash($body)->error()->important();
            }
        }else{
            try {
                $body = $client->request('GET', $this->urlApi . "guest/lesson/"
                    . $slug . "/part" , [
                    'headers' => [
                        'Authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                        'Accept'        => 'application/json',
                        'paginator'     => 10
                    ]
                ])->getBody()->getContents();

            } catch (GuzzleException $e) {
                $body = $e->getResponse()->getBody()->getContents();
                $body = $body->error->message;
                flash($body)->error()->important();
            }

        }

        $lessonPart = json_decode($body);

        $lessonPart->sluglesson = $slug;

        return view('admin.lesson.lessonpart_list', compact('lessonPart'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Client $client, Request $request, $slug)
    {
        //
        $data = [
            'title' => $request->title,
            'url_video' => $request->url_video,
        ];

        try {
            $body = $this->clientApiGuest()->request('POST', 'guest/lesson/' . 
                    $slug . '/part', [
                    'query' => $data
            ])->getBody()->getContents();
            $body = json_decode($body);
            flash("Lesson Part Berhasil Ditambahkan")->success();

            return redirect()->route('admin.lessonpart.index', ['slug' => $slug])
                ->with(compact('body'));

        } catch (GuzzleException $e) {
            $body= $e->getResponse()->getBody()->getContents();
            $body = json_decode($body);
            $body = $body->error->message;

            return redirect()->route('admin.lessonpart.index', ['slug' => $slug])
                ->with('error', $body)
                ->with('old', $data);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $slugPart)
    {
        //
        try {
            $body = $this->clientApiGuest()->request('GET',
                'guest/lesson/' . $slug . '/' . $slugPart)
                    ->getBody()->getContents();
            $body = json_decode($body);
            $body = $body->data;

            return redirect()->route('admin.lessonpart.index', ['slug' => $slug])
                ->with('lessonPartEdit', $body);

        } catch (GuzzleException $e) {
            $body= $e->getResponse()->getBody()->getContents();
            $body = json_decode($body);
            $body = $body->error->message;
            flash($body)->error()->important();
            return redirect()->route('admin.lessonpart.index', ['slug' => $slug]);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug, $slugPart)
    {
        //
        $data = [
            'title' => $request->title,
            'url_video' => $request->url_video,
        ];

        $data_edit = [
            'title'     => $request->title,
            'url_video' => $request->url_video,
            'slug'      => $slugPart
        ];

        try {
            $body = $this->clientApiGuest()->request('PUT',
                'guest/lesson/' . $slug . '/' . $slugPart, [
                    'query' => $data
            ])->getBody()->getContents();
            $body = json_decode($body);
            flash("Lesson Part Berhasil Diubah")->success();

            return redirect()->route('admin.lessonpart.index', ['slug' => $slug])
                ->with(compact('body'));

        } catch (GuzzleException $e) {
            $body= $e->getResponse()->getBody()->getContents();
            $body = json_decode($body);
            $body = $body->error->message;

            return redirect()->route('admin.lessonpart.index', ['slug' => $slug])
                ->with('error', $body)
                ->with('old', $data_edit);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, $slugPart)
    {
        //
        try {
            $body = $this->clientApiGuest()
                        ->request('DELETE', 'guest/lesson/' . 
                            $slug . '/' . $slugPart);

            $body = json_decode($body->getBody()->getContents());
            $body = $body->success->message;
            flash($body)->success();

        } catch (GuzzleException $e) {

            $body= $e->getResponse();
            $body = json_decode($body->getBody()->getContents());
            $body = $body->error->message;
            flash($body)->error()->important();
        }

        return redirect()->route('admin.lessonpart.index', ['slug' => $slug])
                ->with(compact('body'));
    }
}
