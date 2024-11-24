 
<div class="modal fade" id="kt_modal_add_requistion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_requistion">
                <h2 class="fw-bold">{{__('Create New Requistion')}}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_add_requistion_form" class="form">
                    @csrf
                    <input type="hidden" class="form-control form-control-solid" name="requistion_page" value="true"/>
                    <div class="text-center pt-10">
                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Title</span>
                                </label>
                                <select name="project_id" class="form-select form-select" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->projectName }}</option>
                                    @endforeach
                                </select>
                                <div id="project_id"></div>
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Requisition Amount</span>
                                </label>
                                <input type="number" class="form-control form-control-solid" name="amount" />
                                <div id="amount"></div>
                            </div>
                        </div>

                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-12">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Requisition Title</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="name" />
                                <div id="name"></div>
                            </div>
                        </div>

                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-12">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Requisition Description</span>
                                </label>
                                <textarea name="description" id="kt_docs_ckeditor_classic"></textarea>
                                <div id="description"></div>
                            </div>
                        </div>

                        <button type="reset" class="btn btn-light me-3" id="discardCategoryButton" data-bs-dismiss="modal">Discard</button>
                        <button id="submitRequisitionButton" type="submit" class="btn btn-primary" id>
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait... 
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>  


<script>
    const submitFormEntities = (formId, submitButtonId, url, method = 'POST') => {
        document.getElementById(formId).addEventListener('submit', function(e) {
            e.preventDefault();

            // Collect form data and add additional fields
            const formData = Object.fromEntries(new FormData(this));
            formData._method = method;
            formData.routeName = url;

            // Reference the submit button and reloading
            const submitButton = document.getElementById(submitButtonId);
            LiveBlade.toggleButtonLoading(submitButton, true);

            // Submit form data asynchronously
            LiveBlade.submitFormItems(formData)
                .then(noErrors => {
                    console.log(noErrors);
                    
                    if (noErrors) {
                        // Close the modal if no errors
                        const closeModal = () => {
                            document.getElementById('discardCategoryButton').click();
                        };
                        closeModal();
                    }
                })
                .catch(error => {
                    console.error('An unexpected error occurred:', error);
                })
                .finally(() => {
                    LiveBlade.toggleButtonLoading(submitButton, false);
                });

                
        });
    };

    submitFormEntities('kt_modal_add_requistion_form', 'submitRequisitionButton', '{{ route('requistion.store') }}');
</script>

