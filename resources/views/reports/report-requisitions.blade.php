<x-app-layout>
    @section('title', __('Requisitions Report'))
    @section('content')
    
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">{{__('Project Rquisitions Report')}}</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        @php
                            $previousUrl = url()->previous();
                            $previousRouteName = optional(app('router')->getRoutes()->match(request()->create($previousUrl)))->getName();
                            $formattedRouteName = $previousRouteName 
                                ? Str::of($previousRouteName)->replace('.', ' ')->title() 
                                : __('Back');
                        @endphp
                        <a href="{{ $previousUrl }}" class="text-muted text-hover-primary">
                            {{ $formattedRouteName }}
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{__('Project Requisitions')}}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div id="status"></div>
                <div class="card">
                    <div class="container mt-5">
                        <table class="table table-bordered" id="kt_table_project">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Project Code</th>
                                    <th>Project Name</th>
                                    <th>Amount</th>
                                    <th>Creator</th>
                                    <th>Approval Status</th>
                                    <th>Payment Status</th>
                                    <th>Paid By</th>
                                    <th>Paid On</th>
                                    <th>Voucher</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_amount_approved = 0;
                                @endphp
                                @forelse($requisitions as $requisition)
                                    <tr>
                                        <td>{{ $requisition->id }}</td>
                                        <td>{{ $requisition->name }}</td>
                                        <td>{{ $requisition->requisitionProject->projectCode }}</td>
                                        <td>{{ $requisition->requisitionProject->projectName }}</td>
                                        <td>{{ number_format($requisition->amount, 2) }}</td>
                                        <td>{{ $requisition->requisitionCreater->name }}</td>
                                        <td>{{ $requisition->status }}</td>
                                        <td>{{ $requisition->isPaid == 1 ? 'Paid' : 'Unpaid' }}</td>
                                        <td>{{ $requisition->requisitionAccountant->name }}</td>
                                        <td>{{ $requisition->updated_at }}</td>
                                        <td>{{ $requisition->voucher }}</td>
                                    </tr>
                                    @php
                                        $total_amount_approved = $total_amount_approved + $requisition->amount;
                                    @endphp
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No Requisitions found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{__('Total Amount Approved: ')}} {{ number_format($total_amount_approved, 2) }}
                </h1>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#kt_table_project').DataTable({
                dom: 'Bfrtip', // Enables buttons and filtering options
                buttons: [
                    {
                        extend: 'csvHtml5',
                        text: 'Download CSV',
                        className: 'btn btn-primary'
                    },
                    {
                        extend: 'print',
                        text: 'Print Table',
                        className: 'btn btn-secondary'
                    }
                ],
                paging: true, // Enable pagination
                searching: true, // Enable search/filter
                ordering: true, // Enable sorting
                responsive: true, // Enable responsiveness
            });
        });
    </script>


    @endsection
</x-app-layout>