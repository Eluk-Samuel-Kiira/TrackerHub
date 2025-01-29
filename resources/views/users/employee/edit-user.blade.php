
<div class="modal fade delete-user-modal" id="editUserModal{{$employee->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">{{ __('Edit Employee') }}</h2>
                <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body scroll-y mx-lg-5 my-7">
                <div id="status"></div>
                <form id="edit_user_form{{ $employee->id }}" class="form">
                    @csrf
                    @method('PUT')
                    <div class="text-center pt-10">
                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">First Name</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="first_name" value="{{ $employee->first_name }}" />
                                <div id="first_name{{ $employee->id }}"></div>
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Last Name</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="last_name" value="{{ $employee->last_name }}" />
                                <div id="last_name{{ $employee->id }}"></div>
                            </div>
                        </div>

                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">User Email</span>
                                </label>
                                <input type="email" class="form-control form-control-solid" name="email" value="{{ $employee->email }}" />
                                <div id="email{{ $employee->id }}"></div>
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Phone Number</span>
                                </label>
                                <input type="number" class="form-control form-control-solid" name="telephone_number" value="{{ $employee->telephone_number }}" />
                                <div id="telephone_number{{ $employee->id }}"></div>
                            </div>
                        </div>
                        
                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">User Job Title</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" value="{{ $employee->job_title }}" name="job_title" />
                                <div id="job_title{{ $employee->id }}"></div>
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Account Status</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" value="{{ $employee->status }}" name="status" readonly/>
                            </div>
                        </div>
                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-12">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Role</span>
                                </label>
                                <select name="role" class="form-select form-select" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                                    <option value="" disabled {{ is_null($employee->role) ? 'selected' : '' }}></option>  <!-- Optional blank/empty option -->
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" 
                                                @if($role->name == $employee->role) 
                                                    selected 
                                                @endif>
                                            {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="role{{ $employee->id }}"></div>
                            </div>
                            <input type="hidden" id="department_id" value="2" class="form-control form-control-solid" name="department_id" />

                        </div>
                    </div>
                        
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" id="closeModalEditButton{{ $employee->id }}" data-bs-dismiss="modal">{{ __('Discard') }}</button>
                        <button type="button" onclick="editInstanceLoop({{$employee->id }})" class="btn btn-primary" id="submitButton{{ $employee->id }}">
                            <span class="indicator-label">{{ __('Submit') }}</span>
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
    
    function editInstanceLoop(uniqueId) {
        const submitButton = document.getElementById('submitButton' + uniqueId);
        LiveBlade.toggleButtonLoading(submitButton, true);

        // Select the form and create FormData from it
        var form = document.getElementById('edit_user_form' + uniqueId);
        var formData = new FormData(form);

        var data = Object.fromEntries(formData.entries());
        // console.log(data);

        // Set up the URL dynamically
        var updateUrl = '{{ route('employee.update', ['employee' => ':id']) }}'.replace(':id', uniqueId);

        // Submit form data asynchronously
        LiveBlade.editLoopForms(data, updateUrl)
            .then(noErrorStatus => {
                if (noErrorStatus) {
                    var closeButton = document.getElementById('closeModalEditButton' + uniqueId);
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


