<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Peminjaman</title>
    <style>
        #data {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #data td,
        #data th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #data tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #data tr:hover {
            background-color: #ddd;
        }

        #data th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #FFFC9B;
            color: black;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center; font-family: Arial, Helvetica, sans-serif; margin-bottom: 40px; margin-top: 40px;">List Data Log Peminjaman</h1>
    <table id="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Buku</th>
                <th>Jumlah</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Aktual Tgl Pengembalian</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logpeminjaman as $item)
            <tr>
                @if($item->user && $item->user->deleted_at === null && $item->book && $item->book->deleted_at === null)
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->user->username }}</td>
                <td>{{ $item->book->title }}</td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td>{{ \Carbon\Carbon::parse($item->borrow_date)->locale('id_ID')->isoFormat('D MMMM YYYY') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->return_date)->locale('id_ID')->isoFormat('D MMMM YYYY') }}</td>
                <td>
                    @if($item->actual_return_date)
                    {{ \Carbon\Carbon::parse($item->actual_return_date)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                    @else
                    <span style="background-color: yellow; color: black;">Belum Dikembalikan</span>
                    @endif
                </td>
                <td>
                    @php
                    $dueDate = \Carbon\Carbon::parse($item->return_date);
                    $now = \Carbon\Carbon::parse($item->actual_return_date);
                    $lateFee = max(0, $now->greaterThan($dueDate) ? $dueDate->diffInDays($now) : 0) * 1000;
                    @endphp
                    Rp {{ number_format($lateFee, 0, '.', '.') }}
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <script type="text/javascript">
        window.print();
    </script>
</body>

</html>