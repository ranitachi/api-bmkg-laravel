<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    public function index(){
        return view('absen.index');
    }

    public function detail(Request $request){
        // return $request;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nip = $request->nip;

        $bln = $bulan<10 ? '0'.$bulan : $bulan;

        $table = 'absensi_harian_'.$tahun.$bln;
        // return $table;
        $getAbsens = DB::table($table)->where('nip', $nip)->orderBy('tanggal')->get();

        $getAbsen = array();
        foreach($getAbsens as $item){
            $getAbsen[date('j',strtotime($item->tanggal))] = $item;
        }

        $jlhHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // return $getAbsen;
        return view('absen.detail')
                ->with('jlhHari', $jlhHari)
                ->with('request', $request)
                ->with('getAbsen', $getAbsen);
    }

    public function simpan(Request $request){
        // return $request;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nip = $request->nip;

        $bln = $bulan<10 ? '0'.$bulan : $bulan;
        $table = 'absensi_harian_'.$tahun.$bln;
        $tablelog = 'absensi_log_'.$tahun.$bln;

        $getLogAbsens = DB::table($tablelog)->where('nip', $nip)->delete();
        $getMesins = DB::table('mesin_absensi')->get();
        $getMesin = array();
        foreach($getMesins as $item){
            $getMesin[$item->serial_number] = $item;
        }

        // return $getMesin;
        $id_absen = $request->id_absen;
        $tanggal = $request->tanggal;
        $datang = $request->jam_datang;
        $set_datang = $request->set_datang;
        $sn_datang = $request->sn_datang;
        $pulang = $request->jam_pulang;
        $set_pulang = $request->set_pulang;
        $sn_pulang = $request->sn_pulang;
        $keterangan = $request->keterangan;
        $status = $request->status;
        $status_prev = $request->status_prev;
        $tel_datang = $request->telat_datang;
        $cep_pulang = $request->cepat_pulang;
        $leb_pulang = $request->lebih_pulang;
        $kunker = $request->kunker;
        $id_hari_kerja = $request->id_hari_kerja;
        $stat_ijn = $request->stat_ijn;
        $res = [];

        foreach($tanggal as $tgl => $item){

            $data['nip'] = 	$nip;
            $data['kunker'] = isset($kunker[$tgl]) ? $kunker[$tgl] : null;
            $data['id_hari_kerja'] = isset($id_hari_kerja[$tgl]) ? $id_hari_kerja[$tgl] : null;
            $data['tanggal'] = isset($tanggal[$tgl]) ? $tanggal[$tgl] : null;
            $data['datang'] = isset($datang[$tgl]) ? $datang[$tgl] : null;
            $data['sn_datang'] = isset($sn_datang[$tgl]) ? $sn_datang[$tgl] : null;
            $data['pulang'] = isset($pulang[$tgl]) ? $pulang[$tgl] : null;
            $data['sn_pulang'] = isset($sn_pulang[$tgl]) ? $sn_pulang[$tgl] : null;
            $data['keterangan'] = isset($keterangan[$tgl]) ? $keterangan[$tgl] : null;
            $data['set_datang'] = isset($set_datang[$tgl]) ? $set_datang[$tgl] : null;
            $data['set_pulang'] = isset($set_pulang[$tgl]) ? $set_pulang[$tgl] : null;
            $data['tel_datang'] = isset($tel_datang[$tgl]) ? $tel_datang[$tgl] : null;
            $data['cep_pulang'] = isset($cep_pulang[$tgl]) ? $cep_pulang[$tgl] : null;
            $data['leb_pulang'] = isset($leb_pulang[$tgl]) ? $leb_pulang[$tgl] : null;
            $data['status'] = isset($status[$tgl]) ? $status[$tgl] : null;
            $data['status_prev'] = isset($status_prev[$tgl]) ? $status_prev[$tgl] : null;

            if($item!=null){
                if(isset($id_absen[$tgl])){


                    $result = DB::table($table)
                                ->where('id_absen', $id_absen[$tgl])
                                ->update($data);

                    // if($result){
                    $res['update'][] = $id_absen[$tgl];
                    // }

                } else {
                    $result = DB::table($table)
                                ->insert($data);

                    // if($result){
                    $res['insert'][] = $id_absen[$tgl];
                }

                if($status[$tgl]!=4){

                    if($stat_ijn[$tgl]==null){

                        $serial_number_datang = $sn_datang[$tgl];
                        $log['serial_number'] = $serial_number_datang;
                        $log['pin'] = null;
                        $log['nip'] = $nip;
                        $log['tanggal'] = $item.' '.(isset($datang[$tgl]) ? $datang[$tgl] : null);
                        $log['status'] = null;
                        $log['ip_public'] = isset($getMesin[$serial_number_datang]) ? $getMesin[$serial_number_datang]->ip_publik : '0.0.0.0';
                        // return $log;
                        DB::table($tablelog)->insert($log);

                        $serial_number_pulang = $sn_pulang[$tgl];
                        $log['serial_number'] = $serial_number_pulang;
                        $log['pin'] = null;
                        $log['nip'] = $nip;
                        $log['tanggal'] = $item.' '.(isset($pulang[$tgl]) ? $pulang[$tgl] : null);
                        $log['status'] = null;
                        $log['ip_public'] = isset($getMesin[$serial_number_pulang]) ? $getMesin[$serial_number_pulang]->ip_publik : '0.0.0.0';
                        // return $log;
                        DB::table($tablelog)->insert($log);
                    }
                }
            }

        }
        return redirect('absen-detail?nip='.$request->nip.'&bulan='.$request->bulan.'&tahun='.$request->tahun);
    }
}
