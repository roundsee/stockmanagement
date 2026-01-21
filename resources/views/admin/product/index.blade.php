@extends('admin.layouts.master')
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">All Product</h4>
                </div>

                {{-- @if (Auth::guard('web')->user()->can('product.add')) --}}
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <a href="{{ route('admin.all-products.create') }}" class="btn btn-secondary">+ Add Product</a>
                    </ol>
                </div>
                {{-- @endif --}}
            </div>

            <!-- Datatables  -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">

                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Warehouse</th>
                                        <th>Price</th>
                                        <th>In Stock</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allData as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                @php
                                                    $images = json_decode($item->image, true);
                                                    $primaryImage = $images[0] ?? '/upload/no_image.jpg';
                                                @endphp
                                                <img src="{{ asset($primaryImage) }}" alt="img" width="40px">
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->warehouse->name }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>
                                                @if ($item->product_qty <= 3)
                                                    <span class="badge text-bg-danger">{{ $item->product_qty }}</span>
                                                @else
                                                    <h4> <span
                                                            class="badge text-bg-secondary">{{ $item->product_qty }}</span>
                                                    </h4>
                                                @endif
                                            </td>
                                            <td>
                                                 
                                                <a title="Details"
                                                    href="{{ route('admin.get.products.details', $item->id) }}"
                                                    class="btn btn-info btn-sm"> <span
                                                        class="mdi mdi-eye-circle mdi-18px"></span> </a>
                                                         @if (Auth::guard('web')->user()->can('product.edit'))
                                                <a href="{{ route('admin.all-products.edit', $item->id) }}"
                                                    class="btn btn-success btn-sm"><span
                                                        class="mdi mdi-book-edit mdi-18px"></span></a>
                                                        @endif
                                                         @if (Auth::guard('web')->user()->can('product.delete'))
                                                <a href="{{ route('admin.all-products.delete', $item->id) }}"
                                                    class="btn btn-danger btn-sm delete-item" id="delete"><span
                                                        class="mdi mdi-delete-circle  mdi-18px"></span></a>
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




        </div> <!-- container-fluid -->

    </div> <!-- content -->
@endsection
