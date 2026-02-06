@extends('admin.layouts.master')
@section('content')
<div class="content">
    <div class="container-xxl">
        <div class="py-3 d-flex align-items-center justify-content-between">
            <h4 class="fs-18 fw-semibold m-0">Satuan Produk (Units)</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUnitModal">
                + Tambah Satuan
            </button>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th width="50">Sl</th>
                                    <th>Nama Satuan</th>
                                    <th>Singkatan</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($units as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td><span class="badge bg-light text-dark">{{ $item->short_name }}</span></td>
                                    <td>
                                        <button class="btn btn-success btn-sm edit-btn"
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}"
                                            data-short="{{ $item->short_name }}"
                                            data-bs-toggle="modal" data-bs-target="#editUnitModal">
                                            <i class="mdi mdi-book-edit"></i>
                                        </button>
                                        <a href="{{ route('admin.unit.delete', $item->id) }}" class="btn btn-danger btn-sm" id="delete">
                                            <i class="mdi mdi-delete"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addUnitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.unit.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Satuan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Nama Satuan (ex: Kilogram)" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="short_name" class="form-control" placeholder="Singkatan (ex: Kg)" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editUnitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.unit.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header text-white bg-success">
                    <h5 class="modal-title text-white">Edit Satuan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Satuan</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Singkatan</label>
                        <input type="text" name="short_name" id="edit_short" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    @include('admin.units.unit_js')
@endpush
