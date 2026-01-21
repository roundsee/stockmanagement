 @extends('admin.layouts.master')
 @section('content')
     <div class="content">

         <div class="container-xxl">
             <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                 <div class="flex-grow-1">
                     <h4 class="fs-18 fw-semibold m-0">Profile</h4>
                 </div>


             </div>

             <div class="row">
                 <div class="col-12">
                     <div class="card">

                         <div class="card-body">

                             <div class="align-items-center">
                                 <div class="d-flex align-items-center">
                                     <img src="{{ auth()->user()->photo ? asset(auth()->user()->photo) : asset('uploads/no_image.jpg') }}"
                                         id="imagePreview" class="rounded-circle avatar-xxl img-thumbnail float-start"
                                         alt="image profile">

                                 </div>
                             </div>

                             <div class="tab-content text-muted bg-white">
                                 <div class="tab-pane pt-4 active" id="profile_setting">
                                     <div class="row">

                                         <div class="col-lg-6 col-xl-6">
                                             <form id="profileForm" method="POST" enctype="multipart/form-data">
                                                 @csrf

                                                 <div class="card border mb-0">
                                                     <div class="card-header">
                                                         <div class="row align-items-center">
                                                             <div class="col">
                                                                 <h4 class="card-title mb-0">Personal Information</h4>
                                                             </div>
                                                         </div>
                                                     </div>

                                                     <div class="card-body">
                                                         <div class="form-group mb-3 row">
                                                             <label class="form-label">Image</label>
                                                             <div class="col-12">
                                                                 <input class="form-control" name="image" type="file"
                                                                     id="imageInput">
                                                             </div>
                                                         </div>
                                                         <div class="form-group mb-3 row">
                                                             <label class="form-label">Name</label>
                                                             <div class="col-12">
                                                                 <input class="form-control" name="name" type="text"
                                                                     value="{{ old('name', $user->name) }}">
                                                             </div>
                                                         </div>

                                                         <div class="form-group mb-3 row">
                                                             <label class="form-label">Phone</label>
                                                             <div class="col-12">
                                                                 <input class="form-control" name="phone_num" type="text"
                                                                     value="{{ old('phone_num', $user->phone_num) }}">
                                                             </div>
                                                         </div>


                                                         <div class="form-group mb-3 row">
                                                             <label class="form-label">Address</label>
                                                             <div class="col-12">
                                                                 <input class="form-control" name="address" type="text"
                                                                     value="{{ old('address', $user->address) }}">
                                                             </div>
                                                         </div>

                                                         <div class="form-group row">
                                                             <div class="col-12">
                                                                 <button type="submit" id="submitBtn"
                                                                     class="btn btn-primary">
                                                                     Update Details
                                                                 </button>

                                                                 <button class="btn btn-primary d-none" type="button"
                                                                     id="loadingBtn" disabled>
                                                                     <span class="spinner-border spinner-border-sm"
                                                                         role="status" aria-hidden="true"></span>
                                                                     Updating...
                                                                 </button>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </form>
                                         </div>

                                         {{-- === Email & Password Form === --}}
                                         <div class="col-lg-6 col-xl-6">
                                             <form method="POST" id="userCredentials">
                                                 @csrf
                                                 <div class="card border mb-0">
                                                     <div class="card-header">
                                                         <div class="row align-items-center">
                                                             <div class="col">
                                                                 <h4 class="card-title mb-0">Password</h4>
                                                             </div>
                                                         </div>
                                                     </div>

                                                     <div class="card-body mb-0">
                                                         <div class="form-group mb-3 row">
                                                             <label class="form-label">Old Password</label>
                                                             <div class="col-12">
                                                                 <input class="form-control" name="old_password"
                                                                     type="password" placeholder="Old Password">
                                                             </div>
                                                         </div>

                                                         <div class="form-group mb-3 row">
                                                             <label class="form-label">New Password</label>
                                                             <div class="col-12">
                                                                 <input class="form-control" name="new_password"
                                                                     type="password" placeholder="New Password">
                                                             </div>
                                                         </div>

                                                         <div class="form-group mb-3 row">
                                                             <label class="form-label">Confirm Password</label>
                                                             <div class="col-12">
                                                                 <input class="form-control"
                                                                     name="new_password_confirmation" type="password"
                                                                     placeholder="Confirm Password">
                                                             </div>
                                                         </div>

                                                         <div class="form-group row">
                                                             <div class="col-12">
                                                                 <button type="submit" class="btn btn-primary"
                                                                     id="submitUserBtn">Update Password</button>
                                                                 <button class="btn btn-primary d-none" type="button"
                                                                     id="loadingUserBtn" disabled>
                                                                     <span class="spinner-border spinner-border-sm"
                                                                         role="status" aria-hidden="true"></span>
                                                                     Updating...
                                                                 </button>
                                                                 <button type="reset"
                                                                     class="btn btn-danger">Cancel</button>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </form>
                                         </div>

                                     </div>
                                 </div>
                             </div>

                         </div>
                     </div>
                 </div>
             </div>

         </div>
     </div>
 @endsection

 @push('scripts')
     <script>
         $(document).ready(function() {
             //  alert();
             $('#imageInput').on('change', function(e) {
                 e.preventDefault();
                 const file = e.target.files[0];
                 const preview = $('#imagePreview');
                 if (file) {
                     const reader = new FileReader();
                     reader.onload = function(event) {
                         preview.attr('src', event.target.result);
                     }
                     reader.readAsDataURL(file);
                 }
             });
             // Data Update Ajax------
             $("#profileForm").on('submit', function(e) {
                 e.preventDefault();
                 let form = $(this)[0];
                 let formData = new FormData(form);
                 $('#submitBtn').addClass('d-none');
                 $('#loadingBtn').removeClass('d-none');

                 let routeTemplate = "{{ route('admin.profile.update', ':id') }}";
                 let userId = {{ auth()->user()->id }};
                 let url = routeTemplate.replace(':id', userId);

                 $.ajax({

                     url: url,
                     method: 'POST',
                     data: formData,
                     contentType: false,
                     processData: false,

                     success: function(response) {
                         toastr.success(response.message);
                         setTimeout(() => {
                             window.location.reload();
                         }, 1500);

                     },
                     error: function(xhr, status, error) {
                         let errorMessage = xhr.responseJSON.message;
                         toastr.error(errorMessage);
                     },
                     complete: function() {

                         $('#submitBtn').removeClass('d-none');
                         $('#loadingBtn').addClass('d-none');
                     }
                 });
             });

             //  Update User credentials 

             $("#userCredentials").on('submit', function(e) {
                 e.preventDefault();
                 let form = $(this)[0];
                 let formData = new FormData(form);
                 $('#submitUserBtn').addClass('d-none');
                 $('#loadingUserBtn').removeClass('d-none');

                 let routeTemplate = "{{ route('admin.profile.credential.update', ':id') }}";
                 let userId = {{ auth()->user()->id }};
                 let url = routeTemplate.replace(':id', userId);

                 $.ajax({

                     url: url,
                     method: 'POST',
                     data: formData,
                     contentType: false,
                     processData: false,

                     success: function(response) {
                         if (response.status === true) {
                             toastr.success(response.message);
                             setTimeout(() => {
                                 window.location.reload();
                             }, 1500);
                         } else {
                             toastr.error(response.message);
                         }
                     },
                     error: function(xhr, status, error) {
                         let errorMessage = xhr.responseJSON.message;
                         toastr.error(errorMessage);
                     },
                     complete: function() {

                         $('#submitUserBtn').removeClass('d-none');
                         $('#loadingUserBtn').addClass('d-none');
                     }
                 });
             });


         });
     </script>
 @endpush
