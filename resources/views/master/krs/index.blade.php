@push('customCss')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/ruangdev/cdn@idn/starterkit/datatables/css/dataTables.bootstrap5.min.css" integrity="sha512-DYpTY0Ub8eZR1nPIgYG0eNVCWim5dFXr834XUOfrVw/5NNRUrPMl8mpNyHvt+CUjG3TyfV898AYXg9eOS+ekmw==" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/ruangdev/cdn@idn/starterkit/datatables/css/datatables-custom.css" integrity="sha512-LQj39DLuOq+owYOUVrkw+eQmo8fKWYl4Sb9jdXXeARDDevwMGgLmyTyTkVImmBHX7APrnbgTVdGNgmVIWOtMHw==" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/ruangdev/cdn@idn/css/sweetalert2/sweetalert2.min.css" integrity="sha512-Xxs33QtURTKyRJi+DQ7EKwWzxpDlLSqjC7VYwbdWW9zdhrewgsHoim8DclqjqMlsMeiqgAi51+zuamxdEP2v1Q==" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/ruangdev/cdn@idn/starterkit/dashboard/css/toastify.css" integrity="sha512-tA+z1mt8+hiZE9CgG95WPtakY4JPkTaYgIcM1Wyq/VCdKDttHhnJoIDRC9/eWo8mbK2MmIDcDeUBfIfI1J8nWA==" crossorigin="anonymous">
@endpush

@section('tittle')
| Data KRS
@endsection

@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-4 order-md-1 order-last">
                
                

            </div>
            <div class="col-12 col-md-4 order-md-1 order-first">
                <h3>Data KRS</h3>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-last">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <!-- <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Data KRS</li>
                    </ol> -->
                </nav>
            </div>
        </div>
    </div>
    
    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('krs.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <h5>Total SKS yang dipilih: <strong id="total-sks-display">{{ $total_sks }}</strong></h5>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><!--<input type="checkbox" id="checkAll"> --> Pilih</th>
                                <th>Nama Matakuliah</th>
                                <th>SKS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matakuliahs as $matakuliah)
                                <tr>
                                    <td>
                                        <input type="checkbox"
                                               name="matakuliah_ids[]"
                                               value="{{ $matakuliah->id }}"
                                               data-sks="{{ $matakuliah->sks }}"
                                               class="matkul-checkbox"
                                               {{ in_array($matakuliah->id, $selected_ids) ? 'checked' : '' }}>
                                    </td>
                                    <td>{{ $matakuliah->nama_matakuliah }}</td>
                                    <td>{{ $matakuliah->sks }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                    <button type="submit" class="btn btn-primary mt-3">Simpan KRS</button>
                </form>

            </div>
        </div>
    </section>
</div>
@stop
@push('customJs')
<script src="https://cdn.jsdelivr.net/gh/ruangdev/cdn@idn/starterkit/datatables/js/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/ruangdev/cdn@idn/starterkit/datatables/js/datatables.min.js" integrity="sha512-4qmoJLDdNz51vzA75oiktlu1NkJgOJKkDDCrSyg3joGHi8W0YR6jqlivtTwql84y7Q0wjbQtZMe2obI7pQ+vjQ==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/ruangdev/cdn@idn/js/sweetalert2/sweetalert2.js" integrity="sha512-tWKcNRzXNTybB8ca0NSEyHlUl1mXPL/2xFjiUkUBGmJTRnAstcmyXtmv81vEennKVkH/FDDIH5l2+Jo0p1FObg==" crossorigin="anonymous"></script>
<script>
    function hitungTotalSKS() {
        let total = 0;
        const checkboxes = document.querySelectorAll('.matkul-checkbox:checked');
        checkboxes.forEach(cb => {
            total += parseInt(cb.dataset.sks);
        });
        document.getElementById('total-sks-display').innerText = total;
        return total;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.matkul-checkbox');

        // Inisialisasi total SKS saat pertama kali halaman dimuat
        hitungTotalSKS();

        // Tambahkan event ke masing-masing checkbox
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                let currentTotal = hitungTotalSKS();
                let addedSKS = parseInt(cb.dataset.sks);

                if (cb.checked && currentTotal > 22) {
                    alert("Total SKS tidak boleh melebihi 22");
                    cb.checked = false; // undo centang
                    hitungTotalSKS(); // hitung ulang
                }
            });
        });

        // Check all
        document.getElementById('checkAll').addEventListener('change', function (e) {
            checkboxes.forEach(cb => {
                cb.checked = false; // reset semua
            });

            let total = 0;
            for (let cb of checkboxes) {
                let sks = parseInt(cb.dataset.sks);
                if ((total + sks) <= 22) {
                    cb.checked = true;
                    total += sks;
                }
            }

            hitungTotalSKS();
        });
    });
</script>

@endpush

@push('Alert')
<script src="https://cdn.jsdelivr.net/gh/ruangdev/cdn@idn/starterkit/dashboard/js/toastify.js" integrity="sha512-ZHzbWDQKpcZxIT9l5KhcnwQTidZFzwK/c7gpUUsFvGjEsxPusdUCyFxjjpc7e/Wj7vLhfMujNx7COwOmzbn+2w==" crossorigin="anonymous"></script>
@if(Session::has('message'))
    @include('layouts.part._notif')
@endif
@endpush


