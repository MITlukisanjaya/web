<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Alert;
use Session;

class LessonController extends Controller
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

    private function clientApiAuth()
    {
        return new Client([
            'base_uri' => $this->urlApi,
            'headers'  => [
                'Accept'        => 'application/json'
            ],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guestLesson(Client $client, Request $request)
    {

        $page = explode('page=', $request->fullUrl());

        if (!isset($page[1])) {
            try {
                $data = $client->request('GET', $this->urlApi .
                    "guest/lesson", [
                        'headers' => [
                            'Authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                            'Accept'        => 'application/json',
                            'paginator'     => 10
                        ]
                ])->getBody()->getContents();

            } catch (GuzzleException $e) {
                $data= $e->getResponse()->getBody()->getContents();
                $data = $data->error->message;
                flash($data)->error()->important();

            }

            $lesson = json_decode($data);

            foreach ($lesson->data as $key => $value) {

                try {
                    $data = $client->request('GET', $value->categories)
                        ->getBody()->getContents();

                } catch (GuzzleException $e) {
                    $data = $e->getResponse()->getBody()->getContents();
                    $data = $data->error->message;
                    flash($data)->error()->important();

                }

                $lesson->categories[] = json_decode($data);
            }


        }else{
            try {
                $data = $client->request('GET', $this->urlApi .
                    "guest/lesson?page=" . $page[1], [
                        'headers' => [
                            'Authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                            'Accept' => 'application/json',
                            'paginator' => 10
                        ]
                ])->getBody()->getContents();

            } catch (GuzzleException $e) {
                $data = $e->getResponse()->getBody()->getContents();
                $data = $data->error->message;
                flash($data)->error()->important();

            }

            $lesson = json_decode($data);

            foreach ($lesson->data as $key => $value) {

                try {
                    $data = $client->request('GET', $value->categories)
                                ->getBody()->getContents();

                } catch (GuzzleException $e) {
                    $data = $e->getResponse()->getBody()->getContents();
                    $data = $data->error->message;
                    flash($data)->error()->important();

                }
                $lesson->categories[] = json_decode($data);
            }
        }


        return view('admin.lesson.lesson_list')
            ->with('lesson', $lesson);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guestLessonDraft(Client $client, Request $request)
    {

        $page = explode('page=', $request->fullUrl());

        if (!isset($page[1])) {
            try {
                $data = $client->request('GET', $this->urlApi .
                    "guest/lesson/draft", [
                        'headers' => [
                            'Authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                            'Accept' => 'application/json',
                            'paginator' => 10
                        ]
                ])->getBody()->getContents();

            } catch (GuzzleException $e) {
                $data = $e->getResponse()->getBody()->getContents();
                $data = $data->error->message;
                flash($data)->error()->important();

            }

            $lesson = json_decode($data);

            foreach ($lesson->data as $key => $value) {

                try {
                    $data = $client->request('GET', $value->categories)
                                ->getBody()->getContents();

                } catch (GuzzleException $e) {
                    $data = $e->getResponse();
                    $data = $data->error->message;
                    flash($data)->error()->important();

                }
                $lesson->categories[] = json_decode($data);
            }


        }else{
            try {
                $data = $client->request('GET', $this->urlApi .
                    "guest/lesson/draft?page=" . $page[1], [
                        'headers' => [
                            'Authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                            'Accept'        => 'application/json',
                            'paginator'     => 10
                        ]
                ])->getBody()->getContents();

            } catch (GuzzleException $e) {
                $data = $e->getResponse()->getBody()->getContents();
                $data = $data->error->message;
                flash($data)->error()->important();

            }

            $lesson = json_decode($data);

            foreach ($lesson->data as $key => $value) {

                try {
                    $data = $client->request('GET', $value->categories)
                                ->getBody()->getContents();

                } catch (GuzzleException $e) {
                    $data = $e->getResponse()->getBody()->getContents();
                    $data = $data->error->message;
                    flash($data)->error()->important();

                }

                $lesson->categories[] = json_decode($data);
            }
        }


        return view('admin.lesson.lesson_draft')
            ->with('lesson', $lesson);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function authLesson(Client $client, Request $request)
    {
        
        $page = explode('page=', $request->fullUrl());

        if (!isset($page[1])) {
            try {
                $body   = $client->request('GET', $this->urlApi . "auth/lesson?page=1", [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                            'paginator' => 8,
                        ],
                    ])->getBody()->getContents();
            } catch (Exception $e) {
                $body   = $e->getResponse();
            }

            $lesson = json_decode($body);

            foreach ($lesson->data as $key => $value) {
                try {
                    $bodyx = $client->request('GET', $value->categories, [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        // 'Authorization' => 'bearer ' . Session::get('login')->meta->api_token, 
                    ])->getBody()->getContents();
                    
                    $category = json_decode($bodyx);
                } catch (GuzzleException $e) {
                    $category = $e->getResponse()->getBody()->getContents(); 
                    $category = json_decode($category);
                }
                $lesson->data[$key]->categories = $category->data;
            }

        } else {
            try {
                $body   = $client->request('GET', $this->urlApi . "auth/lesson?page=" . $page[1], [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                            'paginator' => 8,
                        ],
                    ])->getBody()->getContents();
            } catch (Exception $e) {
                $body   = $e->getResponse()->getBody()->getContents();
            }

            $lesson = json_decode($body);

            foreach ($lesson->data as $key => $value) {
                try {
                    $bodyx = $client->request('GET', $value->categories, [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        // 'Authorization' => 'bearer ' . Session::get('login')->meta->api_token, 
                    ])->getBody()->getContents();
                    
                    $category = json_decode($bodyx);
                } catch (GuzzleException $e) {
                    $category = $e->getResponse()->getBody()->getContents(); 
                }
                $lesson->data[$key]->categories = $category->data;
            }
        }
        $slide = $this->getSlideContent($request, $client);

        return view('front.lesson', compact('lesson', 'slide'));
    }

    public function getSlideContent(Request $request, Client $client)
    {
         try {
                $body   = $client->request('GET', $this->urlApi . "auth/lesson", [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                        ]
                    ])->getBody()->getContents();

                $lesson = json_decode($body);

                foreach ($lesson->data as $key => $value) {
                    try {
                        $bodyx = $client->request('GET', $value->categories, [
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json',
                            // 'Authorization' => 'bearer ' . Session::get('login')->meta->api_token, 
                        ])->getBody()->getContents();
                        
                        $category = json_decode($bodyx);
                    } catch (GuzzleException $e) {
                        $category = $e->getResponse()->getBody()->getContents(); 
                    }
                    $lesson->data[$key]->categories = $category->data;
                }
            } catch (Exception $e) {
                $body   = $e->getResponse()->getBody()->getContents();
            }

            array_splice($lesson->data, 3);
            return $lesson->data;
    }


    public function getByCategory(Client $client, Request $request, $slug)
    {
        
        $page = explode('page=', $request->fullUrl());

            try {
                $body   = $client->request('GET', $this->urlApi . 
                    "category/lesson?category=" . $slug, [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                            // 'paginator' => 8,
                        ],
                    ])->getBody()->getContents();
            } catch (Exception $e) {
                $body   = $e->getResponse()->getBody()->getContents();
            }

            $lesson = json_decode($body);

            foreach ($lesson->data as $key => $value) {
                try {
                    $bodyx = $client->request('GET', $value->categories, [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        // 'Authorization' => 'bearer ' . Session::get('login')->meta->api_token, 
                    ])->getBody()->getContents();
                    
                    $category = json_decode($bodyx);
                } catch (GuzzleException $e) {
                    $category = $e->getResponse()->getBody()->getContents(); 
                }
                $lesson->data[$key]->categories = $category->data;
            }

        return view('front.lessonbycategory', compact('lesson'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function authShow(Client $client, $slug)
    {
        //
        try {
            $body = $client->request('GET', $this->urlApi ."auth/lesson/" . $slug,[
                ])->getBody()->getContents();
        } catch (Exception $e) {
            $body = $e->getResponse()->getBody()->getContents();
        }

        $lesson = json_decode($body);

        try {
            $bodyx = $client->request('GET', $lesson->data->categories, [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                // 'Authorization' => 'bearer ' . Session::get('login')->meta->api_token, 
            ])->getBody()->getContents();
        } catch (GuzzleException $e) {
            $bodyx= $e->getResponse()->getBody()->getContents(); 
        }

        try {
            $bodyp = $client->request('GET', $this->urlApi . "auth/lesson/". $slug . "/part",[
                ])->getBody()->getContents();
        } catch (Exception $e) {
            $bodyp = $e->getResponse();
            $bodyp = $bodyp->getBody()->getContents();
        }

            $lesson->category = json_decode($bodyx);
            $part = json_decode($bodyp);            
            // var_dump($part);
            // die();

        return view('front.lessondetail', compact('lesson', 'part'));
    }

    public function showVideo(Client $client, $parent, $slug)
    {
        try {
            $body = $client->request('GET', $this->urlApi ."auth/lesson/" . $parent,[
                ])->getBody()->getContents();
        } catch (Exception $e) {
            $body = $e->getResponse()->getBody()->getContents();
        }

        $lesson = json_decode($body);

        try {
            $bodyx = $client->request('GET', $lesson->data->categories, [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                // 'Authorization' => 'bearer ' . Session::get('login')->meta->api_token, 
            ])->getBody()->getContents();
        } catch (GuzzleException $e) {
            $bodyx= $e->getResponse()->getBody()->getContents(); 
        }

        try {
            $bodyp = $client->request('GET', $this->urlApi . "auth/lesson/". $parent . "/part",[
                ])->getBody()->getContents();
        } catch (Exception $e) {
            $bodyp = $e->getResponse();
            $bodyp = $bodyp->getBody()->getContents();
        }

        $lesson->category = json_decode($bodyx);
        $part = json_decode($bodyp);

        try {
            $bodyv = $client->request('GET', $this->urlApi . "auth/lesson/".$parent."/". $slug,[
                ])->getBody()->getContents();
        } catch (Exception $e) {
            $bodyv = $e->getResponse()->getBody()->getContents();
        }
        $video = json_decode($bodyv);

        return view('front.lessonvideo', compact('lesson', 'part', 'video'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        //
        try {
            $data_category = $this->clientApiAuth()->request('GET', "category")
                ->getBody()->getContents();
            $data_category = json_decode($data_category);

        } catch (GuzzleException $e) {
            $data_category = $e->getResponse()->getBody()->getContents();
            $data_category = json_decode($data_category);
            $data_category = $data_category->error->message;
            flash($data)->error()->important();
        }

        return view('admin.lesson.lesson_form')
            ->with('category', $data_category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Client $client, Request $request)
    {
        //

        $data_lesson = [
            'title'           => $request->title,
            'summary'         => $request->summary,
            'url_source_code' => $request->url_source_code,
            'type'            => $request->type,
            'status'          => $request->status,
            'categories'      => $request->categories,
        ];

        try {
            if ($request->file('thumbnail') != NULL) {
                $path      = $request->file('thumbnail')
                                ->getRealPath();
                $name      = $request->file('thumbnail')
                                ->getClientOriginalName();
                $extension = $request->file('thumbnail')
                                ->getClientOriginalExtension();
                $mime      = $request->file('thumbnail')
                                ->getMimeType();

                $thumbnail[] = [
                    'name'      => "thumbnail",
                    'filename'  => $name,
                    'Mime-Type' => $mime,
                    'contents'  => fopen(realpath($path), 'rb'),
                ];

                $respon = $client->request('POST', $this->urlApi .
                    'guest/lesson', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                        'X-API-Key' => str_random(8)
                    ],
                    'query'     => $data_lesson,
                    'multipart' => $thumbnail,
                ])->getBody()->getContents();

            } else {
                $respon = $this->clientApiGuest()
                    ->request('POST', 'guest/lesson', [
                        'query' => $data_lesson,
                ])->getBody()->getContents();
            }
            $respon = json_decode($respon);
            flash("Lesson Berhasil Ditambahkan")->success();

            return redirect()->action('LessonController@guestLesson');

        } catch (GuzzleException $e) {
            $respon = $e->getResponse()->getBody()->getContents();
            $respon = json_decode($respon);
            $respon = $respon->error->message;

            return redirect()
                ->action('LessonController@getCreate')
                ->with('error', $respon)
                ->with('old', $data_lesson);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function guestShow(Client $client, $slug)
    {
        // data lesson
        try {

            $data_category = $this->clientApiAuth()
                                ->request('GET', "category")
                                ->getBody()->getContents();
            $data_category = json_decode($data_category);
            $category = $data_category->data;

            $data_lesson = $this->clientApiGuest()
                        ->request('GET', "guest/lesson/" . $slug)
                        ->getBody()->getContents();
            $data_lesson = json_decode($data_lesson);

            // data category dari lesson

            try {
                $data_categories = $client
                    ->request('GET', $data_lesson->data->categories)
                    ->getBody()->getContents();
                $data_categories = json_decode($data_categories);

            } catch (GuzzleException $e) {
                $data_categories= $e->getResponse()->getBody()->getContents();
                $data_categories = json_decode($data_categories);
            }

            return view('admin.lesson.lesson_form')
                ->with('lesson', $data_lesson)
                ->with('category', $data_category)
                ->with('categories', $data_categories);

        } catch (GuzzleException $e) {
            $data_lesson = $e->getResponse()->getBody()->getContents();
            $data_lesson = json_decode($data_lesson);
            $data_lesson = $data_lesson->error->message;
            flash($data_lesson)->error()->important();

            return redirect()->route('admin.lesson.list');

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug, Client $client)
    {
        //

        $data_lesson = [
            'title'           => $request->title,
            'summary'         => $request->summary,
            'url_source_code' => $request->url_source_code,
            'type'            => $request->type,
            'status'          => $request->status,
            'categories'      => $request->categories,
        ];

        try {
            if ($request->file('thumbnail') != NULL) {
                $path      = $request->file('thumbnail')
                                ->getRealPath();
                $name      = $request->file('thumbnail')
                                ->getClientOriginalName();
                $extension = $request->file('thumbnail')
                                ->getClientOriginalExtension();
                $mime      = $request->file('thumbnail')
                                ->getMimeType();

                $thumbnail[] = [
                    'name'      => "thumbnail",
                    'filename'  => $name,
                    'Mime-Type' => $mime,
                    'contents'  => fopen(realpath($path), 'rb'),
                ];

                $data = $client->request('POST', $this->urlApi . 'guest/lesson/'
                    . $slug, [
                       'headers'    => [
                            'Authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                            'X-API-Key'     => str_random(8),
                        ],
                        'query'     => $data_lesson,
                        'multipart' => $thumbnail,
                ])->getBody()->getContents();

            } else {
                $data = $this->clientApiGuest()
                    ->request('POST', 'guest/lesson/' . $slug, [
                        'query' => $data_lesson,
                ])->getBody()->getContents();
            }

            $data = json_decode($data);
            flash("Lesson Berhasil Diupdate")->success();
            return redirect()->action('LessonController@guestLesson');

        } catch (GuzzleException $e) {
            $data = $e->getResponse()->getBody()->getContents();
            $data = json_decode($data);
            $data = $data->error->message;
            flash($data)->error()->important();
            return redirect()
                ->action('LessonController@guestShow')
                ->with('error', $data)
                ->with('old', $data_lesson);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($slug)
    {
        //
        try {
            $data = $this->clientApiGuest()
                        ->request('DELETE', 'guest/lesson/' . $slug);

            $data = json_decode($data->getBody()->getContents());
            $data = $data->success->message;
            flash($data)->success();

        } catch (GuzzleException $e) {

            $data = $e->getResponse();
            $data = json_decode($data->getBody()->getContents());
            $data = $data->error->message;
            flash($data)->error()->important();
        }

        return redirect()->route('admin.lesson.list')
            ->with(compact('data'));
    }
}
