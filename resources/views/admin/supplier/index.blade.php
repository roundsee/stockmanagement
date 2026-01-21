 @extends('admin.layouts.master')
 @section('content')
     <style>
         .table td,
         .table th {
             white-space: normal !important;
         }
     </style>
     <div class="content">

         <!-- Start Content-->
         <div class="container-xxl">

             <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                 <div class="flex-grow-1">
                     <h4 class="fs-18 fw-semibold m-0">All Supplier</h4>
                 </div>
                  @if (Auth::guard('web')->user()->can('supplier.add'))
                 <div class="text-end">
                     <ol class="breadcrumb m-0 py-0">
                         <a href="{{ route('admin.supplier.create') }}" class="btn btn-secondary"> + Add</a>
                     </ol>
                 </div>
                 @endif
             </div>

             <!-- Datatables  -->
             <div class="row">
                 <div class="col-12">
                     <div class="card">

                         <div class="card-header">

                         </div>

                         <div class="card-body">
                             <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                 <thead>
                                     <tr>
                                         <th>Sl</th>
                                         <th>Name</th>
                                         <th>Email</th>
                                         <th>Phone</th>
                                         <th>Address</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($suppliers as $key => $item)
                                         <tr>
                                             <td>{{ $key + 1 }}</td>
                                             <td>{{ $item->name }}</td>
                                             <td>{{ $item->email }}
                                             </td>
                                             <td>{{ $item->phone }}</td>
                                             <td>{{ $item->address }}</td>
                                             <td>
                                                 <div style="display: flex; gap: 5px;">
                                                     @if (Auth::guard('web')->user()->can('supplier.edit'))
                                                     <a href="{{ route('admin.supplier.edit', $item->id) }}"
                                                         class="btn btn-success btn-sm">Edit</a>
                                                         @endif
                                                          @if (Auth::guard('web')->user()->can('supplier.delete'))
                                                     <a href="{{ route('admin.supplier.delete', $item->id) }}"
                                                         class="btn btn-danger btn-sm delete-item">Delete</a>
                                                         @endif
                                                 </div>
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

 @push('scripts')
     <script>
         $('#datatable').DataTable({
             responsive: true,
             autoWidth: false
         });
     </script>
 @endpush
