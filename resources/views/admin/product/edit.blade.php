@extends('admin.layouts.master')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-0">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h2 class="fs-22 fw-semibold m-0">Edit Product</h2>
                    </div>

                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <a href="{{ route('admin.all-products') }}" class="btn btn-dark">Back</a>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form id="updateProduct" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="product_id" value="{{ $editData->id }}">

                            <div class="row">
                                <div class="col-xl-8">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Product Name: <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="name" placeholder="Enter Name"
                                                    class="form-control" value="{{ $editData->name }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Code: <span class="text-danger">*</span></label>
                                                <input type="text" name="code" class=" form-control"
                                                    value="{{ $editData->code }}">

                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="formBasic">Product Category : <span
                                                            class="text-danger">*</span></label>
                                                    <select name="category_id" id="category_id"
                                                        class="form-control form-select">
                                                        <option value="">Select Category</option>
                                                        @foreach ($categories as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $item->id == $editData->category_id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="formBasic">Brand : <span
                                                            class="text-danger">*</span></label>
                                                    <select name="brand_id" id="brand_id" class="form-control form-select">
                                                        <option value="">Select Brand</option>
                                                        @foreach ($brands as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $item->id == $editData->brand_id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Product Price: </label>
                                                <input type="text" name="price" class="form-control"
                                                    value="{{ $editData->price }}">

                                            </div>


                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Stock Alert: <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" name="stock_alert" class="form-control"
                                                    value="{{ $editData->stock_alert }}" min="0" required>

                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label">Notes: </label>
                                                <textarea class="form-control" name="note" rows="3" placeholder="Enter Notes">{{ $editData->note }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="card">
                                        <label class="form-label">Multiple Image: <span class="text-danger">*</span></label>
                                        <div class="mb-3">
                                            <input name="image[]" accept=".png, .jpg, .jpeg" multiple="" type="file"
                                                id="multiImg" class="upload-input-file form-control">
                                        </div>

                                        <div class="row" id="preview_img">

                                            {{-- 1. Main product image(s) from `products.image` --}}
                                            @if (isset($editData->image))
                                                @foreach (json_decode($editData->image, true) ?? [] as $key => $imgPath)
                                                    <div class="col-md-3 mb-2 position-relative"
                                                        id="main-image-{{ $key }}">
                                                        <img src="{{ asset($imgPath) }}" class="img-thumbnail"
                                                            style="max-height: 150px;">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm position-absolute"
                                                            style="top: 5px; right: 5px;"
                                                            onclick="confirmDeleteMainImage('{{ $key }}', '{{ asset($imgPath) }}')">
                                                            &times;
                                                        </button>
                                                    </div>
                                                @endforeach
                                            @endif

                                            {{-- 2. Additional images from `product_images` --}}
                                            @if (isset($editData->images) && $editData->images->count() > 0)
                                                @foreach ($editData->images as $img)
                                                    <div class="col-md-3 mb-2 position-relative"
                                                        id="extra-image-{{ $img->id }}">
                                                        <img src="{{ asset($img->image) }}" class="img-thumbnail"
                                                            style="max-height: 150px;">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm position-absolute"
                                                            style="top: 5px; right: 5px;"
                                                            onclick="confirmDeleteExtraImage({{ $img->id }})">
                                                            &times;
                                                        </button>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>


                                        <div>
                                            <div class="col-md-12 mb-3">
                                                <h4 class="text-center">Add Stock : </h4>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="formBasic">Warehouse : <span
                                                            class="text-danger">*</span></label>
                                                    <select name="warehouse_id" id="warehouse_id"
                                                        class="form-control form-select">
                                                        <option value="">Select Warehouse</option>
                                                        @foreach ($warehouses as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $item->id == $editData->warehouse_id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="formBasic">Supplier : <span
                                                            class="text-danger">*</span></label>
                                                    <select name="supplier_id" id="supplier_id"
                                                        class="form-control form-select">
                                                        <option value="">Select Supplier</option>
                                                        @foreach ($suppliers as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $item->id == $editData->supplier_id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Product Quantity: <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" name="product_qty" class="form-control"
                                                    value="{{ $editData->product_qty }}" min="1" required>

                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="formBasic">Status : <span
                                                            class="text-danger">*</span></label>
                                                    <select name="status" id="status"
                                                        class="form-control form-select">
                                                        <option selected="">Select Status</option>

                                                        <option value="Received"
                                                            {{ isset($editData->status) && $editData->status == 'Received' ? 'selected' : '' }}>
                                                            Received</option>

                                                        <option value="Pending"
                                                            {{ isset($editData->status) && $editData->status == 'Pending' ? 'selected' : '' }}>
                                                            Pending</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="d-flex mt-5 justify-content-start">
                                            <button class="btn btn-primary me-3" type="submit">
                                                <span id="spinner" class="spinner-border spinner-border-sm me-2 d-none"
                                                    role="status" aria-hidden="true"></span>Save</button>
                                            <a class="btn btn-secondary"
                                                href="{{ route('admin.all-products') }}">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




@push('scripts')
    <script>
        $(document).ready(function() {
            $('#updateProduct').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                $('#spinner').removeClass('d-none');
                $('#saveButton').attr('disabled', true);

                let =
                updateUrl = "{{ route('admin.all-products.update', ':id') }}".replace(':id',
                    '{{ $editData->id }}');

                $.ajax({
                    url: updateUrl,
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            window.location.href = "{{ route('admin.all-products') }}";
                        }, 1500);
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON?.errors;
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
        // For main image (from JSON)
        function confirmDeleteMainImage(index, imageUrl) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will remove the main product image.",
                imageUrl: imageUrl,
                imageHeight: 150,
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Fire AJAX
                    $.ajax({
                        url: "{{ route('admin.product.delete-main-image') }}",
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            product_id: '{{ $editData->id }}',
                            index: index
                        },
                        success: function(response) {
                            $('#main-image-' + index).remove();
                            Swal.fire('Deleted!', response.message, 'success');
                        },
                        error: function() {
                            Swal.fire('Error', 'Something went wrong!', 'error');
                        }
                    });
                }
            });
        }

        // For extra image (from product_images table)
        function confirmDeleteExtraImage(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the image permanently.",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Fire AJAX
                    $.ajax({
                        url: "{{ route('admin.product.delete-extra-image') }}",
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            image_id: id
                        },
                        success: function(response) {
                            $('#extra-image-' + id).remove();
                            Swal.fire('Deleted!', response.message, 'success');
                        },
                        error: function() {
                            Swal.fire('Error', 'Something went wrong!', 'error');
                        }
                    });
                }
            });
        }

        document.getElementById('multiImg').addEventListener('change', function(event) {
            // alert();
            const previewContainer = document.getElementById('preview_img');
            const input = event.target;
            const files = Array.from(event.target.files);

            files.forEach((file, index) => {
                if (file.type.match('image.*')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 mb-3 position-relative';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-fluid rounded';
                        img.style.maxHeight = '150px';
                        img.alt = 'Image Preview';

                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className = 'btn btn-danger btn-sm position-absolute';
                        removeBtn.style.top = '10px';
                        removeBtn.style.right = '10px';
                        removeBtn.innerHTML = '&times;';
                        removeBtn.title = 'Remove Image';

                        // Remove selected file preview and update input
                        removeBtn.addEventListener('click', function() {
                            col.remove();

                            const remainingFiles = Array.from(input.files).filter((_, i) =>
                                i !== index);
                            const dataTransfer = new DataTransfer();
                            remainingFiles.forEach(file => dataTransfer.items.add(file));
                            input.files = dataTransfer.files;
                        });

                        const wrapper = document.createElement('div');
                        wrapper.style.position = 'relative';
                        wrapper.appendChild(img);
                        wrapper.appendChild(removeBtn);

                        col.appendChild(wrapper);
                        previewContainer.appendChild(col);
                    };

                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
