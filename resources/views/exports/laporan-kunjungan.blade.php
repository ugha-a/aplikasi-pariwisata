<table class="table table-bordered">
    <thead>
        <tr>
            <th>1 Hari</th>
            <th>1 Minggu</th>
            <th>1 Bulan</th>
            <th>Keseluruhan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $visitStats['hari_ini'] }}</td>
            <td>{{ $visitStats['minggu'] }}</td>
            <td>{{ $visitStats['bulan'] }}</td>
            <td>{{ $visitStats['total'] }}</td>
        </tr>
    </tbody>
</table>
