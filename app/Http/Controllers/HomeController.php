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

        if($kota!=null)
        {
            $kota = str_replace('%20',' ',$kota);
            $data = $bmkg->getDataPerkiraan($daerah,$kota);
        }
        else
            $data = $bmkg->getDataPerkiraan($daerah);

        $tgl = $data['issue']['year'].'-'.$data['issue']['month'].'-'.$data['issue']['day'];
        $wkt = $data['issue']['hour'].':'.$data['issue']['minute'].':'.$data['issue']['second'];
        // return $tgl;
        return view('wigdet')
                ->with('daerah',$daerah)
                ->with('tgl',$tgl)
                ->with('wkt',$wkt)
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
