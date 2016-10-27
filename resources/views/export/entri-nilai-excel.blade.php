<html>
    <table>
        <tr>
            <td></td>
            <td>Nama Matakuliah</td>
            <td><b>{{ $matakuliah['namamk'] }}</b></td>
        </tr>
        <tr>
            <td></td>
            <td>Program</td>
            <td><b>{{ $matakuliah['program'] }}</b></td>
        </tr>
        <tr>
            <td></td>
            <td>Kelas</td>
            <td><b>{{ $matakuliah['kelas'] }}</b></td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td><b>No.</b></td>
            <td><b>NIM</b></td>
            <td><b>Nama Mahasiswa</b></td>
            <td><b>Absen</b></td>
            <td><b>Tugas</b></td>
            <td><b>UTS</b></td>
            <td><b>UAS</b></td>
            <td><b>Total</b></td>
            <td><b>Nilai Huruf</b></td>
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
    
    

</html>