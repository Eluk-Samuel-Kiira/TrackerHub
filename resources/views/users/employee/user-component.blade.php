
<div class="card-body py-4" id="reloadEmployeeComponent">
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
                    </div>
                </th>
                <th class="min-w-125px">{{__('Employee ID')}}</th>
                <th class="min-w-125px">{{__('Name')}}</th>
                <th class="min-w-125px">{{__('Role')}}</th>
                <th class="min-w-125px">{{__('Telephone')}}</th>
                <th class="min-w-125px">{{__('Job Title')}}</th>
                <th class="min-w-125px">{{__('Department')}}</th>
                <th class="min-w-125px">{{__('Created At')}}</th>
                <th class="min-w-125px">{{__('Status')}}</th>
                <th class="text-end min-w-100px">{{__('Actions')}}</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            @if (!empty($employees) && $employees->count() > 0)
                @foreach ($employees as $employee)
                    <tr data-role="{{ strtolower($employee->role) }}">
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td>
                            <div class="badge badge-light fw-bold">{{__('EMPL-')}}{{ $employee->id }}</div>
                        </td>
                        <td class="d-flex align-items-center">
                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                <a href="apps/user-management/users/view.html">
                                    <div class="symbol-label">
                                        <img src="assets/media/avatars/300-6.jpg" alt="{{ $employee->first_name }}" class="w-100" />
                                    </div>
                                </a>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">{{ $employee->first_name . ' ' . $employee->last_name }}</a>
                                <span>{{ $employee->email }}</span>
                            </div>
                        </td>
                        <td>{{ ucwords(str_replace('_', ' ', $employee->role)) }}</td>
                        <td>
                            <div class="badge badge-light fw-bold">{{ $employee->telephone_number }}</div>
                        </td>
                        <td>{{ $employee->job_title }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $employee->departmentName->name)) }}</td>
                        <td>{{ $employee->created_at->format('d M Y, h:i a') }}</td>
                        <td>
                            <select name="status" class="form-select form-select-solid form-select-sm" onchange="updateStatus({{ $employee->id }}, this.value)">
                                <option value="active" {{ $employee->status === 'active' ? 'selected' : '' }}><span>{{__('Active')}}</option>
                                <option value="inactive" {{ $employee->status === 'inactive' ? 'selected' : '' }}>{{__('Inactive')}}</option>
                            </select>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">{{__('Actions')}} 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <div class="menu-item px-3">
                                    <a href="apps/user-management/users/view.html" class="menu-link px-3">{{__('Edit')}}</a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">{{__('Delete')}}</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<script>

    function initializeComponentScripts() {
        // Get the DataTable element
        const tableId = '#kt_table_users';
        
        // Destroy the existing DataTable instance if it exists
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().destroy();
        }

        // Reinitialize the DataTable
        $(tableId).DataTable({
            // Add your DataTable options here
            paging: true,
            searching: true,
            ordering: true,
            responsive: true,
            language: {
                emptyTable: "No data available",
            },
        });
    }


    document.addEventListener('DOMContentLoaded', function () {
        LiveBlade.setupTableFilter('#roleFilter', '#kt_table_users', 'role');
    });

    
    function setupTableSearch(inputId, tableId) {
        LiveBlade.searchTableItems(inputId, tableId)
    }
    
    
    document.addEventListener('DOMContentLoaded', function() {
        setupTableSearch('searchInput', 'kt_table_users');
        
    });
</script>
