 @extends('admin.layouts.master')
 @section('content')
     <div class="content">

         <!-- Start Content-->
         <div class="container-xxl">

             <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                 <div class="flex-grow-1">
                     <h4 class="fs-18 fw-semibold m-0">All Ware House</h4>
                 </div>
@if (Auth::guard('web')->user()->can('warehouse.add'))
                 <div class="text-end">
                     <ol class="breadcrumb m-0 py-0">
                         <a href="{{ route('admin.ware-house.create') }}" class="btn btn-secondary"> + Add</a>
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
                                         <th>City</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($warehouses as $key => $item)
                                         <tr>
                                             <td>{{ $key + 1 }}</td>
                                             <td>{{ $item->name }}</td>
                                             <td>{{ $item->email }}
                                             </td>
                                             <td>{{ $item->phone }}</td>
                                             <td>{{ $item->city }}</td>
                                             <td>
                                                @if (Auth::guard('web')->user()->can('warehouse.edit'))
                                                 <a href="{{ route('admin.ware-house.edit', $item->id) }}"
                                                     class="btn btn-success btn-sm">Edit</a>
                                                     @endif
                                                     @if (Auth::guard('web')->user()->can('warehouse.delete'))
                                                 <a href="{{ route('admin.ware-house.delete', $item->id) }}"
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
