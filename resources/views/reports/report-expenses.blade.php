<x-app-layout>
    @section('title', __(' Expenses Reports'))
    @section('content')
    
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">{{__('Project Progress Report')}}</h1>
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
                    <li class="breadcrumb-item text-muted">{{__('Project Progress')}}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <button type="button" class="btn btn-sm btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <i class="ki-duotone ki-filter fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>{{__('Filter')}}</button>
                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                    <div class="px-7 py-5">
                        <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                    </div>
                    <div class="separator border-gray-200"></div>
                </div>

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
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Project Name</th>
                                    <th> Budget</th>
                                    <th> BudgetLimit</th>
                                    <th>Total Approved</th>
                                    <th>Limit Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($combinedData as $data)
                                    <tr>
                                        <td>{{ $data['project']->id }}</td>
                                        <td>{{ $data['project']->projectCode }}</td>
                                        <td>{{ $data['project']->projectName }}</td>
                                        <td>{{ number_format($data['project']->projectBudget) }}</td>
                                        <td>{{ number_format($data['project']->projectBudgetLimit) }}</td>
                                        <td>{{ number_format($data['total_approved']) }}</td>
                                        <td>{{ number_format(($data['project']->projectBudgetLimit ?? 0) - ($data['total_approved'] ?? 0)) }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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

    <script>

        function setupTableSearch(inputId, tableId) {
            LiveBlade.searchTableItems(inputId, tableId)
        }


        document.addEventListener('DOMContentLoaded', function() {
            setupTableSearch('searchInput', 'kt_table_project');

        });
    </script>

    @endsection
</x-app-layout>