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
                                <a href="#">
                                    <div class="symbol-label">
                                        <img src="assets/media/avatars/300-6.jpg" alt="{{ $employee->first_name }}" class="w-100" />
                                    </div>
                                </a>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="#" class="text-gray-800 text-hover-primary mb-1">{{ $employee->first_name . ' ' . $employee->last_name }}</a>
                                <span>{{ $employee->email }}</span>
                            </div>
                        </td>
                        <td>{{ ucwords(str_replace('_', ' ', $employee->role)) }}</td>
                        <td>
                            <div class="badge badge-light fw-bold">{{ $employee->telephone_number }}</div>
                        </td>
                        <td>{{ $employee->job_title }}</td>
                        <td>{{ $employee->created_at->format('d M Y, h:i a') }}</td>
                        <td>
                            <select name="status" class="form-select form-select-solid form-select-sm" onchange="updateStatus({{ $employee->id }}, this.value)"
                            @cannot('update user') disabled @endcannot>
                                <option value="active" {{ $employee->status === 'active' ? 'selected' : '' }}><span>{{__('Active')}}</span></option>
                                <option value="inactive" {{ $employee->status === 'inactive' ? 'selected' : '' }}>{{__('Inactive')}}</option>
                            </select>
                        </td>
                        <td class="d-flex align-items-center gap-2 flex-column flex-sm-row">
                            @can('edit user')
                                <button 
                                class="btn btn-sm btn-light btn-active-color-primary d-flex align-items-center px-3 py-2"  
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editUserModal{{$employee->id}}">
                                    <i class="bi bi-pencil-square me-1 fs-5"></i> <span>{{ __('Edit') }}</span>
                                </button>
                            @endcan
                            @can('delete user')
                                <button type="button" 
                                class="btn btn-sm btn-light btn-active-color-danger d-flex align-items-center px-3 py-2" 
                                data-bs-toggle="modal" 
                                    data-bs-target="#deleteUserModal{{$employee->id}}">
                                    <i class="bi bi-trash me-1 fs-5"></i> <span>{{ __('Delete') }}</span>                                </button>
                            @endcan

                            <!-- Delete User Modal -->
                            <div class="modal fade" id="deleteUserModal{{$employee->id}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('Confirm Deletion') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ __('Are you sure you want to delete this user/Employee?') }}</p>
                                            <p>{{ __('This action cannot be undone.') }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- Discard Button -->
                                            <button type="button" id="closeDeleteModal{{$employee->id}}" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('Discard') }}</button>
                                            <!-- Confirm Button -->
                                            <button type="button" id="deleteButton{{$employee->id}}" class="btn btn-danger" 
                                                data-item-url="{{ route('employee.destroy', $employee->id) }}" 
                                                data-item-id="{{ $employee->id }}"
                                                onclick="deleteItem(this)">
                                                <span class="indicator-label">{{ __('Confirm') }}</span>
                                                <span class="indicator-progress" style="display: none;">
                                                    {{ __('Please wait...') }}
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('users.employee.edit-user')

                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<script>

    function initializeComponentScripts() {
        const tableId = '#kt_table_users';

        // Destroy the existing DataTable instance if it exists
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().destroy();
        }

        // Reinitialize the DataTable
        $(tableId).DataTable({
            paging: true,
            searching: true,
            ordering: true,
            responsive: false, // Disable responsive behavior
            autoWidth: false, // Prevent automatic column resizing
            language: {
                emptyTable: "No data available",
            },
            columnDefs: [
                // Specify widths for specific columns (optional)
                { targets: 0, width: "10%" }, // Example for first column
                { targets: 1, width: "15%" },
            ],
        });

        
        LiveBlade.setupTableFilter('#roleFilter', '#kt_table_users', 'role');
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

<script>
    function deleteItem(button) {
        const itemId = button.getAttribute('data-item-id');
        const deleteUrl = button.getAttribute('data-item-url');

        const deleteButton = document.getElementById('deleteButton' + itemId);
        LiveBlade.toggleButtonLoading(deleteButton, true);
        
        // Call the delete function to handle the deletion
        LiveBlade.deleteItemInLoop(deleteUrl)
            .then(noErrorStatus => {
                console.log(noErrorStatus)
                if (noErrorStatus) {
                    var closeButton = document.getElementById('closeDeleteModal' + itemId);
                    if (closeButton) {
                        closeButton.click();
                    }
                }
            })
            .catch(error => {
                console.error('An unexpected error occurred:', error);
                // Handle error gracefully
            })
            .finally(() => {
                // End loading state using reusable function
                LiveBlade.toggleButtonLoading(deleteButton, false);
            });
    }
</script>
