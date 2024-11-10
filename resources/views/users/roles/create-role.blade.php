<div class="modal fade" id="create_new_role" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">{{__('Add a Role')}}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body scroll-y mx-lg-5 my-7">
                <form id="kt_modal_add_role_form" class="form">
                    @csrf
                    <div class="fv-row mb-10">
                        <label class="fs-5 fw-bold form-label mb-2">
                            <span class="required">{{__('Role name')}}</span>
                        </label>
                        <input class="form-control form-control-solid" type="text" placeholder="Enter a role name" name="role_name" required/>
                    </div>
                    <div class="fv-row">
                        <label class="fs-5 fw-bold form-label mb-2">{{__('Role Permissions')}}</label>
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                <tbody class="text-gray-600 fw-semibold">
                                    <tr>
                                        <td class="text-gray-800">
                                            <label class="form-check form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox" id="kt_roles_select_all" />
                                                <span class="form-check-label" for="kt_roles_select_all">{{__('Select all')}}</span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                @foreach ($permissions as $permission)
                                                    <div class="col-md-4">
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                            <input class="form-check-input permission-checkbox" type="checkbox" value="{{ $permission->name }}" name="permissions[]" />
                                                            <span class="form-check-label">{{ $permission->name }}</span>
                                                        </label><br>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
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
    // Master checkbox logic
    document.getElementById('kt_roles_select_all').addEventListener('change', function () {
        const isChecked = this.checked;
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.checked = isChecked;
        });
    });
</script>

<script>
    const submitFormEntities = (formId, componentToReload) => {
        document.getElementById(formId).addEventListener('submit', function(e) {
            e.preventDefault();

            let permissions = [];
            document.querySelectorAll('.permission-checkbox:checked').forEach((checkbox) => {
                permissions.push(checkbox.value);
            });

            // Collect form data
            const formData = Object.fromEntries(new FormData(this));
            formData._method = 'POST';
            formData._route = '{{ route('role.store') }}';
            formData.permissions = permissions;

            console.log(formData)

            // Use LiveBlade to submit the form
            // LiveBlade.load(routeName, method, formData, `#${formId}`, componentToReload);
            // this.reset(); 
        });
    };

    submitFormEntities('kt_modal_add_role_form','');

</script>
