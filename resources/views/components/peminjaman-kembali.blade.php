<div>
<table class="table table-bordered align-items-center table-flush bordered" id="dataTable">
        <thead class="thead-light">
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
        <?php
        $i = $peminjamankembali->firstItem();
        ?>
        <tbody>
            @foreach($peminjamankembali as $item)
            <tr>
                @if($item->user && $item->user->deleted_at === null && $item->book && $item->book->deleted_at === null)
                <td>{{ $i++}}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->user->username }}</td>
                <td>{{ $item->book->title }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ \Carbon\Carbon::parse($item->borrow_date)->locale('id_ID')->isoFormat('D MMMM YYYY') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->return_date)->locale('id_ID')->isoFormat('D MMMM YYYY') }}</td>
                <td>
                    @if($item->actual_return_date)
                    {{ \Carbon\Carbon::parse($item->actual_return_date)->locale('id_ID')->isoFormat('D MMMM YYYY') }}
                    @else
                    <span class="badge badge-warning">Belum Dikembalikan</span>
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

            @if(count($peminjamankembali) === 0)
            <div class="alert alert-danger">
                Tidak Ada Data Untuk Ditampilkan
            </div>
            @endif
        </tbody>
    </table>
</div>