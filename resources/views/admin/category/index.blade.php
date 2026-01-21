@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="container-xxl">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">All Categories</h4>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-secondary" id="addCategoryBtn">
                        + Add
                    </button>
                </div>
            </div>

            <!-- DataTable -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm edit-btn"
                                                    data-id="{{ $item->id }}" data-name="{{ $item->name }}">
                                                    Edit
                                                </button>
                                                <a href="{{ route('admin.category.delete', $item->id) }}"
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

    <!-- Reusable Modal for Add/Edit -->
    <div class="modal fade" id="category-modal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="categoryModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="categoryForm" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="category_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Category Name:</label>
                            <input type="text" class="form-control" name="name" id="category_name"
                                placeholder="Enter category name">
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
        $(document).ready(function() {
            // Open Add Modal
            $('#addCategoryBtn').click(function() {
                $('#categoryModalLabel').text('Add Category');
                $('#categoryForm')[0].reset();
                $('#category_id').val('');
                $('#category-modal').modal('show');
            });

            // Open Edit Modal
            $('.edit-btn').click(function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                $('#categoryModalLabel').text('Edit Category');
                $('#category_id').val(id);
                $('#category_name').val(name);
                $('#category-modal').modal('show');
            });

            // Submit Form (Insert or Update)
            $('#categoryForm').on('submit', function(e) {
                e.preventDefault();

                const name = $('#category_name').val().trim();
                if (!name) {
                    toastr.error("Category name is required.");
                    return;
                }

                const id = $('#category_id').val();
                const url = id ?
                    "{{ route('admin.category.update', ':id') }}".replace(':id', id) :
                    "{{ route('admin.category.store') }}";

                const formData = new FormData(this);
                $('#spinner').removeClass('d-none');
                $('#saveButton').attr('disabled', true);

                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success(response.message);
                        $('#categoryForm')[0].reset();
                        $('#category-modal').modal('hide');
                        setTimeout(() => {
                            window.location.href = "{{ route('admin.category.all') }}";
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
        });
    </script>
@endpush
