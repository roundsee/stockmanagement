@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="container-xxl">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">All Roles In Permission</h4>
                </div>
                <div class="text-end">
                    <a href="{{ route('admin.addrole.inpermission') }}" class="btn btn-primary"> + Add Role In Permission</a>
                </div>
            </div>

            <!-- DataTable -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Role Name</th>
                                        <th>Permission Name(s)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                @if ($item->permissions && count($item->permissions))
                                                    <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                                        @foreach ($item->permissions as $permission)
                                                            <span
                                                                style="
                                                    background-color: #d1ecf1;
                                                    color: #0c5460;
                                                    padding: 4px 8px;
                                                    font-size: 12px;
                                                    border-radius: 4px;
                                                    display: inline-block;
                                                ">
                                                                {{ $permission->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span style="color: #6c757d;">No Permissions</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.edit.roleinpermission', $item->id) }}"
                                                    class="btn btn-success btn-sm edit-btn">
                                                    Edit
                                                </a>
                                                <a href="{{ route('admin.delete.rollinpermission', $item->id) }}"
                                                    class="btn btn-danger btn-sm delete-item">Delete</a>
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
@endsection
