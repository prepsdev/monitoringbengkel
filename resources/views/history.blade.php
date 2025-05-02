@extends('app')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">History</h3>
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
                        <div class="d-flex align-items-center justify-content-start flex-wrap">
                            <h4 class="card-title mb-0">Daftar History Pekerjaan</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
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
                                @foreach ($works as $work)
                                    <tr>
                                        <td>{{ $work->id }}</td>
                                        <td>{{ $work->no_spp }}</td>
                                        <td>{{ $work->plat_nomor }}</td>
                                        <td>{{ $work->jenis_kendaraan }}</td>
                                        <td>{{ $work->jenis_pekerjaan }}</td>
                                        <td>{{ $work->waktu }}</td>
                                        <td>{{ $work->tanggal }}</td>
                                        <td>
                                            <button type="button" class="btn btn-outline-info btn-sm fw-bold"
                                                data-bs-toggle="modal" data-bs-target="#workDetailModal{{ $work->id }}">
                                                {{ $work->status }}
                                            </button>
                                        </td>

                                    </tr>
                                    <!-- Modal Detail Work -->
                                    <div class="modal fade" id="workDetailModal{{ $work->id }}" tabindex="-1"
                                        aria-labelledby="workDetailModalLabel{{ $work->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border border-primary rounded-3 shadow-lg">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="workDetailModalLabel{{ $work->id }}">
                                                        📋 Detail Pekerjaan
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body bg-light">
                                                    <div class="mb-2"><strong class="text-primary">👨‍🔧
                                                            Technician:</strong>
                                                        <span
                                                            class="text-dark">{{ $work->technicians->pluck('name')->join(', ') }}</span>
                                                    </div>
                                                    <div class="mb-2"><strong>No SPP:</strong> {{ $work->no_spp }}</div>
                                                    <div class="mb-2"><strong>Plat Nomor:</strong>
                                                        {{ $work->plat_nomor }}</div>
                                                    <div class="mb-2"><strong>Jenis Kendaraan:</strong>
                                                        {{ $work->jenis_kendaraan }}</div>
                                                    <div class="mb-2"><strong>Jenis Pekerjaan:</strong>
                                                        {{ $work->jenis_pekerjaan }}</div>
                                                    <div class="mb-2"><strong>⏰ Waktu:</strong> {{ $work->waktu }}</div>
                                                    <div class="mb-2"><strong>📅 Tanggal:</strong> {{ $work->tanggal }}
                                                    </div>
                                                    <div class="mb-2"><strong>🛠️ Job Description:</strong><br>
                                                        <span class="text-muted">{{ $work->job_desc ?? '-' }}</span>
                                                    </div>
                                                    <div class="mb-2"><strong>📝 Catatan:</strong><br>
                                                        <span class="text-muted">{{ $work->note ?? '-' }}</span>
                                                    </div>
                                                    <div class="mb-2"><strong>Status:</strong>
                                                        <span class="badge bg-warning text-dark">{{ $work->status }}</span>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-primary-subtle">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif
@endsection
