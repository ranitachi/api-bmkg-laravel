<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Index Perkiraan Cuaca</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }
            .text-left{
                text-align: left !important;
            }
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            table.greyGridTable {
            border: 2px solid #FFFFFF;
            width: 100%;
            text-align: center;
            border-collapse: collapse;
            }
            table.greyGridTable td, table.greyGridTable th {
            border: 1px solid #FFFFFF;
            padding: 3px 4px;
            }
            
            table.greyGridTable tbody td {
            font-size: 13px;
            }
            table.greyGridTable td:nth-child(even) {
            background: #EBEBEB;
            }
            table.greyGridTable thead {
            background: #FFFFFF;
            border-bottom: 4px solid #333333;
            }
            table.greyGridTable thead th {
            font-size: 15px;
            font-weight: bold;
            color: #333333;
            text-align: center;
            border-left: 2px solid #333333;
            }
            table.greyGridTable thead th:first-child {
            border-left: none;
            }

            table.greyGridTable tfoot {
            font-size: 14px;
            font-weight: bold;
            color: #333333;
            border-top: 4px solid #333333;
            }
            table.greyGridTable tfoot td {
            font-size: 14px;
            }
            .text-info{
                color:cornflowerblue !important;
            }
            a{
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    API GEMPA BMKG
                </div>

                <table class="table greyGridTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Daerah</th>
                            <th>Link API</th>
                            <th>Link Asli</th>
                            <th>Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $no=>$item)
                            @php
                                $nama = explode('-',$item['url']);
                                $nama = str_replace('.xml','',$nama[1]);
                            @endphp
                            <tr>
                                <td class="text-center">{{ ($no+1) }}</td>
                                <td class="text-left">{{ ($item['daerah']) }}</td>
                                <td class="text-center"><a href="{{ url('perkiraan-cuaca/'.$nama) }}" target="_blank" class="text-info">Klik Disini</a></td>
                                <td class="text-center"><a href="{{ $item['url'] }}" target="_blank" class="text-info">Klik Disini</a></td>
                                <td class="text-left">{{ date('d-m-Y H:i:s',strtotime($item['last_update'])) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
