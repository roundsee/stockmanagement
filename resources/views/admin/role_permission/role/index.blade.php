@extends('admin.layouts.master')
@section('content')
<div class="content">
    <div class="container-xxl">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">All Roles</h4>
            </div>
            <div class="text-end">
                <button type="button" class="btn btn-primary" id="addRoleBtn">
                    + Add Role
                </button>
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm edit-btn"
                                                data-id="{{ $item->id }}" data-name="{{ $item->name }}">
                                                Edit
                                            </button>
                                            <a href="{{ route('admin.delete.userRole', $item->id) }}"
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

<!-- Reusable Modal for Add/Edit Role -->
<div class="modal fade" id="role-modal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="roleModalLabel">Add Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="roleForm" method="POST">
                @csrf
                <input type="hidden" name="id" id="role_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="role_name" class="form-label">Role Name:</label>
                        <input type="text" class="form-control" name="roleName" id="role_name"
                            placeholder="Enter role name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="saveButton">
                        <span id="spinner" class="spinner-border spinner-border-sm me-2 d-none" role="status"
                            aria-hidden="true"></span>
                        Save Change
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    // Open Add Modal
    $('#addRoleBtn').click(function () {
        $('#roleModalLabel').text('Add Role');
        $('#roleForm')[0].reset();
        $('#role_id').val('');
        $('#role-modal').modal('show');
    });

    // Open Edit Modal
    $('.edit-btn').click(function () {
        const id = $(this).data('id');
        const name = $(this).data('name');
        $('#roleModalLabel').text('Edit Role');
        $('#role_id').val(id);
        $('#role_name').val(name);
        $('#role-modal').modal('show');
    });

   
    $('#roleForm').on('submit', function (e) {
        e.preventDefault();

        const name = $('#role_name').val().trim();
        if (!name) {
            toastr.error("Role name is required.");
            return;
        }

        const id = $('#role_id').val();
        const url = id
            ? "{{ route('admin.update.userRole', ':id') }}".replace(':id', id)
            : "{{ route('admin.store.userRole') }}";

        const formData = new FormData(this);
        if (id) formData.append('_method', 'PUT');

        $('#spinner').removeClass('d-none');
        $('#saveButton').attr('disabled', true);

        $.ajax({
            url: url,
            method: "POST", 
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                toastr.success(response.message);
                $('#roleForm')[0].reset();
                $('#role-modal').modal('hide');
                setTimeout(() => {
                    window.location.href = "{{ route('admin.all.userRole') }}";
                }, 1000);
            },
            error: function (xhr) {
                let errors = xhr.responseJSON?.errors;
                if (errors) {
                    $.each(errors, function (key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error("An unexpected error occurred.");
                }
            },
            complete: function () {
                $('#spinner').addClass('d-none');
                $('#saveButton').removeAttr('disabled');
            }
        });
    });
});
</script>
@endpush
