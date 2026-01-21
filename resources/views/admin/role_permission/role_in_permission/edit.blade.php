@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Edit Role Permissions</h4>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item active">Edit Permissions for Role: {{ $role->name }}</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Update Permissions</h5>
                        </div>

                        <div class="card-body">
                            <form id="submitRoleInPermission"
                                action="{{ route('admin.update.roleinpermission', $role->id) }}" method="POST"
                                class="row g-3">
                                @csrf

                                <!-- Role Display -->
                                <div class="col-md-6">
                                    <label class="form-label">Role Name</label>
                                    <input type="text" class="form-control" value="{{ $role->name }}" disabled>
                                </div>

                                <!-- Select All -->
                                <div class="form-check mt-3 ms-2">
                                    <input class="form-check-input" type="checkbox" id="permissionAll">
                                    <label class="form-check-label fw-bold" for="permissionAll">
                                        Select All Permissions
                                    </label>
                                </div>

                                <hr>

                                <!-- Permissions Grouped -->
                                @foreach ($permissionGroups as $group)
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>{{ $group->group_name }}</strong>
                                        </div>
                                        <div class="col-md-9">
                                            @php
                                                $permissions = App\Models\User::getPermissionByGroupName(
                                                    $group->group_name,
                                                );
                                            @endphp
                                            @foreach ($permissions as $permission)
                                                <div class="form-check form-check-inline mb-2">
                                                    <input class="form-check-input" type="checkbox" name="permission[]"
                                                        id="perm{{ $permission->id }}" value="{{ $permission->id }}"
                                                        {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="perm{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach

                                <!-- Submit Button -->
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit" id="saveButton">
                                        <span id="spinner" class="spinner-border spinner-border-sm me-2 d-none"
                                            role="status" aria-hidden="true"></span>
                                        Update Permissions
                                    </button>
                                </div>
                            </form>
                        </div> <!-- card-body -->
                    </div> <!-- card -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Handle "Select All" checkbox
        document.getElementById('permissionAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // AJAX Submit Handler
        $('#submitRoleInPermission').on('submit', function(e) {
            e.preventDefault();

            let checkedPermissions = $("input[name='permission[]']:checked").length;

            if (checkedPermissions === 0) {
                toastr.error("Please select at least one permission.");
                return false;
            }

            $('#spinner').removeClass('d-none');
            $('#saveButton').attr('disabled', true);

            let form = this;
            let formData = new FormData(form);

            $.ajax({
                url: $(form).attr('action'),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success(response.message);
                    setTimeout(() => {
                        window.location.href = "{{ route('admin.list.allrollinpermission') }}";
                    }, 1500);
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error("An unexpected error occurred.");
                    }
                },
                complete: function() {
                    $('#spinner').addClass('d-none');
                    $('#saveButton').removeAttr('disabled');
                }
            });
        });
    </script>
@endpush
