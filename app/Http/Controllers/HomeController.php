<?php

namespace App\Http\Controllers;

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
}
