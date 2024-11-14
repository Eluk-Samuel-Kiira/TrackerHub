<div class="modal fade edit-role-modal" id="direct_permissions{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">{{ __('Edit Role') }}</h2>
                <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body scroll-y mx-lg-5 my-7">
                <div id="status"></div>
                <form id="direct_permissions_form{{ $user->id }}" class="form">
                    @csrf
                    @method('PUT')
                    <div class="fv-row mb-10">
                        <label class="fs-5 fw-bold form-label mb-2">
                            <span class="required">{{ ucwords(str_replace('_', ' ', $user->first_name . ' ' . $user->last_name)) }}</span>
                        </label>
                        <input class="form-control form-control-solid" type="hidden" value="{{ $user->id }}" name="user_id" required/>
                        <div id="user_id{{ $user->id }}"></div>
                    </div>
                    <div class="fv-row">
                        <label class="fs-5 fw-bold form-label mb-2">{{ __('Role Permissions') }}</label>
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                <tbody class="text-gray-600 fw-semibold">
                                    <tr>
                                        <td class="text-gray-800">
                                            <label class="form-check form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox" id="kt_roles_select_all{{ $user->id }}" />
                                                <span class="form-check-label">{{ __('Select all') }}</span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                @foreach ($permissions as $permission)
                                                    <div class="col-md-4">
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                            <input class="form-check-input permission-checkbox" type="checkbox" 
                                                                value="{{ $permission->id }}" 
                                                                id="permission{{ $permission->id }}" 
                                                                name="permissions[]"
                                                                {{ in_array($permission->id, $user->permissions->pluck('id')->toArray()) ? 'checked' : '' }} />
                                                            <span class="form-check-label">{{ $permission->name }}</span>
                                                        </label><br>
                                                    </div>
                                                @endforeach
                                                <div id="permissions{{ $user->id }}"></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" id="closeModalButton{{ $user->id }}" data-bs-dismiss="modal">{{ __('Discard') }}</button>
                        <button type="button" onclick="editInstanceLoop({{ $user->id }})" class="btn btn-primary" id="submitButton{{ $user->id }}">
                            <span class="indicator-label">{{ __('Update') }}</span>
                            <span class="indicator-progress" style="display: none;">
                                {{ __('Please wait...') }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    // Function to initialize each modal
    function initializeModal(userId) {
        const selectAllCheckbox = document.getElementById(`kt_roles_select_all${userId}`);
        const permissionCheckboxes = document.querySelectorAll(`#direct_permissions_form${userId} .permission-checkbox`);

        // Function to update "Select All" checkbox based on the individual checkboxes' state
        function updateSelectAllCheckbox() {
            const allChecked = Array.from(permissionCheckboxes).every(checkbox => checkbox.checked);
            selectAllCheckbox.checked = allChecked;
        }

        // Handle "Select All" checkbox click event to toggle all permissions
        selectAllCheckbox.addEventListener('change', function () {
            permissionCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        // Handle individual permission checkbox change event
        permissionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectAllCheckbox);
        });

        // Initial update of "Select All" checkbox on modal load
        updateSelectAllCheckbox();
    }

    // Initialize modal only when it is opened
    function initializeModalOnClick(userId) {
        const modal = document.getElementById(`direct_permissions${userId}`);
        
        // Initialize modal when it's opened
        modal.addEventListener('shown.bs.modal', function () {
            initializeModal(userId);
        });
    }
</script>


<script>
    function getCheckedValues(uniqueId) {
        // Fetch all checked checkboxes and map to their values, confirming it's an array
        const checkedValues = Array.from(document.querySelectorAll(`#direct_permissions_form${uniqueId} .permission-checkbox:checked`))
                                .map(cb => cb.value);
        return checkedValues;
    }

    function editInstanceLoop(uniqueId) {
        const submitButton = document.getElementById('submitButton' + uniqueId);
        LiveBlade.toggleButtonLoading(submitButton, true);

        // Select the form and create FormData from it
        var form = document.getElementById('direct_permissions_form' + uniqueId);
        var formData = new FormData(form);

        // Get the checked permission values as an array
        var permissions = getCheckedValues(uniqueId);
        permissions.forEach(permissionId => formData.append('permissions[]', permissionId));
        var data = Object.fromEntries(formData.entries());

        // Confirm permissions as an array in final data object
        data.permissions = permissions;

        // Set up the URL dynamically
        var updateUrl = @json(route('permission.update', ['id' => ':id'])).replace(':id', uniqueId);
        // console.log(updateUrl)

        // Submit form data asynchronously
        LiveBlade.editLoopForms(data, updateUrl)
            .then(noErrorStatus => {
                if (noErrorStatus) {
                    var closeButton = document.getElementById('closeModalButton' + uniqueId);
                    if (closeButton) {
                        closeButton.click();
                    }
                }
                })
                .catch(error => {
                    console.error('An unexpected error occurred:', error);
                    // Display user-friendly error feedback here, if needed
                })
                .finally(() => {
                    // End loading state using reusable function
                    LiveBlade.toggleButtonLoading(submitButton, false);
                });


    }

</script>

<script>
    function getCheckedValues(uniqueId) {
        // Fetch all checked checkboxes and map to their values, confirming it's an array
        const checkedValues = Array.from(document.querySelectorAll(`#direct_permissions_form${uniqueId} .permission-checkbox:checked`))
                                .map(cb => cb.value);
        return checkedValues;
    }

    function editInstanceLoop(uniqueId) {
        const submitButton = document.getElementById('submitButton' + uniqueId);
        LiveBlade.toggleButtonLoading(submitButton, true);

        // Select the form and create FormData from it
        var form = document.getElementById('direct_permissions_form' + uniqueId);
        var formData = new FormData(form);

        // Get the checked permission values as an array
        var permissions = getCheckedValues(uniqueId);
        permissions.forEach(permissionId => formData.append('permissions[]', permissionId));
        var data = Object.fromEntries(formData.entries());

        // Confirm permissions as an array in final data object
        data.permissions = permissions;

        // Set up the URL dynamically
        var updateUrl = @json(route('permission.update', ['id' => ':id'])).replace(':id', uniqueId);
        // console.log(updateUrl)

        // Submit form data asynchronously
        LiveBlade.editLoopForms(data, updateUrl)
            .then(noErrorStatus => {
                if (noErrorStatus) {
                    var closeButton = document.getElementById('closeModalButton' + uniqueId);
                    if (closeButton) {
                        closeButton.click();
                    }
                }
                })
                .catch(error => {
                    console.error('An unexpected error occurred:', error);
                    // Display user-friendly error feedback here, if needed
                })
                .finally(() => {
                    // End loading state using reusable function
                    LiveBlade.toggleButtonLoading(submitButton, false);
                });


    }

</script>

