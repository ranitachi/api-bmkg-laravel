<?php

namespace App\Http\Controllers;


use File;
use Storage;
use App\Helpers\Bmkg;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use Orchestra\Parser\Xml\Facade as XmlParser;

class ApiController extends Controller
{
    function perkiraan_cuaca($daerah=null)
    {
        if($daerah!=null)
        {
            $url = 'https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-'.$daerah.'.xml';
            $guzzleClient = new Client();
            $response = $guzzleClient->get($url);
            $body = $response->getBody();
            $body->seek(0);
            $size = $body->getSize();
            $file = $body->read($size);
            // return $file;
            // File::put(storage_path('app/public/'), $file.'txt');
            Storage::disk('public')->put($daerah.'.txt', $body);

            $get = simplexml_load_string(storage_path('app/public/'.$daerah.'.txt'));
            // $get = json_decode(json_encode(simplexml_load_string(public_path('storage/'.$daerah.'.txt'))), TRUE);

            return $get;
            // Then you can do stuff with your file locally on your server
            // $xml = $reader->load('STORAGE_PATH');
            // $xml = XmlParser::load(storage_path('app/public/'.$daerah.'.txt'));
            // $xml = XmlParser::load(public_path('storage/contoh.txt'));
            // $user = $xml->parse([
            //     'id' => ['uses' => 'user.id'],
            //     'email' => ['uses' => 'user.email'],
            //     'followers' => ['uses' => 'user::followers'],
            // ]);

            // $data = $xml->parse([
            //     'domain' => ['uses' => 'forecast::domain'],
            //     'timestamp' => ['uses' => 'forecast.issue.timestamp'],
            //     'year' => ['uses' => 'forecast.issue.year'],
            //     'month' => ['uses' => 'forecast.issue.month'],
            //     'day' => ['uses' => 'forecast.issue.day'],
            //     'hour' => ['uses' => 'forecast.issue.hour'],
            //     'minute' => ['uses' => 'forecast.issue.minute'],
            //     'second' => ['uses' => 'forecast.issue.second'],
            //     'area_id' => ['uses' => 'forecast.area::id']
            // ]);
            // return $data;
            // $xmlString = file_get_contents($url);
            // $xmlObject = simplexml_load_string($xmlString);
                       
            // $json = json_encode($xmlObject);
            // $phpArray = json_decode($json, true); 
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
}
