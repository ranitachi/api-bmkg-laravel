<?php
namespace App\Helpers;

class PerkiraanCuaca
{
    // creator
    private $_name;
    private $_homepage;
    private $_telegram;
    private $_github;

    // bmkg
    private $_bmkg;

    public function __construct()
    {
        // creator
        // $this->_name           = "Muhammad Hanif";
        // $this->_homepage       = "https://hanifmu.com";
        // $this->_telegram       = "https://t.me/hanifmu";
        // $this->_source_code    = "https://github.com/muhammadhanif/php-bmkg-gempa-geojson.git";

        // bmkg
        $this->_bmkg           = "BMKG (Badan Meteorologi, Klimatologi, dan Geofisika)";
    }
    public function getDataPerkiraan($daerah)
    {
        $url    = 'https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-'.$daerah.'.xml';
        $data   = 'Perkiraan Cuaca Daerah '.$daerah;

        $bmkg   = $this->_data($url);

        // return $bmkg;
        // BMKG
        $result['data_source']['institution']   = $this->_bmkg;
        $result['data_source']['data']          = $data;
        $result['data_source']['url']           = $url;
        
        if ($bmkg['success']) {
            // success
            $result['success'] = true;
            $result['issue']['timestamp'] = $bmkg['data']['forecast']['issue']['timestamp'];
            $result['issue']['year'] = $bmkg['data']['forecast']['issue']['year'];
            $result['issue']['month'] = $bmkg['data']['forecast']['issue']['month'];
            $result['issue']['day'] = $bmkg['data']['forecast']['issue']['day'];
            $result['issue']['hour'] = $bmkg['data']['forecast']['issue']['hour'];
            $result['issue']['minute'] = $bmkg['data']['forecast']['issue']['minute'];
            $result['issue']['second'] = $bmkg['data']['forecast']['issue']['second'];

            // $result['data'] = array();
            for ($i = 0; $i < count($bmkg['data']['forecast']['area']); $i++) {
                $result['data'][$i]['nama_daerah'] = $bmkg['data']['forecast']['area'][$i]['name'][0];
                $result['data'][$i]['koordinat']['latitude'] = $bmkg['data']['forecast']['area'][$i]['@attributes']['latitude'];
                $result['data'][$i]['koordinat']['longitude'] = $bmkg['data']['forecast']['area'][$i]['@attributes']['longitude'];


                if(isset($bmkg['data']['forecast']['area'][$i]['parameter']))
                {
                    for ($j = 0; $j < count($bmkg['data']['forecast']['area'][$i]['parameter']); $j++) {
                        $jenis = $bmkg['data']['forecast']['area'][$i]['parameter'][$j]['@attributes']['description'];
                        $id = $bmkg['data']['forecast']['area'][$i]['parameter'][$j]['@attributes']['id'];
                        $type = $bmkg['data']['forecast']['area'][$i]['parameter'][$j]['@attributes']['type'];
    
                        $result['data'][$i]['parameter'][$j][$id] = $id;
                        $result['data'][$i]['parameter'][$j][$jenis] = $jenis;
                        $result['data'][$i]['parameter'][$j][$type] = $type;
    
                        for ($x = 0; $x < count($bmkg['data']['forecast']['area'][$i]['parameter'][$j]['timerange']); $x++) {
    
                            $waktu = $bmkg['data']['forecast']['area'][$i]['parameter'][$j]['timerange'][$x]['@attributes']['datetime'];
                            $result['data'][$i]['parameter'][$j]['nilai'][$x]['waktu'] = date('d-m-Y H:i:s',strtotime($waktu));
    
                            // var_dump($bmkg['data']['forecast']['area'][$i]['parameter'][$j]['timerange'][$x]['value']);
                            
                                for ($y = 0; $y < count($bmkg['data']['forecast']['area'][$i]['parameter'][$j]['timerange'][$x]); $y++) {
                                    
                                    $value = $bmkg['data']['forecast']['area'][$i]['parameter'][$j]['timerange'][$x]['value'];
    
                                    $result['data'][$i]['parameter'][$j]['nilai'][$x]['value'] = $value;
                                }
                            
                            // $satuan = $bmkg['data']['forecast']['area'][$i]['parameter'][$j]['timerange'][$x]['value']['@attributes']['unit'];
    
                            // $result['data'][$i]['parameter'][$j]['nilai'][$x]['satuan'] = $satuan;
                        }
    
                        // array_push($result['data']['parameter'],$parameter);
                    }

                }

                // array_push($result['data'], $cuaca);
            }
        } else {
            $result['success'] = false;
        }

        // header
        // header('HTTP/1.1 200 OK');
        // header('Content-Type: application/json');

        // return json_encode($result);
        return $result;
    }

   
    private function _curl($url)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($ch);

        curl_close($ch);
    }

    private function _data($url)
    {
        $curl  = $this->_curl($url);

        $result['data']     = array();

        // validation
        if (strpos($curl, "html") or $curl === false) {
            // error
            $result['success']  = false;
        } else {
            // success
            $result['success']  = true;
            $result['data']     = json_decode(json_encode(simplexml_load_string($curl)), TRUE);
        }

        return $result;
    }
}
?>