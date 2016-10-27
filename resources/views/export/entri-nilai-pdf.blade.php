<html>
    
    <style>
        body {
            font-family: 'Helvetica'
        }
        table, th, td {
           border: 1px solid black;
           font-size: 12px;
        },
        table {
            border-collapse: collapse;
        },
        table {
            width: 100%;
        }

        th {
            height: 30px;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        tr:nth-child(even) {background-color: #f2f2f2}

        p {
            margin-bottom: 0;
            margin-top : 0;
        }
    </style>
    
    <body>
        <img src="{{ asset('images/siakad-untan.png') }}" alt="">
        <h2 style="margin-bottom: 0px;">Daftar Nilai Sistem Informasi Akademik</h2>
        <h3 style="margin-top: 0px;">Universitas Tanjungpura</h3>

        <?php $profil = session()->get('dosen'); ?>

        <p>Nama Matakuliah: {{ $matakuliah['namamk'] }}</p>
        <p>Kode Matakuliah: {{ $matakuliah['kodemk'] }}</p>
        <p>Program: {{ $matakuliah['program'] }}</p>
        <p>Kelas: {{ $matakuliah['kelas'] }}</p>
        <br>
        <p>Dosen Pengampu: {{ $profil['gelardpn'].' '.ucwords(strtolower($profil['nama'])).' '.$profil['gelarblk']  }}</p>
        
        <br><br>

        <table>
            <tr>
                <th><b>No.</b></th>
                <th><b>NIM</b></th>
                <th><b>Nama Mahasiswa</b></th>
                <th><b>Absen</b></th>
                <th><b>Tugas</b></th>
                <th><b>UTS</b></th>
                <th><b>UAS</b></th>
                <th><b>Total</b></th>
                <th><b>Nilai Huruf</b></th>
            </tr>
            @foreach($mahasiswa as $key => $value)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $value['nim'] }}</td>
                <td>{{ $value['nama'] }}</td>
                <td>{{ $value['absen'] }}</td>
                <td>{{ $value['tugas'] }}</td>
                <td>{{ $value['uts'] }}</td>
                <td>{{ $value['uas'] }}</td>
                <td>{{ $value['nilaitotal'] }}</td>
                <td>{{ $value['nilaihuruf'] }}</td>
            </tr>
            @endforeach
        </table>



    </body>

    
    
    

</html>