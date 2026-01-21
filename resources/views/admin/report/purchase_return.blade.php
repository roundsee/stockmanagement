@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <!-- Navigation and Filters -->
        @include('admin.report.dashbodar-data.index')

        <div class="card mt-4">
            @include('admin.report.dashbodar-data.table_hader')

            <!-- DataTable -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Supplier</th>
                                <th>Warehouse</th>
                                <th>Product</th>
                                <th>Stock</th>
                                <th>Unit Price</th>
                                <th>Status</th>
                                <th>Grand Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Ajax Load Data --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let table;

        function toggleLoader(show) {
            const el = document.getElementById('ajax-loader');
            if (!el) return;
            el.classList.toggle('d-none', !show);
        }

        function badge(status) {
            if (!status) return '<span class="badge bg-secondary">N/A</span>';
            const s = String(status).toLowerCase();
            if (s.includes('paid')) return '<span class="badge bg-success">' + status + '</span>';
            if (s.includes('pending')) return '<span class="badge bg-warning text-dark">' + status + '</span>';
            if (s.includes('partial')) return '<span class="badge bg-info text-dark">' + status + '</span>';
            if (s.includes('cancel')) return '<span class="badge bg-danger">' + status + '</span>';
            return '<span class="badge bg-secondary">' + status + '</span>';
        }

        function fetchFilteredData(filterType, startDate = null, endDate = null) {
            toggleLoader(true);

            $.ajax({
                url: "{{ route('admin.purchases-return.filter') }}",
                method: 'GET',
                data: {
                    filter: filterType,
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    const rows = Array.isArray(response.data) ? response.data.map((row, idx) => ([
                        idx + 1, // ID (client index)
                        row.date ?? 'N/A',
                        row.supplier ?? 'N/A',
                        row.warehouse ?? 'N/A',
                        row.product ?? 'N/A',
                        row.quantity ?? 0,
                        row.net_unit_cost ?? '₹0.00', // already formatted by backend
                        row.status ? badge(row.status) : badge(null),
                        row.grand_total ?? '₹0.00' // already formatted by backend
                    ])) : [];

                    table.clear();
                    table.rows.add(rows);
                    table.draw();
                },
                error: function() {
                    alert('Failed to load data.');
                },
                complete: function() {
                    toggleLoader(false);
                }
            });
        }

        $(document).ready(function() {
            table = $('#example').DataTable({
                columns: [{
                        title: "ID",
                        className: "text-center"
                    },
                    {
                        title: "Date"
                    },
                    {
                        title: "Supplier"
                    },
                    {
                        title: "Warehouse"
                    },
                    {
                        title: "Product"
                    },
                    {
                        title: "Stock",
                        className: "text-center"
                    },
                    {
                        title: "Unit Price",
                        className: "text-end"
                    },
                    {
                        title: "Status"
                    },
                    {
                        title: "Grand Total",
                        className: "text-end"
                    }
                ],
                pageLength: 25,
                order: [
                    [1, 'desc']
                ]
            });

            const defaultFilter = $('#date-range').val();
            fetchFilteredData(defaultFilter);

            $('#date-range').on('change', function() {
                const value = $(this).val();
                if (value === 'custom') {
                    $('#custom-date-range').removeClass('d-none');
                } else {
                    $('#custom-date-range').addClass('d-none');
                    fetchFilteredData(value);
                }
            });

            $('#search-date-range').on('click', function() {
                const startDate = $('#start-date').val();
                const endDate = $('#end-date').val();
                if (startDate && endDate) {
                    fetchFilteredData('custom', startDate, endDate);
                } else {
                    alert('Please select both start and end dates.');
                }
            });
        });
    </script>
@endpush
