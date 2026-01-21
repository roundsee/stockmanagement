@extends('admin.layouts.master')
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">All Transfer </h4>
                </div>
                @if (Auth::guard('web')->user()->can('transfer.add'))
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <a href="{{route('admin.transfer.create')}}" class="btn btn-secondary">+ Add Transfer</a>
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
                                        <th>Date</th>
                                        <th>From WareHouse</th>
                                        <th>To WareHouse</th>
                                        <th>Product</th>
                                        <th>Stock Transfer</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allData as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->date)->format('Y-m-d') }}</td>
                                            <td>{{ $item->formWarehouse->name }}</td>
                                            <td>{{ $item->toWarehouse->name  }}</td>
                                            <td>
                                                @foreach ($item->transferItems as $transferItem)
                                                    {{ $transferItem->product->name ?? 'N/A' }} <br>
                                                @endforeach
                                            </td>

                                            <td>
                                                @foreach ($item->transferItems as $transferItem)
                                                    {{ $transferItem->quantity }} <br>
                                                @endforeach
                                            </td>

                                            <td>
                                                <a title="Details" href="{{route('admin.transfer.details',$item->id)}}" class="btn btn-info btn-sm"> <span
                                                        class="mdi mdi-eye-circle mdi-18px"></span> </a>
                                                        @if (Auth::guard('web')->user()->can('transfer.edit'))
                                                <a title="Edit" href="{{route('admin.transfer.edit', $item->id)}}" class="btn btn-success btn-sm"> <span
                                                        class="mdi mdi-book-edit mdi-18px"></span> </a>
                                                        @endif
                                                        @if (Auth::guard('web')->user()->can('transfer.delete'))
                                               <a title="Delete" href="{{ route('admin.transfer.delete', $item->id) }}"
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




        </div> <!-- container-fluid -->

    </div> <!-- content -->
@endsection
