
<div class="mb-10">
    <label class="form-label fs-6 fw-semibold">Two Step Verification:</label>
    <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="two-step" data-hide-search="true">
        <option></option>
        <option value="Enabled">Enabled</option>
    </select>
</div>


<div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
        <!--end::Label-->
        <!--begin::Image placeholder-->
        <style>.image-input-placeholder { background-image: url('assets/media/svg/files/blank-image.svg'); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }</style>
        <!--end::Image placeholder-->
        <!--begin::Image input-->
        <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
            <!--begin::Preview existing avatar-->
            <div class="image-input-wrapper w-125px h-125px" style="background-image: url(assets/media/avatars/300-6.jpg);"></div>
            <!--end::Preview existing avatar-->
            <!--begin::Label-->
            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                <i class="ki-duotone ki-pencil fs-7">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <!--begin::Inputs-->
                <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                <input type="hidden" name="avatar_remove" />
                <!--end::Inputs-->
            </label>
            <!--end::Label-->
            <!--begin::Cancel-->
            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                <i class="ki-duotone ki-cross fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </span>
            <!--end::Cancel-->
            <!--begin::Remove-->
            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                <i class="ki-duotone ki-cross fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </span>
            <!--end::Remove-->
        </div>
        <!--end::Image input-->
        <!--begin::Hint-->
        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
        <!--end::Hint-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fw-semibold fs-6 mb-2">Full Name</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" name="user_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name" value="Emma Smith" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fw-semibold fs-6 mb-2">Email</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="email" name="user_email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com" value="smith@kpmg.com" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="mb-5">
        <!--begin::Label-->
        <label class="required fw-semibold fs-6 mb-5">Role</label>
        <!--end::Label-->
        <!--begin::Roles-->
        <!--begin::Input row-->
        <div class="d-flex fv-row">
            <!--begin::Radio-->
            <div class="form-check form-check-custom form-check-solid">
                <!--begin::Input-->
                <input class="form-check-input me-3" name="user_role" type="radio" value="0" id="kt_modal_update_role_option_0" checked='checked' />
                <!--end::Input-->
                <!--begin::Label-->
                <label class="form-check-label" for="kt_modal_update_role_option_0">
                    <div class="fw-bold text-gray-800">Administrator</div>
                    <div class="text-gray-600">Best for business owners and company administrators</div>
                </label>
                <!--end::Label-->
            </div>
            <!--end::Radio-->
        </div>
        <!--end::Input row-->
        <div class='separator separator-dashed my-5'></div>
        <!--begin::Input row-->
        <div class="d-flex fv-row">
            <!--begin::Radio-->
            <div class="form-check form-check-custom form-check-solid">
                <!--begin::Input-->
                <input class="form-check-input me-3" name="user_role" type="radio" value="1" id="kt_modal_update_role_option_1" />
                <!--end::Input-->
                <!--begin::Label-->
                <label class="form-check-label" for="kt_modal_update_role_option_1">
                    <div class="fw-bold text-gray-800">Developer</div>
                    <div class="text-gray-600">Best for developers or people primarily using the API</div>
                </label>
                <!--end::Label-->
            </div>
            <!--end::Radio-->
        </div>
        <!--end::Input row-->
        <div class='separator separator-dashed my-5'></div>
        <!--begin::Input row-->
        <div class="d-flex fv-row">
            <!--begin::Radio-->
            <div class="form-check form-check-custom form-check-solid">
                <!--begin::Input-->
                <input class="form-check-input me-3" name="user_role" type="radio" value="2" id="kt_modal_update_role_option_2" />
                <!--end::Input-->
                <!--begin::Label-->
                <label class="form-check-label" for="kt_modal_update_role_option_2">
                    <div class="fw-bold text-gray-800">Analyst</div>
                    <div class="text-gray-600">Best for people who need full access to analytics data, but don't need to update business settings</div>
                </label>
                <!--end::Label-->
            </div>
            <!--end::Radio-->
        </div>
        <!--end::Input row-->
        <div class='separator separator-dashed my-5'></div>
        <!--begin::Input row-->
        <div class="d-flex fv-row">
            <!--begin::Radio-->
            <div class="form-check form-check-custom form-check-solid">
                <!--begin::Input-->
                <input class="form-check-input me-3" name="user_role" type="radio" value="3" id="kt_modal_update_role_option_3" />
                <!--end::Input-->
                <!--begin::Label-->
                <label class="form-check-label" for="kt_modal_update_role_option_3">
                    <div class="fw-bold text-gray-800">Support</div>
                    <div class="text-gray-600">Best for employees who regularly refund payments and respond to disputes</div>
                </label>
                <!--end::Label-->
            </div>
            <!--end::Radio-->
        </div>
        <!--end::Input row-->
        <div class='separator separator-dashed my-5'></div>
        <!--begin::Input row-->
        <div class="d-flex fv-row">
            <!--begin::Radio-->
            <div class="form-check form-check-custom form-check-solid">
                <!--begin::Input-->
                <input class="form-check-input me-3" name="user_role" type="radio" value="4" id="kt_modal_update_role_option_4" />
                <!--end::Input-->
                <!--begin::Label-->
                <label class="form-check-label" for="kt_modal_update_role_option_4">
                    <div class="fw-bold text-gray-800">Trial</div>
                    <div class="text-gray-600">Best for people who need to preview content data, but don't need to make any updates</div>
                </label>
                <!--end::Label-->
            </div>
            <!--end::Radio-->
        </div>
        <!--end::Input row-->
        <!--end::Roles-->
    </div>
    <!--end::Input group-->
</div>