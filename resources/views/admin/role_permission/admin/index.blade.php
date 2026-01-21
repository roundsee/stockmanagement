@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">All Admin</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <a href="{{ route('admin.create.all.user') }}" class="btn btn-secondary">+ Add Admin</a>
                    </ol>
                </div>
            </div>

            <!-- Datatables -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alladmin as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                {{-- ✅ Display role from DB column --}}
                                                <span class="badge bg-danger">{{ ucfirst($item->role ?? 'N/A') }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.edit.user', $item->id) }}"
                                                     class="btn btn-success btn-sm">Edit</a>
                                                 <a href="{{ route('admin.delete.user', $item->id) }}"
                                                     class="btn btn-danger btn-sm delete-item" id="delete">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection
