<?php

namespace App\Http\Controllers;

use App\Helpers\Bmkg;
use Illuminate\Http\Request;
use App\Helpers\PerkiraanCuaca;

class HomeController extends Controller
{
    public function wigdet($daerah=null,$kota=null)
    {
        if($daerah==null)
            $daerah = 'JawaBarat';

        $bmkg = new PerkiraanCuaca; 

        if($kota==null)
        {
            $kota = 'Kota Bogor';
        }

        // return $kota;
            $kota = str_replace('%20',' ',$kota);
            $data = $bmkg->getDataPerkiraan($daerah,$kota);
        // }
        // else
        //     $data = $bmkg->getDataPerkiraan($daerah,'');

        // return $data;

        $alldaerah = $data['nama_daerah'];
        $tgl = $data['issue']['year'].'-'.$data['issue']['month'].'-'.$data['issue']['day'];
        $wkt = $data['issue']['hour'].':'.$data['issue']['minute'].':'.$data['issue']['second'];
        // return $data;
        $suhu = $tmin = $tmax = $wd = array();
        $parameter = $data['data'][0]['parameter'];
        $now = strtotime(date('H:i:s'));
        // $now = date('H:i:s');
        foreach($parameter as $key => $item)
        {
            if(in_array($item['id'],['t','tmin','tmax','wd']))
            {
                // return $item;
                foreach($item['nilai'] as $idx => $val)
                {
                        list($tgl,$wkt) = explode(' ',$val['waktu']);
                        // return strtotime($tgl.' 00:00:00').'-'.$now;
                        if(strtotime(date('Y-m-d')) === strtotime(date('Y-m-d',strtotime($tgl))))
                        {

                            if($item['id']=='tmin')
                                $tmin[$tgl] = $val['value'][0]; 

                            if($item['id']=='tmax')
                                $tmax[$tgl] = $val['value'][0]; 
                            
                            if($item['id']=='wd')
                                $tmax[$tgl] = $val['value'][0]; 

                            if($item['id'] == 't')
                            {

                                // return $tgl.'='.strtotime($tgl.' 00:00:00')."-".$now;
                                if($now > strtotime($tgl.' 00:00:00') && $now < strtotime($tgl." 06:00:00"))
                                {
                                    if(isset($val['value'][0]))
                                        $suhu["00:00:00"] = $val['value'][0];
                                    else
                                        $suhu["00:00:00"] = $val['value'];
                                }
                                elseif($now > strtotime($tgl.' 06:00:00') && $now < strtotime($tgl." 12:00:00"))
                                {
                                    if(isset($val['value'][0]))
                                        $suhu["06:00:00"] = $val['value'][0];
                                    else
                                        $suhu["06:00:00"] = $val['value'];
                                }
                                elseif($now > strtotime($tgl.' 12:00:00') && $now < strtotime($tgl." 18:00:00"))
                                {
                                    if(isset($val['value'][0]))
                                        $suhu["12:00:00"] = $val['value'][0];
                                    else
                                        $suhu["12:00:00"] = $val['value'];
                                }
                                elseif($now > strtotime($tgl.' 18:00:00') && $now < strtotime($tgl." 23:59:59"))
                                {
                                    if(isset($val['value'][0]))
                                        $suhu["18:00:00"] = $val['value'][0];
                                    else
                                        $suhu["18:00:00"] = $val['value'];
                                }
                            }
                        }
                }
            }

            // if($item['id']=='tmin')
            // {
            //     foreach($item['nilai'] as $idx => $val)
            //     {

            //     }
            // }
        }
        return $suhu;
        return view('wigdet')
                ->with('daerah',$daerah)
                ->with('tmin',$tmin)
                ->with('tmax',$tmax)
                ->with('alldaerah',$alldaerah)
                ->with('tgl',$tgl)
                ->with('suhu',$suhu)
                ->with('wkt',$wkt)
                ->with('kota',$kota)
                ->with('data',$data);
    }

    public function table_gempa_m5($daerah=null,$kota=null)
    {
        $bmkg = new Bmkg; 

        $data = $bmkg->getGempaM5();

        // return $data['data'];
        return view('table')
                ->with('data',$data['data']);
    }
}
