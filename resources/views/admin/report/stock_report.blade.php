@extends('admin.layouts.master')
@section('content')
    <div class="content">
        @include('admin.report.dashbodar-data.index')

        <!-- Navigation and Filters -->
        <div class="card mt-4">
            @include('admin.report.dashbodar-data.table_hader')

            <!-- DataTable -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Warehouse</th>
                                <th>Stock Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Leave empty; will be filled via AJAX --}}
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

        function fetchFilteredData(filterType, startDate = null, endDate = null) {
            toggleLoader(true);

            $.ajax({
                url: "{{ route('admin.stock.filter') }}",
                method: 'GET',
                data: {
                    filter: filterType,
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {

                    table.clear();
                    if (Array.isArray(response.data)) {
                        table.rows.add(response.data);
                    }
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
                        title: "ID"
                    },
                    {
                        title: "Product Name"
                    },
                    {
                        title: "Category"
                    },
                    {
                        title: "Warehouse"
                    },
                    {
                        title: "Stock Quantity",
                        className: "text-end"
                    }
                ],
                pageLength: 25,
                order: []
            });

            // First load
            const defaultFilter = $('#date-range').val();
            fetchFilteredData(defaultFilter);

            // Range dropdown behavior
            $('#date-range').on('change', function() {
                const value = $(this).val();

                if (value === 'custom') {
                    $('#custom-date-range').removeClass('d-none');
                } else {
                    $('#custom-date-range').addClass('d-none');
                    fetchFilteredData(value);
                }
            });

            // Custom range search
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
