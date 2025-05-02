@extends('app')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Dashboard</h3>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!-- *************************************************************** -->
        <!-- Start First Cards -->
        <!-- *************************************************************** -->
        <div class="row">
            <div class="col-12">
                <div class="card border-end">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div>
                                <h4 class="card-title mb-0">Daftar Monitoring Pekerjaan</h4>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <button type="button" class="btn btn-primary btn-sm text-white mb-3 mb-md-0 me-3"
                                    data-bs-toggle="modal" data-bs-target="#createWorkModal">
                                    Add Job
                                </button>
                                <div class="modal fade" id="createWorkModal" tabindex="-1"
                                    aria-labelledby="createWorkModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <form action="{{ route('dashboard.storeWork') }}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="createWorkModalLabel">Tambah Pekerjaan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body row g-3">
                                                    <div class="col-md-6">
                                                        <label for="no_spp" class="form-label">No SPP</label>
                                                        <input type="text" class="form-control" name="no_spp" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="plat_nomor" class="form-label">Plat Nomor</label>
                                                        <input type="text" class="form-control" name="plat_nomor"
                                                            required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="jenis_kendaraan" class="form-label">Jenis
                                                            Kendaraan</label>
                                                        <input type="text" class="form-control" name="jenis_kendaraan"
                                                            required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="jenis_pekerjaan" class="form-label">Jenis
                                                            Pekerjaan</label>
                                                        <input type="text" class="form-control" name="jenis_pekerjaan"
                                                            required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="waktu" class="form-label">Waktu</label>
                                                        <input type="time" class="form-control" name="waktu" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="tanggal" class="form-label">Tanggal</label>
                                                        <input type="date" class="form-control" name="tanggal" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="job_desc" class="form-label">Deskripsi Pekerjaan</label>
                                                        <textarea class="form-control" name="job_desc" rows="3" required></textarea>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="technicians" class="form-label">Pilih Teknisi</label>
                                                        <select class="form-select select2-tech" name="technicians[]"
                                                            multiple required>
                                                            @foreach ($technicians->where('status', 'Aktif') as $technician)
                                                                <option value="{{ $technician->id }}">
                                                                    {{ $technician->name }} (ID: {{ $technician->id }})
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        <small class="text-muted">Bisa pilih lebih dari 1 teknisi untuk 1
                                                            pekerjaan.</small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Simpan</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                                <button type="button" class="btn btn-primary btn-sm text-white mb-3 mb-md-0 me-3"
                                    data-bs-toggle="modal" data-bs-target="#createTechnicianModal">
                                    Add Technician
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="createTechnicianModal" tabindex="-1"
                                    aria-labelledby="createTechnicianLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('dashboard.storeTech') }}">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="createTechnicianLabel">Create Technician
                                                    </h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="technician-name" class="form-label">Name</label>
                                                        <input type="text" name="name" class="form-control"
                                                            id="technician-name" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Save</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Teknisi</th>
                                    <th>No SPP</th>
                                    <th>Plat Nomor</th>
                                    <th>Jenis Kendaraan</th>
                                    <th>Jenis Pekerjaan</th>
                                    <th>Waktu</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($technicians as $technician)
                                    @php
                                        $inProgressWorks = $technician->works->where('status', 'Dalam Pengerjaan');
                                    @endphp

                                    @if ($inProgressWorks->isNotEmpty())
                                        @foreach ($inProgressWorks as $work)
                                            <tr>
                                                <td>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#updateStatusModal{{ $technician->id }}">
                                                        {{ $technician->name }}
                                                    </a>
                                                </td>
                                                <td>{{ $work->no_spp }}</td>
                                                <td>{{ $work->plat_nomor }}</td>
                                                <td>{{ $work->jenis_kendaraan }}</td>
                                                <td>{{ $work->jenis_pekerjaan }}</td>
                                                <td>{{ $work->waktu }}</td>
                                                <td>{{ $work->tanggal }}</td>
                                                <td>
                                                    @if ($work->status === 'Dalam Pengerjaan')
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#updateWorkModal{{ $work->id }}">
                                                            {{ $work->status }}
                                                        </button>
                                                    @else
                                                        {{ $work->status }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="updateStatusModal{{ $technician->id }}"
                                                tabindex="-1"
                                                aria-labelledby="updateStatusModalLabel{{ $technician->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('dashboard.updateStatus', $technician->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="updateStatusModalLabel{{ $technician->id }}">
                                                                    Update Status for {{ $technician->name }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="status"
                                                                        class="form-label">Status</label>
                                                                    <select class="form-select" name="status" required>
                                                                        <option value="Aktif"
                                                                            {{ $technician->status == 'Aktif' ? 'selected' : '' }}>
                                                                            Aktif</option>
                                                                        <option value="Tidak Aktif"
                                                                            {{ $technician->status == 'Tidak Aktif' ? 'selected' : '' }}>
                                                                            Tidak Aktif</option>
                                                                        <option value="Cuti"
                                                                            {{ $technician->status == 'Cuti' ? 'selected' : '' }}>
                                                                            Cuti</option>
                                                                        <option value="Izin"
                                                                            {{ $technician->status == 'Izin' ? 'selected' : '' }}>
                                                                            Izin</option>
                                                                        <option value="Sakit"
                                                                            {{ $technician->status == 'Sakit' ? 'selected' : '' }}>
                                                                            Sakit</option>
                                                                        <option value="Pelatihan"
                                                                            {{ $technician->status == 'Pelatihan' ? 'selected' : '' }}>
                                                                            Pelatihan</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-success">Save</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="updateWorkModal{{ $work->id }}"
                                                tabindex="-1" aria-labelledby="updateWorkModalLabel{{ $work->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST"
                                                        action="{{ route('dashboard.updateWork', $work->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="updateWorkModalLabel{{ $work->id }}">
                                                                    Update Pekerjaan</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="job_desc" class="form-label">Deskripsi
                                                                        Pekerjaan</label>
                                                                    <textarea class="form-control" name="job_desc" rows="3" required>{{ $work->job_desc }}</textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="waktu" class="form-label">Setting Ulang
                                                                        Total Waktu</label>
                                                                    <input type="time" class="form-control"
                                                                        name="waktu" value="{{ $work->waktu }}"
                                                                        required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status"
                                                                        class="form-label">Status</label>
                                                                    <select name="status" class="form-select" required>
                                                                        <option value="Dalam Pengerjaan"
                                                                            {{ $work->status == 'Dalam Pengerjaan' ? 'selected' : '' }}>
                                                                            Dalam Pengerjaan</option>
                                                                        <option value="Selesai"
                                                                            {{ $work->status == 'Selesai' ? 'selected' : '' }}>
                                                                            Selesai</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="note" class="form-label">Catatan
                                                                        Pekerjaan</label>
                                                                    <textarea class="form-control" name="note" rows="3"
                                                                        required>{{ $work->note }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-success">Simpan</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#updateStatusModal{{ $technician->id }}">
                                                    {{ $technician->name }}
                                                </a>
                                                <div class="modal fade" id="updateStatusModal{{ $technician->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="updateStatusModalLabel{{ $technician->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form
                                                            action="{{ route('dashboard.updateStatus', $technician->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="updateStatusModalLabel{{ $technician->id }}">
                                                                        Update Status for {{ $technician->name }}
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="status"
                                                                            class="form-label">Status</label>
                                                                        <select class="form-select" name="status"
                                                                            required>
                                                                            <option value="Aktif"
                                                                                {{ $technician->status == 'Aktif' ? 'selected' : '' }}>
                                                                                Aktif</option>
                                                                            <option value="Tidak Aktif"
                                                                                {{ $technician->status == 'Tidak Aktif' ? 'selected' : '' }}>
                                                                                Tidak Aktif</option>
                                                                            <option value="Cuti"
                                                                                {{ $technician->status == 'Cuti' ? 'selected' : '' }}>
                                                                                Cuti</option>
                                                                            <option value="Izin"
                                                                                {{ $technician->status == 'Izin' ? 'selected' : '' }}>
                                                                                Izin</option>
                                                                            <option value="Sakit"
                                                                                {{ $technician->status == 'Sakit' ? 'selected' : '' }}>
                                                                                Sakit</option>
                                                                            <option value="Training"
                                                                                {{ $technician->status == 'Training' ? 'selected' : '' }}>
                                                                                Training</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-success">Save</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            @if ($technician->status != 'Aktif')
                                                <td colspan="7" class="text-center"
                                                    style="background-color: 
                                                        @if ($technician->status == 'Tidak Aktif') #f8d7da 
                                                        @else #fff3cd @endif;">
                                                    Status - {{ $technician->status }}
                                                </td>
                                            @else
                                                <td colspan="7" class="text-center">Tidak Ada Pekerjaan</td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('success'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                $('.select2-tech').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#createWorkModal'),
                    width: '100%',
                    placeholder: 'Pilih Teknisi'
                });
            });
        </script>
    @endpush
@endsection
