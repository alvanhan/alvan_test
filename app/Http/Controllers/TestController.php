<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\json;
class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $jsondata = 
        '{
            "custom": [
              {
                "type": "parent",
                "id": 1
              },
              {
                "type": "children",
                "id": 2,
                "data": "Hallo Im Apple",
                "parent_id": 1
              },
              {
                "type": "parent",
                "id": 3
              },
              {
                "type": "children",
                "id": 4,
                "data": "Hallo Im Orange",
                "parent_id": 3
              },
              {
                "type": "children",
                "id": 5,
                "data": "Hallo Im Banana",
                "parent_id": 3
              },
              {
                "type": "children",
                "id": 6,
                "data": "Hallo Im Human",
                "parent_id": null
              }
            ]
          }';

        $data = json_decode($jsondata, true);
          
        //   return $data
          $trnsform  = [];

          foreach ($data['custom'] as $item) {
                if ($item['type'] === 'parent') {
                    $trnsform[] = [
                        "type" => "parent",
                        "id" => $item['id'],
                        "data" => [],
                    ];
                }elseif ($item['type'] === 'children') {
                    $lindex = count($trnsform) - 1;
                    $trnsform[$lindex]['data'][] = [
                        "type" => "children",
                        "id" => $item['id'],
                        "data" => $item['data'],
                        "parent_id" => 1,
                    ];
                }
          }

          return $trnsform;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $response  = Http::get('https://pokeapi.co/api/v2/pokemon/');
        $json = $response->json();

        foreach ($json['results'] as $key => $value) {
            $ada = json::where('name', $value['name'])->first();
            if(!$ada){
                $save = new json;
                $save->name = $value['name'];
                $save->url = $value['url'];
                $save->save();
            }
        }

        return "masuk";

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
