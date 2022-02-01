@extends('layout.master')

@section('konten')
<div class="row">
    <div class="col-md-12">
        <div class="container">
            <form action="{{ url('absen-detail') }}">
                <div class="form-group">
                <label for="exampleInputEmail1">&nbsp;</label>
                <input type="text" class="form-control" name="nip" id="exampleInputEmail1" aria-describedby="nip" placeholder="NIP">
                </div>
                <div class="row">

                    <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Bulan</label>
                    <select class="form-control" id="bulan" name="bulan">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $request->bulan==$i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    </div>
                    <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Tahun</label>
                    <select class="form-control" id="bulan" name="tahun">
                        @for ($i = (date('Y')-2); $i <= date('Y'); $i++)
                            <option value="{{ $i }}" {{ $request->tahun==$i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
          <hr>
        </div>
        <div class="container-fluid">
            <form action="{{ url('absen-simpan') }}" method="POST">
                @csrf
                <input type="hidden" name="bulan" value="{{ $request->bulan }}">
                <input type="hidden" name="tahun" value="{{ $request->tahun }}">
                <input type="hidden" name="nip" value="{{ $request->nip }}">
                <fieldset>
                    <legend>Detail Absensi</legend>
                    <div class="row">
                        <div class="col-md-1">NIP</div>
                        <div class="col-md-10">: {{ $request->nip }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">Bulan</div>
                        <div class="col-md-10">: {{ $request->bulan }} - {{ $request->tahun }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-inverse table-responsive" style="width: 100%;display:inline-table !important;">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Set Datang</th>
                                        <th>SN Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Set Pulang</th>
                                        <th>SN Pulang</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Status Prev</th>
                                        <th>Tel Datang</th>
                                        <th>Cep Pulang</th>
                                        <th>Leb Pulang</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 1; $i <= $jlhHari; $i++)
                                            @php
                                                if(isset($getAbsen[$i]))
                                                {
                                                    if($getAbsen[$i]->status == 4){
                                                        $readonly = 'readonly';
                                                    } else {
                                                        $readonly = '';
                                                    }
                                                } else {
                                                    $readonly = '';
                                                }
                                            @endphp
                                            <input type="hidden" {{ $readonly }} name="id_absen[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->id_absen : '' }}">
                                            <input type="hidden" {{ $readonly }} name="kunker[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->kunker : '' }}">
                                            <input type="hidden" {{ $readonly }} name="id_hari_kerja[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->id_hari_kerja : '' }}">
                                            <input type="hidden" {{ $readonly }} name="stat_ijn[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->stat_ijn : '' }}">
                                            <tr>
                                                <td scope="row">{{ $i }}</td>
                                                <td>
                                                    <input type="date" {{ $readonly }} name="tanggal[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->tanggal : '' }}" class="form-control" style="font-size:10px !important;width:125px !important;min-width:50px !important;">
                                                </td>
                                                <td>
                                                    <input type="text" {{ $readonly }} id="jam_datang_{{ $i }}" onkeyup="hitungdatang({{ $i }})" name="jam_datang[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->datang : '' }}" class="form-control" style="font-size:10px !important;width:80px !important;min-width:50px !important;">
                                                </td>
                                                <td>
                                                    <input type="text" {{ $readonly }} id="set_datang_{{ $i }}" onkeyup="hitungdatang({{ $i }})" name="set_datang[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->set_datang : '' }}" class="form-control" style="font-size:10px !important;width:85px !important;min-width:50px !important;">
                                                </td>
                                                <td>
                                                    <input type="text" {{ $readonly }} name="sn_datang[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->sn_datang : '' }}" class="form-control" style="font-size:10px !important;width:150px !important;min-width:50px !important;">
                                                </td>
                                                <td>
                                                    <input type="text" {{ $readonly }} id="jam_pulang_{{ $i }}" onkeyup="hitungpulang({{ $i }})" name="jam_pulang[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->pulang : '' }}" class="form-control" style="font-size:10px !important;width:80px !important;min-width:50px !important;">
                                                </td>
                                                <td>
                                                    <input type="text" {{ $readonly }} id="set_pulang_{{ $i }}" onkeyup="hitungpulang({{ $i }})" name="set_pulang[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->set_pulang : '' }}" class="form-control" style="font-size:10px !important;width:80px !important;min-width:50px !important;">
                                                </td>
                                                <td>
                                                    <input type="text" {{ $readonly }} name="sn_pulang[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->sn_pulang : '' }}" class="form-control" style="font-size:10px !important;width:150px !important;min-width:50px !important;">
                                                </td>
                                                <td>
                                                    <input type="text" {{ $readonly }} name="keterangan[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->keterangan : '' }}" class="form-control" style="font-size:10px !important;width:200px !important;min-width:50px !important;">
                                                </td>
                                                <td>
                                                    <input type="number" {{ $readonly }} name="status[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->status : '' }}" class="form-control" style="font-size:10px !important;width:20px !important;min-width:50px !important;">
                                                </td>
                                                <td>
                                                    <input type="number" {{ $readonly }} name="status_prev[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->status_prev : '' }}" class="form-control" style="font-size:10px !important;width:20px !important;min-width:50px !important;">
                                                </td>
                                                <td>
                                                    <input type="text" {{ $readonly }} id="tel_datang_{{ $i }}" name="telat_datang[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->tel_datang : '' }}" class="form-control" style="font-size:10px !important;width:80px !important;min-width:50px !important;">
                                                </td>
                                                <td>
                                                    <input type="text" {{ $readonly }} id="cep_pulang_{{ $i }}" name="cepat_pulang[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->cep_pulang : '' }}" class="form-control" style="font-size:10px !important;width:80px !important;min-width:50px !important;">
                                                </td>
                                                <td>
                                                    <input type="text" {{ $readonly }} id="leb_pulang_{{ $i }}" name="lebih_pulang[{{ $i }}]" value="{{ isset($getAbsen[$i]) ? $getAbsen[$i]->leb_pulang : '' }}" class="form-control" style="font-size:10px !important;width:80px !important;min-width:50px !important;">
                                                </td>
                                            </tr>
                                        @endfor

                                    </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary">Simpan Absen</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
@endsection
@section('footscript')
<script>
    function hitungdatang(tgl){

        var waktuMulai = $('#jam_datang_'+tgl).val();
        var waktuSelesai = $('#set_datang_'+tgl).val();

        var hours = waktuMulai.split(':')[0] - waktuSelesai.split(':')[0]
        var minutes = waktuMulai.split(':')[1] - waktuSelesai.split(':')[1]
        var second = waktuMulai.split(':')[2] - waktuSelesai.split(':')[2]



        if(hours >= 0){

            if(minutes >= 0){

                minutes = (Math.abs(minutes));
                hours = (Math.abs(hours));
                second = (Math.abs(second));
                // alert(selisihMiliDetik)
                minutes = minutes.toString().length<2?'0'+minutes:minutes;
                hours = hours.toString().length<2?'0'+hours:hours;
                second = second.toString().length<2?'0'+second:second;

                var selisih = hours+ ':' + minutes +':'+second

                $('#tel_datang_'+tgl).val(selisih)
            } else {
                $('#tel_datang_'+tgl).val('')
            }
        } else {
            $('#tel_datang_'+tgl).val('')
        }

    }
    function hitungpulang(tgl){

        var waktuMulai = $('#jam_pulang_'+tgl).val();
        var waktuSelesai = $('#set_pulang_'+tgl).val();

        var hours = waktuMulai.split(':')[0] - waktuSelesai.split(':')[0]
        var minutes = waktuMulai.split(':')[1] - waktuSelesai.split(':')[1]
        var second = waktuMulai.split(':')[2] - waktuSelesai.split(':')[2]




        if(hours >= 0){
            minutes = (Math.abs(minutes));
            hours = (Math.abs(hours));
            second = (Math.abs(second));

            hours = hours.toString().length < 2?'0'+hours:hours;
            minutes = minutes.toString().length < 2?'0'+minutes:minutes;
            second = second.toString().length < 2?'0'+second:second;

            var selisih = hours+ ':' + minutes +':'+second

            $('#leb_pulang_'+tgl).val(selisih)
            $('#cep_pulang_'+tgl).val('')
        } else {
            minutes = (Math.abs(minutes));
            hours = (Math.abs(hours));
            second = (Math.abs(second));

            hours = hours.toString().length < 2?'0'+hours:hours;
            minutes = minutes.toString().length < 2?'0'+minutes:minutes;
            second = second.toString().length < 2?'0'+second:second;

            var selisih = hours + ':' + minutes +':'+second

            $('#cep_pulang_'+tgl).val(selisih)
            $('#leb_pulang_'+tgl).val('')
        }

    }
</script>

@endsection
