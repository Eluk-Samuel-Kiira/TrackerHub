<div class="card-body py-4" id="reloadRequisitionComponent">
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
                    </div>
                </th>
                <th class="min-w-125px">{{__('Req-ID')}}</th>
                <th class="min-w-125px">{{__('Title')}}</th>
                <th class="min-w-125px">{{__('Project')}}</th>
                <th class="min-w-125px">{{__('Amount')}}</th>
                <th class="min-w-125px">{{__('Creator')}}</th>
                <th class="min-w-125px">{{__('Created At')}}</th>
                <th class="min-w-125px">{{__('Status')}}</th>
                <th class="min-w-125px">{{__('Approval Status')}}</th>
                <th class="text-end min-w-100px">{{__('Actions')}}</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            @if (!empty($requisitions) && $requisitions->count() > 0)
                @foreach ($requisitions as $requisition)
                    <tr data-role="{{ strtolower($requisition->name) }}"
                        style="{{ $requisition->status === 'approved' ? 'background-color: #f8d7da;' : '' }}"
                    >
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td>
                            <div class="badge badge-light fw-bold">{{__('ID-')}}{{ $requisition->id }}</div>
                        </td>
                        <td>{{ $requisition->name }}</td>
                        <td>{{ $requisition->requisitionProject->projectName ?? 'none' }}</td>
                        <td>{{ $requisition->amount }}</td>
                        <td>{{ $requisition->requisitionCreater->name ?? 'None' }}
                        </td>
                        <td>
                            <div class="badge badge-light fw-bold">{{ $requisition->created_at->format('d M Y, h:i a') }}</div>
                        </td>
                        <td>
                            <select name="status" class="form-select form-select-solid form-select-sm"
                            style="appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: none; padding-right: 10px;" 
                                 onchange="updateStatus({{ $requisition->id }}, this.value)">
                                <option value="1" {{ $requisition->isActive == 1 ? 'selected' : '' }}><span>{{__('Active')}}</option>
                                <option value="0" {{ $requisition->isActive == 0 ? 'selected' : '' }}>{{__('Inactive')}}</option>
                            </select>
                        </td>
                        <td>
                        <select 
                            name="response" 
                            class="form-select form-select-solid form-select-sm" 
                            style="appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: none; padding-right: 10px;" 
                            onchange="updateResponse({{ $requisition->id }}, this.value)">
                            <option value="pending" {{ $requisition->status == 'pending' ? 'selected' : '' }}>
                                {{__('Pending')}}
                            </option>
                            <option value="approved" {{ $requisition->status == 'approved' ? 'selected' : '' }}>
                                {{__('Approved')}}
                            </option>
                            <option value="denied" {{ $requisition->status == 'denied' ? 'selected' : '' }}>
                                {{__('Denied')}}
                            </option>
                        </select>
                        </td>
                        <td>
                            
                            <button 
                                class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editRequisition{{$requisition->id}}"
                                onclick="initializeCKEditor('kt_docs_ckeditor_classic_{{$requisition->id}}')">
                                <i class="bi bi-pencil-square fs-2"></i>
                            </button>
                            
                            <button 
                                class="btn btn-sm btn-icon btn-bg-light btn-active-color-success w-30px h-30px" 
                                data-bs-toggle="modal" 
                                data-bs-target="#attachDocuments{{$requisition->id}}">
                                <i class="bi bi-folder-symlink fs-2"></i>
                            </button>
                            
                            <button type="button" 
                                class="btn btn-sm btn-icon btn-bg-light btn-active-color-danger w-30px h-30px" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteRequisitionModal{{$requisition->id}}">
                                <i class="bi bi-trash fs-2"></i>
                            </button>

                            <div class="modal fade" id="deleteRequisitionModal{{$requisition->id}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('Confirm Deletion') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ __('Are you sure you want to delete this Requistion?') }}</p>
                                            <p>{{ __('This action cannot be undone.') }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- Discard Button -->
                                            <button type="button" id="closeDeleteModal{{$requisition->id}}" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('Discard') }}</button>
                                            <!-- Confirm Button -->
                                            <button type="button" id="deleteButton{{$requisition->id}}" class="btn btn-danger" 
                                                data-item-url="{{ route('requistion.destroy', $requisition->id) }}" 
                                                data-item-id="{{ $requisition->id }}"
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
                            @include('requistions.partials.edit-requisition')
                            @include('requistions.partials.documents')
                            
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>


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

        

    }

    
    function setupTableSearch(inputId, tableId) {
        LiveBlade.searchTableItems(inputId, tableId)
    }
    
    
    document.addEventListener('DOMContentLoaded', function() {
        setupTableSearch('searchInput', 'kt_table_users');
        
    });
</script>