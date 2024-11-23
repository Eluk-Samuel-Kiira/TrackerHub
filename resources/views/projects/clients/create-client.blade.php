 
<div class="modal fade" id="kt_modal_add_client" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_client">
                <h2 class="fw-bold">{{__('Create Client')}}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_add_client_form" class="form">
                    @csrf
                    <input type="hidden" class="form-control form-control-solid" name="client_page" value="true"/>
                    <div class="text-center pt-10">
                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Client Name</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="client_name" />
                                <div id="client_name"></div>
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Client Email</span>
                                </label>
                                <input type="email" class="form-control form-control-solid" name="client_email" />
                                <div id="client_email"></div>
                            </div>
                        </div>

                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Address</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="client_address" />
                                <div id="client_address"></div>
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Phone Number</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="client_phone" />
                                <div id="client_phone"></div>
                            </div>
                        </div>

                        <button type="reset" class="btn btn-light me-3" id="discardCategoryButton" data-bs-dismiss="modal">Discard</button>
                        <button id="submitCategoryButton" type="submit" class="btn btn-primary" id>
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

    submitFormEntities('kt_modal_add_client_form', 'submitCategoryButton', '{{ route('clients.store') }}');
</script>

