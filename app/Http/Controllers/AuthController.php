<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Alert;
use Session;

class AuthController extends Controller
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

    public function getLogin(Client $client)
    {
        return view('front.login');
    }


    public function postLogin(Client $client, Request $request)
    {
        $data = [
                    'username' => $request->username,
                    'password' => $request->password,
                ];
        try {
            $body = $client->post( $this->urlApi . 'auth/login' , [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    ],
                'json' => $data,
                // 'Authorization' => 'bearer ' . Session::get('login')->meta->api_token, 
            ])->getBody()->getContents();

            $body = json_decode($body);
            Session::put('login', $body);
            $login = Session::get('login');

            if ($login->data->role == 'administrator') {
                return redirect()->route('admin.dashboard');
            }elseif ($login->data->role == 'moderator') {
                return redirect()->route('admin.dashboard');
            }elseif ($login->data->role == 'contributor') {
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->route('home');
            }

        } catch (GuzzleException $e) {
            $body = $e->getResponse()->getBody()->getContents();

            $body = json_decode($body);
            $body = $body->error->message;

            if (isset($body->username) ||
                isset($body->password)) {
                
                return redirect()
                    ->action('AuthController@getLogin')
                    ->with('error', $body)
                    ->with('old', $data);
            }else{
                alert()->error($body);

                return redirect()->route('auth.get.login');
            }
        }
    }

    public function getRegister(Client $client)
    {
        return view('front.register');
    }

    public function postRegister(Client $client, Request $request)
    {
        $data = [
                    "name"     => $request->name,
                    "username" => $request->username,
                    "email"    => $request->email,
                    "password" => $request->password,

                ];
        try {
            $body = $client->request('POST', $this->urlApi . 'auth/register',[
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'query' => $data, 
            ])->getBody()->getContents();

            $body = json_decode($body);

        } catch (GuzzleException $e) {
            $body = $e->getResponse()->getBody()->getContents();
            $body = json_decode($body);
            $body = $body->error->message;

            if (isset($body->name) ||
                isset($body->username)||
                isset($body->email) ||
                isset($body->password)) {

                return redirect()
                    ->action('AuthController@getRegister')
                    ->with('error', $body)
                    ->with('old', $data);
            }
        }
            // Alert::message('Register berhasil!');
        alert()->info('Silakan Aktifasi Akun Melalui Email', 'Register Berhasil');

        return redirect()->route('auth.get.login');
    }

    public function activation(Client $client)
    {
        return view('front.activation');
    }

    public function logout(Client $client)
    {
        Session::forget('login');

        alert()->info('Anda Telah Berhasil Logout !!!', 'Logout Berhasil');

        return redirect()->route('home');
    }

    public function authGetUpdate(Request $request, Client $client)
    {
        try {
            $body = $client->get( $this->urlApi . 'guest/profile' , [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'authorization' => 'Bearer ' . Session::get('login')->meta->api_token, 
                    ],
                // 'Authorization' => 'bearer ' . Session::get('login')->meta->api_token, 
            ])->getBody()->getContents();
            $user = json_decode($body)->data;
        } catch (Exception $e) {
            $user = null;
        }
        $tab ='';

        return view('front.profileupdate', compact('user', 'tab'));
    }

    // public function authPostUpdate(Request $request, Client $client)
    // {

    //     $data = [
    //         "name"=> $request->name,
    //         "phone_number" => $request->phone,
    //     ];

    //     if ($request->file('photo') != NULL) {
    //         $path      = $request->file('photo')
    //                              ->getRealPath();
    //         $name      = $request->file('photo')
    //                              ->getClientOriginalName();
    //         $extension = $request->file('photo')
    //                              ->getClientOriginalExtension();
    //         $mime      = $request->file('photo')
    //                              ->getMimeType();

    //         $thumbnail = [
    //             'name'      => "photo",
    //             'filename'  => $name,
    //             'Mime-Type' => $mime,
    //             'contents'  => fopen(realpath($path), 'rb'),
    //         ];

    //         try {
    //             $body = $client->request('POST', $this->urlApi . 'guest/profile',[
    //                         'headers' => [
    //                             'Accept' => 'application/json',
    //                             'Content-Type' => 'application/json',
    //                             'X-API-Key'     => str_random(8),
    //                             'authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
    //                         ],
    //                         'query' => $data,
    //                         'multipart' => $thumbnail,
    //                     ])->getBody()->getContents();
    //             $body = json_decode($body);
    //         } catch (GuzzleException $e) {
    //             $body = $e->getResponse()->getBody()->getContents();
    //             $body = json_decode($body);
    //             $body = $body->error->message;

    //             if (isset($body->name) ||
    //                 isset($body->phone_number)||
    //                 isset($body->photo)) {

    //                 $tab  = 'profil';

    //                 return redirect()
    //                     ->action('AuthController@authGetUpdate')
    //                     ->with('error', $body)
    //                     ->with('old', $data)
    //                     ->with('tab', $tab);
    //             }
    //         }
    //     } else {
    //         try {
    //             $body = $client->request('POST', $this->urlApi . 'guest/profile',[
    //                         'headers' => [
    //                             'Accept' => 'application/json',
    //                             'Content-Type' => 'application/json',
    //                             'authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
    //                         ],
    //                         'query' => $data,
    //                     ])->getBody()->getContents();
    //         } catch (GuzzleException $e) {
    //             $body = $e->getResponse()->getBody()->getContents();
    //             $body = json_decode($body);
    //             $body = $body->error->message;

    //             if (isset($body->name) ||
    //                 isset($body->phone_number)||
    //                 isset($body->photo)) {

    //                 $tab  = 'edit';

    //                 return redirect()
    //                     ->action('AuthController@authGetUpdate')
    //                     ->with('error', $body)
    //                     ->with('old', $data)
    //                     ->with('tab', $tab);
    //             }
    //         }
    //     }

    //     $result = json_decode($body);

    //     return redirect()->route('front.profile', compact('result'));
    // }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function authPostUpdate(Request $request, Client $client)
    {
        $data = [
            'name'         => $request->name,
            'phone_number' => $request->phone_number
        ];

        try {
            if ($request->file('photo') != NULL) {
                $path      = $request->file('photo')
                                ->getRealPath();
                $name      = $request->file('photo')
                                ->getClientOriginalName();
                $extension = $request->file('photo')
                                ->getClientOriginalExtension();
                $mime      = $request->file('photo')
                                ->getMimeType();

                $photo[] = [
                    'name'      => "photo",
                    'filename'  => $name,
                    'Mime-Type' => $mime,
                    'contents'  => fopen(realpath($path), 'rb'),
                ];
                $body = $client->request('POST', $this->urlApi .
                    'guest/profile', [
                        'headers' => [
                            'Accept'        => 'application/json',
                            'Authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                            'X-API-Key'     => str_random(8),
                        ],
                        'query' => $data,
                        'multipart' => $photo,
                ])->getBody()->getContents();
            } else {
                $body = $this->clientApiGuest()->request('POST', 'guest/profile', [
                        'query' => $data,
                ])->getBody()->getContents();
            }

            $body = json_decode($body);
            flash("Profile Berhasil DiUpdate")->success();

            return redirect()->route('front.profile')->with(compact('body'));

        } catch (GuzzleException $e) {
            $body = $e->getResponse()->getBody()->getContents();
            $body = json_decode($body);
            $body = $body->error->message;

            if (isset($body->name) ||
                isset($body->phone_number)||
                isset($body->photo)) {

                $tab  = 'profil';

                return redirect()
                    ->action('AuthController@authGetUpdate')
                    ->with('error', $body)
                    ->with('old', $data)
                    ->with('tab', $tab);
            }

            flash($body)->error()->important();

            return redirect()->route('front.profile')->with(compact('body'));

        }

    }

    public function authChangePassword(Request $request, Client $client)
    {
        // $this->validate($request,[
        //         'password_lama' => 'required',
        //         'password_baru' => 'required',
        //         'verifikasi_password' => 'required|same:password_baru',
        //     ]);

        try {
            $body = $client->request('POST', $this->urlApi . 'guest/profile/change_password',[
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                ],
                'json' => [
                    "old_password" => $request->password_lama,
                    "new_password" => $request->password_baru,
                    "confirm_new_password" => $request->verifikasi_password,
                ], 
            ])->getBody()->getContents();   
        } catch (GuzzleException $e) {
            $body = $e->getResponse()->getBody()->getContents();
            $body = json_decode($body);
            $body = $body->error->message;

            return redirect()
                        ->action('AuthController@authGetUpdate')
                        ->with('error', $body)
                        ->with('tab', 'password');
        }
        // dd($body);
        $result = json_decode($body);

        return redirect()->route('front.profile', compact('result'));
    }

    public function authGetAccount(Client $client)
    {
        try {
            $body = $client->get( $this->urlApi . 'guest/profile' , [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'authorization' => 'Bearer ' . Session::get('login')->meta->api_token, 
                    ],
                // 'Authorization' => 'bearer ' . Session::get('login')->meta->api_token, 
            ])->getBody()->getContents();
            $profil = json_decode($body)->data;

            try {
                $transaksi = $client->get($this->urlApi . 'guest/subcription/transactions', [
                                        'headers' => [
                                            'Accept' => 'application/json',
                                            'Content-Type' => 'application/json',
                                            'authorization' => 'Bearer ' . Session::get('login')->meta->api_token, 
                                            ],
                                        // 'Authorization' => 'bearer ' . Session::get('login')->meta->api_token, 
                                    ])->getBody()->getContents();
                $transaksi = json_decode($transaksi)->data;
            } catch (Exception $e) {
                
            }
        } catch (Exception $e) {
            $profil = null;
        }
        return view('front.profile', compact('profil', 'transaksi'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guestUser(Client $client, Request $request)
    {
        //
        $page = explode('page=', $request->fullUrl());

        if (!isset($page[1])) {
            try {
                $body = $client->request('GET', $this->urlApi . "guest/user", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                        'Accept'        => 'application/json',
                        'paginator'     => '5'
                    ]
                ])->getBody()->getContents();

            } catch (GuzzleException $e) {
                $body= $e->getResponse();
                $body = $body->error->message;
                flash($body)->error()->important();
            }

            $user = json_decode($body);

        }else{
            try {
                $body = $client->request('GET', $this->urlApi
                    . "guest/user?page=" . $page[1], [
                    'headers' => [
                        'Authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                        'Accept'        => 'application/json',
                        'paginator'     => '5'
                    ]
                ])->getBody()->getContents();
                $body = $body->success->message;
                flash($body)->success();

            } catch (GuzzleException $e) {
                $body= $e->getResponse();
                $body = $body->error->message;
                flash($body)->error()->important();
            }

            $user = json_decode($body);

        }
            return view('admin.user.user_list')
                ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function guestUpdateProfile(Request $request, Client $client)
    {
        $data = [
            'name'         => $request->name,
            'phone_number' => $request->phone_number
        ];

        try {
            if ($request->file('photo') != NULL) {
                $path      = $request->file('photo')
                                ->getRealPath();
                $name      = $request->file('photo')
                                ->getClientOriginalName();
                $extension = $request->file('photo')
                                ->getClientOriginalExtension();
                $mime      = $request->file('photo')
                                ->getMimeType();

                $photo[] = [
                    'name'      => "photo",
                    'filename'  => $name,
                    'Mime-Type' => $mime,
                    'contents'  => fopen(realpath($path), 'rb'),
                ];
                $body = $client->request('POST', $this->urlApi .
                    'guest/profile', [
                        'headers' => [
                            'Accept'        => 'application/json',
                            'Authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                            'X-API-Key'     => str_random(8),
                        ],
                        'query' => $data,
                        'multipart' => $photo,
                ])->getBody()->getContents();
            } else {
                $body = $this->clientApiGuest()->request('POST', 'guest/profile', [
                        'query' => $data,
                ])->getBody()->getContents();
            }

            $body = json_decode($body);
            flash("Profile Berhasil DiUpdate")->success();

            return redirect()->route('admin.user.profile')->with(compact('body'));

        } catch (GuzzleException $e) {
            $body = $e->getResponse()->getBody()->getContents();
            $body = json_decode($body);
            $body = $body->error->message;

            if (isset($body->name) ||
                isset($body->phone_number)||
                isset($body->photo)) {

                $tab  = 'edit';

                return redirect()
                    ->action('AuthController@guestShow')
                    ->with('error', $body)
                    ->with('old', $data)
                    ->with('tab', $tab);
            }


            flash($body)->error()->important();

            return redirect()->route('admin.user.profile');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guestChangePassword(Client $client, Request $request)
    {
        //
        $data = [
            'old_password' => $request->old_password,
            'new_password' => $request->new_password,
            'confirm_new_password' => $request->confirm_new_password,
        ];

        try {
            $body = $client->request('POST', $this->urlApi .
                'guest/profile/change_password', [
                    'headers' => [
                        'Accept'        => 'application/json',
                        'Content-Type'  => 'application/json',
                        'Authorization' => 'Bearer ' . Session::get('login')->meta->api_token
                    ],
                    'query' => $data
            ])->getBody()->getContents();
            $body = json_decode($body);
            flash("Berhasil Change Password")->success();

            return redirect()->route('admin.user.profile');

        } catch (GuzzleException $e) {
            $body= $e->getResponse();
            $body= $body->getBody()->getContents();
            $body = json_decode($body);
            $body = $body->error->message;

            if (isset($body->old_password) ||
                isset($body->new_password) ||
                isset($body->confirm_new_password)
                ) {

                $tab  = 'change_password';

                return redirect()
                    ->action('AuthController@guestShow')
                    ->with('error', $body)
                    ->with('tab', $tab);
            }

            flash($body)->error()->important();

            return redirect()->route('admin.user.profile');

        }


    }

    /**
     * Display the specified resource.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function guestShow()
    {
        //
        try {
            $body = $this->clientApiGuest()
                ->request('GET', "guest/profile")
                ->getBody()->getContents();

        } catch (GuzzleException $e) {
            $body= $e->getResponse();
            $body = $body->error->message;
            flash($body)->error()->important();
        }

        $user = json_decode($body);

        $tab = '';

        return view('admin.profile.info')
            ->with('user', $user)
            ->with('tab', $tab);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        //
        try {
            $body = $this->clientApiGuest()
                ->request('DELETE', 'guest/user/@' . $user)
                ->getBody()->getContents();

            $body = json_decode($body);
            $body = $body->success->message;
            flash($body)->success();

        } catch (GuzzleException $e) {

            $body= $e->getResponse()->getBody()->getContents();
            $body = json_decode($body);
            $body = $body->error->message;
            flash($body)->error()->important();
        }

        return redirect()->route('admin.user.index')->with(compact('body'));
    }
}
