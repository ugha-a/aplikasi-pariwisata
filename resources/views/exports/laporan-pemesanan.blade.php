<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Wisata</th>
            <th>1 Hari</th>
            <th>1 Minggu</th>
            <th>1 Bulan</th>
            <th>Keseluruhan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($wisataStats as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row['nama_paket'] }}</td>
                <td>{{ $row['hari_ini'] }}</td>
                <td>{{ $row['minggu'] }}</td>
                <td>{{ $row['bulan'] }}</td>
                <td>{{ $row['total'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>