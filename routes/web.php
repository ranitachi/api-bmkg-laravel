<?php

use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('perkiraan-cuaca/{daerah?}','ApiController@perkiraan_cuaca');

Route::get('gempa/{jenis?}','ApiController@gempa');

Route::get('getGempaTerkiniGeoJson','ApiController@getGempaTerkiniGeoJson');
Route::get('getGempaM5GeoJson','ApiController@getGempaM5GeoJson');
Route::get('getGempaDirasakanGeoJson','ApiController@getGempaDirasakanGeoJson');

Route::get('wigdet/{daerah?}/{kota?}','HomeController@wigdet');

// Route::get('coba-mqtt',function(){
//     $mqtt = MQTT::connection();
//     $mqtt->publish('ESP-Test', '{"val":"HelloWorld"}');
//     // $mqtt->loop(true);

// });

// Route::get('/message', function(Request $request) {
//     // TODO: validate incoming params first!
//     // return $request->all();
//     $url = "https://messages-sandbox.nexmo.com/v0.1/messages";
//     // $params = ["to" => ["type" => "whatsapp", "number" => $request->input('number')],
//     $params = ["to" => ["type" => "whatsapp", "number" => $request->number],
//         // "from" => ["type" => "whatsapp", "number" => "14157386170"],
//         "from" => ["type" => "whatsapp", "number" => "6285214320808"],
//         "message" => [
//             "content" => [
//                 "type" => "text",
//                 "text" => "Nyoba Test Kirim Pesan Dari Laravel"
//             ]
//         ]
//     ];
//     $headers = ["Authorization" => "Basic " . base64_encode(env('NEXMO_API_KEY') . ":" . env('NEXMO_API_SECRET'))];

//     $client = new \GuzzleHttp\Client();
//     $response = $client->request('POST', $url, ["headers" => $headers, "json" => $params]);
//     $data = $response->getBody();
//     Log::Info($data);

//     return 'Berhasil';
// });

// Route::post('/webhooks/inbound', function(Request $request) {
//     $data = $request->all();

//     $text = $data['message']['content']['text'];
//     $number = intval($text);
//     Log::Info($number);
//     if($number > 0) {
//         $random = rand(1, 8);
//         Log::Info($random);
//         $respond_number = $number * $random;
//         Log::Info($respond_number);
//         $url = "https://messages-sandbox.nexmo.com/v0.1/messages";
//         $params = ["to" => ["type" => "whatsapp", "number" => $data['from']['number']],
//             "from" => ["type" => "whatsapp", "number" => "14157386170"],
//             "message" => [
//                 "content" => [
//                     "type" => "text",
//                     "text" => "The answer is " . $respond_number . ", we multiplied by " . $random . "."
//                 ]
//             ]
//         ];
//         $headers = ["Authorization" => "Basic " . base64_encode(env('NEXMO_API_KEY') . ":" . env('NEXMO_API_SECRET'))];

//         $client = new \GuzzleHttp\Client();
//         $response = $client->request('POST', $url, ["headers" => $headers, "json" => $params]);
//         $data = $response->getBody();
//     }
//     Log::Info($data);
// });

// Route::post('/webhooks/status', function(Request $request) {
//     $data = $request->all();
//     Log::Info($data);
// });