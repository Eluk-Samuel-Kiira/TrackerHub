<section>
    <form id="updateMetaInfoForm" class="form">
        @csrf
        @method('patch')
        <div class="card-body border-top p-9">

            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-semibold fs-6">Meta Keyword</label>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12 fv-row">
                            <input type="text" name="meta_keyword" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{ $app_info->meta_keyword }}" />
                            <div id="meta_keyword"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-semibold fs-6">Meta Description</label>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12 fv-row">
                            <textarea name="meta_descrip" class="form-control" id="meta_descrip" rows="4">{{ $app_info->meta_descrip }}</textarea>
                            <div id="meta_descrip"></div>
                        </div>
                    </div>
                </div>
            </div>

        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button id="submitMetaInfo" type="submit" class="btn btn-primary">
                <span class="indicator-label">Submit</span>
                <span class="indicator-progress" style="display: none;">
                    Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    </form>

</section>