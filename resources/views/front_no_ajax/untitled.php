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



                $thumbnail[] = [
                    'name'      => "photo",

                    'filename'  => $name,

                    'Mime-Type' => $mime,

                    'contents'  => fopen(realpath($path), 'rb'),

                ];

                $body = $client->request('POST', $this->urlApi .

                    'guest/profile', [

                        'headers' => [

                            'Accept'        => 'application/json',

                            'Authorization' => 'Bearer ' . $this->token,

                            'X-API-Key'     => random_str(8),

                        ],

                        'query' => $data,

                        'multipart' => $thumbnail,

                ])->getBody()->getContents();

            } else {

                $body = $this->clientApiGuest()->request('POST', 'guest/profile', [

                        'query' => $data,

                ])->getBody()->getContents();

            }



            $body = json_decode($body);

            flash("Profile Berhasil DiUpdate")->success();



            return redirect()->route('user.profile')->with(compact('body'));



        } catch (GuzzleException $e) {

            $body = $e->getResponse()->getBody()->getContents();

            $body = json_decode($body);

            $body = $body->error->message;



            if (isset($body->name) ||
                isset($body->phone_number)||
                isset($body->photo)) {

                $tab  = 'edit';

                return redirect()
                    ->action('AuthController@show')
                    ->with('error', $body)
                    ->with('old', $data)
                    ->with('tab', $tab);

            }





            flash($body)->error()->important();



            return redirect()->route('user.profile');

        }

