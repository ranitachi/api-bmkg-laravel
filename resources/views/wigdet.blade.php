<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Weather App</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">

  <link href="{{ asset('css') }}/site.css" rel="stylesheet">
</head>
<body>

<main class="main-container">

  <div class="location-and-date">
    <div style="width:100%;float:left">
      <div style="width:50%;float:left">
        <h1 class="location-and-date__location" style="font-size:20px;">
          {{ $daerah }}
        </h1>
      </div>
      <div style="width:50%;float:left">
        <h1 class="location-and-date__location" style="font-size:20px;">
            {{ $kota }}
          {{-- <select name="nama_kota" onchange="ubah(this.value)" class="form-control" style="height:35px;padding:5px 10px;width:200px;">
            @foreach ($alldaerah as $item)
                @if($item == $kota)
                  <option value="{{ $kota }}" selected="selected">{{ $kota }}</option>
                @endif
            @endforeach
          </select> --}}
        </h1>
      </div>
    </div>
    {{-- <div class="row" style="width:100%;float:left">
        <div class="col-md-6" style="width:49%;float:left">
            <div style="font-size:12px;">Last Update : {{ \App\Helpers\DateHelper::hari(date('D',strtotime($tgl))) }}, {{ date('d/m/Y',strtotime($tgl)) }} {{ $wkt }} WIB</div>
                <div class="current-temperature">

                    <div class="current-temperature__icon-container">
                    <img src="{{ asset('svg') }}/mostly-sunny.svg" class="current-temperature__icon" alt="">
                    </div>
                    <div class="current-temperature__content-container">
                    <div class="current-temperature__value">{{ isset($suhu[key($suhu)]) ? $suhu[key($suhu)] : '-' }}&deg;</div>
                    <div class="current-temperature__summary">Mostly Sunny</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="width:48%;float:right;">
                <div class="current-stats" style="padding-left:20px;margin-top:30px;width:100%">
                    <div style="width:100% !important;">
                        <div class="current-stats__value">{{ isset($tmax[key($tmax)]) ? $tmax[key($tmax)] : '' }}&deg;</div>
                        <div class="current-stats__label">High</div>
                        <div class="current-stats__value">{{ isset($tmin[key($tmin)]) ? $tmin[key($tmin)] : '' }}&deg;</div>
                        <div class="current-stats__label">Low</div>
                    </div>
                    <div style="width:100% !important;">
                        <div class="current-stats__value">7mph</div>
                        <div class="current-stats__label">Wind</div>
                        <div class="current-stats__value">0%</div>
                        <div class="current-stats__label">Rain</div>
                    </div>
                    <div style="width:100% !important;">
                        <div class="current-stats__value">05:27</div>
                        <div class="current-stats__label">Sunrise</div>
                        <div class="current-stats__value">20:57</div>
                        <div class="current-stats__label">Sunset</div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}



  <div class="weather-by-hour" style="margin-top:100px;">
    <h2 class="weather-by-hour__heading">Today's weather {{ date('D, j/m') }}</h2>
    <div class="weather-by-hour__container">
        @if (isset($data['data'][0]['parameter']))
            @foreach ($data['data'][0]['parameter'] as $item)
                @if ($item['id'] == 't')
                    @foreach ($item['nilai'] as $nilai)
                        @if (date('d-m-Y') == date('d-m-Y', strtotime($nilai['waktu'])))
                            <div class="weather-by-hour__item">
                                <div class="weather-by-hour__hour">{{ date('H:i:s', strtotime($nilai['waktu'])) }}</div>
                                <img src="{{ asset('svg') }}/mostly-sunny.svg" alt="Mostly sunny">
                                <div>{{ isset($nilai['value'][0]) ? $nilai['value'][0] : 0 }}&deg;</div>
                            </div>
                        @endif
                    @endforeach
                @endif
            @endforeach
        @endif
      {{-- <div class="weather-by-hour__item">
        <div class="weather-by-hour__hour">3am</div>
        <img src="{{ asset('svg') }}/mostly-sunny.svg" alt="Mostly sunny">
        <div>14&deg;</div>
      </div>
      <div class="weather-by-hour__item">
        <div class="weather-by-hour__hour">6am</div>
        <img src="{{ asset('svg') }}/mostly-sunny.svg" alt="Mostly sunny">
        <div>16&deg;</div>
      </div>
      <div class="weather-by-hour__item">
        <div class="weather-by-hour__hour">9am</div>
        <img src="{{ asset('svg') }}/mostly-sunny.svg" alt="Mostly sunny">
        <div>17&deg;</div>
      </div>
      <div class="weather-by-hour__item">
        <div class="weather-by-hour__hour">12pm</div>
        <img src="{{ asset('svg') }}/mostly-sunny.svg" alt="Mostly sunny">
        <div>19&deg;</div>
      </div>
      <div class="weather-by-hour__item">
        <div class="weather-by-hour__hour">3pm</div>
        <img src="{{ asset('svg') }}/sunny.svg" alt="Sunny">
        <div>21&deg;</div>
      </div>
      <div class="weather-by-hour__item">
        <div class="weather-by-hour__hour">6pm</div>
        <img src="{{ asset('svg') }}/sunny.svg" alt="Sunny">
        <div>20&deg;</div>
      </div>
      <div class="weather-by-hour__item">
        <div class="weather-by-hour__hour">9pm</div>
        <img src="{{ asset('svg') }}/mostly-sunny.svg" alt="Mostly sunny">
        <div>18&deg;</div>
      </div> --}}
    </div>
  </div>


  <div class="next-5-days">
    <h2 class="next-5-days__heading">Next 2 days</h2>
    <div class="next-5-days__container">

        @if (isset($data['data'][0]['parameter']))
            @foreach ($data['data'][0]['parameter'] as $item)
                @if ($item['id'] == 't')
                    @foreach ($item['nilai'] as $nilai)
                        @if (date('d-m-Y') != date('d-m-Y', strtotime($nilai['waktu'])))

                        @endif
                    @endforeach
                @endif
            @endforeach
        @endif

    @for ($i = (date('d')+1); $i <= (date('d')+2); $i++)
        <div class="next-5-days__row">

            <div class="next-5-days__date">
                {{ date('D', strtotime(date('Y').'-'.date('m').'-'.$i)) }}
                <div class="next-5-days__label">{{ $i }}/{{ date('n') }}</div>
            </div>
            @foreach ($data['data'][0]['parameter'][1]['nilai'] as $item)
                    @if ($i.'-'.date('m-Y') == date('j-m-Y', strtotime($item['waktu'])))
                        <div class="next-5-days__low">
                            {{ $item['value'][0] }}&deg;
                            <div class="next-5-days__label">{{ date('H:i:s', strtotime($item['waktu'])) }}</div>
                        </div>
                    @endif
            @endforeach
        </div>
    @endfor

    </div>
  </div>

</main>

</body>
<script>
  function ubah(val)
  {
    location.href="{{ url('wigdet') }}/{{ $daerah }}/"+val
  }
</script>
</html>
