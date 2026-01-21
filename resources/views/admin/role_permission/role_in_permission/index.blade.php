 @extends('admin.layouts.master')
 @section('content')
     <style>
         .form-check-label {
             text-transform: capitalize;
         }
     </style>
     <div class="content">

         <!-- Start Content-->
         <div class="container-xxl">

             <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                 <div class="flex-grow-1">
                     <h4 class="fs-18 fw-semibold m-0">Add Role In Permission</h4>
                 </div>

                 <div class="text-end">
                     <ol class="breadcrumb m-0 py-0">

                         <li class="breadcrumb-item active">Add Role In Permission</li>
                     </ol>
                 </div>
             </div>

             <!-- Form Validation -->
             <div class="row">
                 <div class="col-xl-12">
                     <div class="card">
                         <div class="card-header">
                             <h5 class="card-title mb-0">Add Permission</h5>
                         </div>

                         <div class="card-body">
                             <form id="submitRoleInPermission" action="" method="post" class="row g-3">
                                 @csrf

                                 <div class="col-md-6">
                                     <label class="form-label">Role Name</label>
                                     <select name="role_id" class="form-select" id="role_id">
                                         <option value="" selected>Select Role</option>
                                         @foreach ($roles as $role)
                                             <option value="{{ $role->id }}">{{ $role->name }}</option>
                                         @endforeach
                                     </select>
                                     @error('name')
                                         <div class="invalid-feedback">{{ $message }}</div>
                                     @enderror
                                 </div>

                                 <div class="form-check mb-2">
                                     <input class="form-check-input" type="checkbox" id="permissionall">
                                     <label class="form-check-label" for="permissionall">Permission All</label>
                                 </div>
                                 <hr>
                                 @foreach ($permissionGroups as $group)
                                     <div class="row">
                                         <div class="col-3">
                                             <div class="form-check mb-2">
                                                 <input class="form-check-label" type="checkbox" value=""
                                                     id="flexCheckDefault">
                                                 <label class="form-check-label" for="flexCheckDefault">
                                                     {{ $group->group_name }}
                                                 </label>
                                             </div>
                                         </div>
                                         <div class="col-9">
                                             @php
                                                 $permissions = App\Models\User::getPermissionByGroupName(
                                                     $group->group_name,
                                                 );
                                             @endphp
                                             @foreach ($permissions as $permission)
                                                 <div class="form-check mb-2">
                                                     <input name="permission[]" class="form-check-label" type="checkbox"
                                                         value="{{ $permission->id }}"
                                                         id="flexCheckDefault{{ $permission->id }}">
                                                     <label class="form-check-label"
                                                         for="flexCheckDefault{{ $permission->id }}">
                                                         {{ $permission->name }}
                                                     </label>
                                                 </div>
                                             @endforeach
                                         </div>
                                     </div>
                                     <hr class="my-3" />
                                 @endforeach

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

         </div>

     </div>
 @endsection

 @push('scripts')
     <script>
         $(document).ready(function() {


             $("#permissionall").on('change', function() {
                 $('input[type="checkbox"]').not(this).prop('checked', this.checked);
             });

             // Form submit 
             $('#submitRoleInPermission').on('submit', function(e) {
                 e.preventDefault();

                 let role_id = $('#role_id').val();
                 let checkedPermissions = $("input[name='permission[]']:checked").length;


                 if (role_id === "" || role_id == null) {
                     toastr.error("Please select a role.");
                     return false;
                 }

                 if (checkedPermissions === 0) {
                     toastr.error("Please select at least one permission.");
                     return false;
                 }


                 $('#spinner').removeClass('d-none');
                 $('#saveButton').attr('disabled', true);

                 let formData = new FormData(this);

                 $.ajax({
                     url: "{{ route('admin.store.roleInPermission') }}",
                     type: "POST",
                     data: formData,
                     contentType: false,
                     processData: false,
                     success: function(response) {
                         toastr.success(response.message);
                         setTimeout(() => {
                             window.location.reload();
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
