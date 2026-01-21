 @extends('admin.layouts.master')
 @section('content')
     <div class="content">

         <!-- Start Content-->
         <div class="container-xxl">

             <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                 <div class="flex-grow-1">
                     <h4 class="fs-18 fw-semibold m-0">Add Brand</h4>
                 </div>

                 <div class="text-end">
                     <ol class="breadcrumb m-0 py-0">

                         <li class="breadcrumb-item active">Add Brand</li>
                     </ol>
                 </div>
             </div>

             <!-- Form Validation -->
             <div class="row">
                 <div class="col-xl-12">
                     <div class="card">
                         <div class="card-header">
                             <h5 class="card-title mb-0">Add Brand</h5>
                         </div><!-- end card header -->

                         <div class="card-body">
                             <form id="brandSubmit" method="post" class="row g-3" enctype="multipart/form-data">
                                 @csrf

                                 <div class="col-md-12">
                                     <label for="validationDefault01" class="form-label">Brand Name :</label>
                                     <input type="text" class="form-control" name="name">
                                 </div>
                                 <div class="col-md-6">
                                     <label for="validationDefault02" class="form-label">Brand Image :</label>
                                     <input type="file" class="form-control" name="image" id="image">
                                 </div>

                                 <div class="col-md-6">
                                     <label for="validationDefault02" class="form-label"> </label>
                                     <img id="showImage" src="{{ url('uploads/no_image.jpg') }}"
                                         class="rounded-circle avatar-xl img-thumbnail float-start" alt="image profile">
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



         </div>

     </div>
 @endsection

 @push('scripts')
     <script>
         $(document).ready(function() {
             $('#image').change(function(e) {
                 var reader = new FileReader();
                 reader.onload = function(e) {
                     $('#showImage').attr('src', e.target.result);
                 }
                 reader.readAsDataURL(e.target.files['0']);
             });

             //  Data Store Ajax

             $('#brandSubmit').on('submit', function(e) {
                 e.preventDefault();
                 //  alert();
                 let name = $('input[name="name"]').val();
                 let image = $('input[name="image"]').val();

                 if (!name || !image) {
                     toastr.error("Please fill in all required fields.");
                     return
                 }

                 $('#spinner').removeClass('d-none');
                 $('#saveButton').attr('disabled', true);
                 let formData = new FormData(this);
                 $.ajax({
                     url: "{{ route('admin.brand.store') }}",
                     method: "POST",
                     data: formData,
                     processData: false,
                     contentType: false,
                     success: function(response) {
                         toastr.success(response.message);

                         $('#brandSubmit')[0].reset();
                         $('#showImage').attr('src', "{{ url('uploads/no_image.jpg') }}");
                         setTimeout(() => {
                             window.location.href = "{{ route('admin.brand.all') }}"

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
                         // Hide spinner and enable button again
                         $('#spinner').addClass('d-none');
                         $('#saveButton').removeAttr('disabled');
                     }
                 });
             });
         })
     </script>
 @endpush
