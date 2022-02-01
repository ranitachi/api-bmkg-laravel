@extends('layout.master')

@section('konten')
<div class="container">
    <div class="row">
        <div class="col-md-12">

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
                            <option value="{{ $i }}" {{ date('n')==$i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    </div>
                    <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Tahun</label>
                    <select class="form-control" id="bulan" name="tahun">
                        @for ($i = (date('Y')-2); $i <= date('Y'); $i++)
                            <option value="{{ $i }}" {{ date('Y')==$i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>
    </div>
</div>
@endsection
