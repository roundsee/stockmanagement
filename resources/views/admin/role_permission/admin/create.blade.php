 @extends('admin.layouts.master')
 @section('content')
     <div class="content">

         <!-- Start Content-->
         <div class="container-xxl">

             <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                 <div class="flex-grow-1">
                     <h4 class="fs-18 fw-semibold m-0">Add Admin</h4>
                 </div>

                 <div class="text-end">
                     <ol class="breadcrumb m-0 py-0">

                         <li class="breadcrumb-item active">Add Admin</li>
                     </ol>
                 </div>
             </div>

             <!-- Form Validation -->
             <div class="row">
                 <div class="col-xl-12">
                     <div class="card">
                         <div class="card-header">
                             <h5 class="card-title mb-0">Add Admin</h5>
                         </div>

                         <div class="card-body">
                             <form  id="submitUseradmin" method="post" class="row g-3" enctype="multipart/form-data">
                                 @csrf

                                 <div class="col-md-6">
                                     <label for="validationDefault01" class="form-label">Admin Name</label>
                                     <input type="text" class="form-control" name="name">
                                 </div>

                                 <div class="col-md-6">
                                     <label for="validationDefault01" class="form-label">Admin Email</label>
                                     <input type="emal" class="form-control" name="email">
                                 </div>

                                 <div class="col-md-6">
                                     <label for="validationDefault01" class="form-label">Admin Password</label>
                                     <input type="password" class="form-control" name="password">
                                 </div>

                                 <div class="col-md-6">
                                     <label for="validationDefault01" class="form-label">Role </label>
                                     <select name="roles" class="form-select" id="example-select">
                                         <option value="" selected>Select Role</option>
                                         @foreach ($roles as $role)
                                             <option value="{{ $role->id }}">{{ $role->name }}</option>
                                         @endforeach
                                     </select>
                                 </div>



                                 <div class="col-12">
                                    <button class="btn btn-primary" type="submit" id="saveButton">
                                         <span id="spinner" class="spinner-border spinner-border-sm me-2 d-none"
                                             role="status" aria-hidden="true"></span>
                                         Save Change
                                     </button>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>


             </div>



         </div> <!-- container-fluid -->

     </div>
 @endsection

 @push('scripts')
     <script>
            $(document).ready(function() {
                $('#submitUseradmin').on('submit', function(e) {
                    e.preventDefault();

                    // Basic validation
                    let name = $("input[name='name']").val().trim();
                    let email = $("input[name='email']").val().trim();
                    let password = $("input[name='password']").val().trim();
                    let roles = $("select[name='roles']").val();

                    if (!name) {
                        toastr.error("Name is required.");
                        return false;
                    }
                    if (!email) {
                        toastr.error("Email is required.");
                        return false;
                    }
                    if (!password || password.length < 6) {
                        toastr.error("Password must be at least 6 characters.");
                        return false;
                    }
                    if (!roles) {
                        toastr.error("Please select a role.");
                        return false;
                    }

                    // Show loading spinner
                    $('#spinner').removeClass('d-none');
                    $('#saveButton').attr('disabled', true);

                    // Send via AJAX
                    let formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('admin.store.user') }}", // 👈 define this route in web.php
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            toastr.success(response.message);
                            setTimeout(() => {
                                window.location.href = "{{ route('admin.list.all.user') }}";
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