 @extends('admin.layouts.master')
 @section('content')
     <div class="content">

         <!-- Start Content-->
         <div class="container-xxl">

             <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                 <div class="flex-grow-1">
                     <h4 class="fs-18 fw-semibold m-0">All Brand</h4>
                 </div>
                 @if (Auth::guard('web')->user()->can('create.brand'))
                     <div class="text-end">
                         <ol class="breadcrumb m-0 py-0">
                             <a href="{{ route('admin.brand.create') }}" class="btn btn-secondary"> + Add Brand</a>
                         </ol>
                     </div>
                 @endif
             </div>

             <!-- Datatables  -->
             <div class="row">
                 <div class="col-12">
                     <div class="card">

                         <div class="card-header">

                         </div><!-- end card header -->

                         <div class="card-body">
                             <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                 <thead>
                                     <tr>
                                         <th>Sl</th>
                                         <th>Brand Name</th>
                                         <th>Image</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($brands as $key => $item)
                                         <tr>
                                             <td>{{ $key + 1 }}</td>
                                             <td>{{ $item->name }}</td>
                                             <td> <img src="{{ asset($item->image) }}" style="width: 70px; height:40px">
                                             </td>
                                             <td>
                                                 @if (Auth::guard('web')->user()->can('edit.brand'))
                                                     <a href="{{ route('admin.brand.edit', $item->id) }}"
                                                         class="btn btn-success btn-sm">Edit</a>
                                                 @endif
                                                 @if (Auth::guard('web')->user()->can('delete.brand'))
                                                     <a href="{{ route('admin.brand.delete', $item->id) }}"
                                                         class="btn btn-danger btn-sm delete-item" id="delete">Delete</a>
                                                 @endif



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
