@extends('templates.app')

@push('style')
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')

    <div class="container mt-5">

        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.users.export') }}" class="btn btn-secondary me-2">Export (.Xlsx)</a>
            <a href="{{ route('admin.users.trash') }}" class="btn btn-warning me-2">Data Sampah</a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success">Tambah Data</a>
        </div>

        <h5 class="mb-3">Data Pengguna</h5>

        <div class="table-responsive">
            <table id="users-table" class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Foto Profil</th>
                        <th>Role</th>
                        <th>Dibuat Pada</th>
                        <th>Diupdate Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>

@endsection

@push('script')
    <!-- jQuery wajib -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables core + Bootstrap 5 integration -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.users.datatables') }}",
                    type: "GET"
                },
                columns: [
                    { data: "DT_RowIndex", orderable: false, searchable: false },
                    { data: "name" },
                    { data: "email" },
                    { data: "gender_display", orderable: false },
                    { data: "date_of_birth_display", orderable: false },
                    { data: "profile_image_display", orderable: false, searchable: false },
                    { data: "role_display", orderable: false },
                    { data: "created_at_display" },
                    { data: "updated_at_display" },
                    { data: "action", orderable: false, searchable: false }
                ],
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: true,
                language: {
                    processing: "Memproses...",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                    infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                    loadingRecords: "Memuat...",
                    zeroRecords: "Tidak ditemukan data yang sesuai",
                    emptyTable: "Tidak ada data di dalam tabel",
                    paginate: {
                        first: "Pertama",
                        previous: "Sebelumnya",
                        next: "Selanjutnya",
                        last: "Terakhir"
                    },
                    aria: {
                        sortAscending: ": aktifkan untuk mengurutkan kolom ke atas",
                        sortDescending: ": aktifkan untuk mengurutkan kolom ke bawah"
                    }
                }
            });
        });
    </script>
@endpush
