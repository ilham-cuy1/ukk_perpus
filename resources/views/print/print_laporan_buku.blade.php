<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Data Buku</title>
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
    <h1 style="text-align: center; font-family: Arial, Helvetica, sans-serif; margin-bottom: 40px; margin-top: 40px;">List Data Buku</h1>
    <table style="margin: auto;" id="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Buku</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
                <th>Kategori</th>
                <th>Stok Buku</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$book->book_code}}</td>
                <td>{{$book->title}}</td>
                <td>
                    @if($book->pengarang)
                    {{$book->pengarang}}
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if($book->penerbit)
                    {{$book->penerbit}}
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if($book->tahun_terbit)
                    {{$book->tahun_terbit}}
                    @else
                    -
                    @endif
                </td>
                <td>
                    @foreach($book->categories as $kategori)
                    {{$kategori->name}} <br>
                    @endforeach
                </td>
                <td>{{$book->stock}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>