<?php

namespace App\Http\Controllers;


use File;
use Storage;
use App\Sensor;
use App\Helpers\Bmkg;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Helpers\SimpleHtmlDom;
use App\Helpers\PerkiraanCuaca;
use GuzzleHttp\Exception\GuzzleException;
use Orchestra\Parser\Xml\Facade as XmlParser;

class ApiController extends Controller
{
    function perkiraan_cuaca($daerah=null)
    {
        $tables = $items = array();
        if($daerah!=null)
        {
            $perkiraan = new PerkiraanCuaca;
            return $perkiraan->getDataPerkiraan($daerah);
        }
        else{
            $dom = new SimpleHtmlDom;
            $html = $dom->file_get_html('https://data.bmkg.go.id/prakiraan-cuaca/');
            // return $html->find('tbody');

            foreach($html->find('tbody tr') as $table) {
                $tables['id'] = $table->find('td', 0)->plaintext;
                $tables['daerah'] = $table->find('td', 1)->plaintext;

                $url = $table->find('td pre a',0)->href;
                $tables['url'] = str_replace('../','https://data.bmkg.go.id/',$url);
                $tables['last_update'] = $table->find('td', 3)->plaintext;
                array_push($items,$tables);
            }

            // return $items;
            return view('index-perkiraan')->with('items',$items);
        }
    }

    public function gempa($jenis=null)
    {
        $bmkg = new Bmkg;
        if ($jenis!=null) {
            $data = $jenis;
        } else {
            $data = null;
        }

        // presentasi data
        $geojson = null;

        switch ($data) {
            case "m-5-terkini":
                // Gempa M 5+ Terkini
                $geojson = $bmkg->getGempaTerkini();
                break;
            case "m-5":
                // 60 Gempabumi M 5.0+
                $geojson = $bmkg->getGempaM5();
                break;
            case "dirasakan":
                // 20 Gempabumi Dirasakan
                $geojson = $bmkg->getGempaDirasakan();
                break;
            default:
                return view('index-gempa');
        }
        return $geojson;
    }

    public function sendDataSensor(Request $request){

        $sensor = new Sensor;
        $sensor->tanggal  = $request->date;
        $sensor->waktu  = $request->time;
        $sensor->tgl_datetime  = $request->date.' '.$request->time;
        $sensor->humidity  = $request->humidity;
        $sensor->ldr  = $request->ldr;
        $sensor->pir  = $request->pir;
        $sensor->temperature  = $request->temperature;
        $sensor->voice  = $request->voice;
        // $sensor->json_text  = $request->json_text;
        $sensor->created_at  = date('Y-m-d H:i:s');
        $sensor->updated_at  = date('Y-m-d H:i:s');
        $sensor->save();

        return $sensor;
    }

    public function listDataSensor(){

        $sensor = Sensor::orderby('id','desc')->limit(10)->get();
        return $sensor;
    }
}
