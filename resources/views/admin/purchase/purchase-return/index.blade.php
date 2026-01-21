@extends('admin.layouts.master')
@section('content')
    <div class="content">

        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Return Purchase</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <a href="{{ route('admin.create-purchase-return') }}" class="btn btn-secondary"> + Add Purchase</a>
                    </ol>
                </div>
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
                                        <th>WareHouse</th>
                                        <th>Status</th>
                                        <th>Grand Total</th>
                                        <th>Payment</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allData as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->warehouse->name }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>₹{{ $item->grand_total }}</td>
                                            <td>Cash</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                                            <td>
                                                <a title="Details"
                                                    href="{{ route('admin.get.purchase-return.details', $item->id) }}"
                                                    class="btn btn-info btn-sm"> <span
                                                        class="mdi mdi-eye-circle mdi-18px"></span> </a>

                                                <a title="PDF Invoice"
                                                    href="{{ route('admin.purchaseReturnInvoice', $item->id) }}"
                                                    class="btn btn-primary btn-sm"> <span
                                                        class="mdi mdi-download-circle mdi-18px"></span> </a>


                                                <a title="Edit"
                                                    href="{{ route('admin.edit.purchase-return', $item->id) }}"
                                                    class="btn btn-success btn-sm"> <span
                                                        class="mdi mdi-book-edit mdi-18px"></span> </a>

                                                <a title="Delete"
                                                    href="{{ route('admin.purchase-return-delete', $item->id) }}"
                                                    class="btn btn-danger btn-sm delete-item" id="delete"><span
                                                        class="mdi mdi-delete-circle  mdi-18px"></span></a>
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

    </div> <!-- content -->
@endsection
