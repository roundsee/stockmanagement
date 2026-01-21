 @extends('admin.layouts.master')
 @section('content')
     <div class="content">

         <!-- Start Content-->
         <div class="container-xxl">

             <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                 <div class="flex-grow-1">
                     <h4 class="fs-18 fw-semibold m-0">Add Permission</h4>
                 </div>

                 <div class="text-end">
                     <ol class="breadcrumb m-0 py-0">

                         <li class="breadcrumb-item active">Add Permission</li>
                     </ol>
                 </div>
             </div>

             <!-- Form Validation -->
             <div class="row">
                 <div class="col-xl-12">
                     <div class="card">
                         <div class="card-header">
                             <h5 class="card-title mb-0">Add Permission</h5>
                         </div><!-- end card header -->

                         <div class="card-body">
                             <form action="{{ route('admin.store.permission') }}" method="post" class="row g-3">
                                 @csrf

                                 <div class="col-md-6">
                                     <label class="form-label">Permission Name</label>
                                     <input type="text" class="form-control @error('name') is-invalid @enderror"
                                         name="name" value="{{ old('name') }}" required>
                                     @error('name')
                                         <div class="invalid-feedback">{{ $message }}</div>
                                     @enderror
                                 </div>

                                 <div class="col-md-6">
                                     <label class="form-label">Permission Group</label>
                                     <select name="group_name" class="form-select @error('group_name') is-invalid @enderror"
                                         required>
                                         <option value="" disabled {{ old('group_name') ? '' : 'selected' }}>Select
                                             Group</option>
                                         @foreach (['Brand', 'WareHouse', 'Supplier', 'Customer', 'Product', 'Purchase', 'Sale', 'Due', 'Transfers', 'Report'] as $grp)
                                             <option value="{{ $grp }}"
                                                 {{ old('group_name') === $grp ? 'selected' : '' }}>{{ $grp }}
                                             </option>
                                         @endforeach
                                     </select>
                                     @error('group_name')
                                         <div class="invalid-feedback">{{ $message }}</div>
                                     @enderror
                                 </div>

                                 <div class="col-12">
                                     <button class="btn btn-primary" type="submit">Save Changes</button>
                                 </div>
                             </form>

                         </div>
                     </div>
                 </div>

             </div>

         </div>

     </div>
 @endsection
