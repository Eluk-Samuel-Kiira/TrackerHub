<section>
    <form id="updateAppInfoForm" class="form">
        @csrf
        @method('patch')
        <div class="card-body border-top p-9">

            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-semibold fs-6">App Name</label>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12 fv-row">
                            <input type="text" name="app_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{ $app_info->app_name }}" />
                            <div id="app_name"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-semibold fs-6">App Email</label>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12 fv-row">
                            <input type="text" name="app_email" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{ $app_info->app_email }}" />
                            <div id="app_email"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-semibold fs-6">App Contact</label>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12 fv-row">
                            <input type="number" name="app_contact" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{ $app_info->app_contact }}" />
                            <div id="app_contact"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button id="submitAppInfo" type="submit" class="btn btn-primary">
                <span class="indicator-label">Submit</span>
                <span class="indicator-progress" style="display: none;">
                    Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    </form>

</section>