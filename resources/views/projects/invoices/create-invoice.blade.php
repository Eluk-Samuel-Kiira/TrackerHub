
<div class="modal bg-body fade" tabindex="-1" id="add_project_invoices_modal">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content shadow-none">
            <div class="modal-header">
                <h1>Add Project Invoice</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span
                                class="path2"></span></i>
                    </div>
                    <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="col-12">
                    <form class="card" id="kt_modal_add_invoice_form">
                        @csrf
                        <input type="hidden" name="projectId" value="{{ $project->id }}">
                        <input type="hidden" name="ClientId" value="{{ $project->projectClientId }}">
                        <div class="card-body shadow-none">
                            <div class="row row-cards py-5">
                                <div class="col-md-12">
                                    <div class="mb-10">
                                        <label class="form-label">Description</label>
                                        <input type="text" class="form-control" name="invoiceDescription" />
                                        <div id="invoiceDescription"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-10">
                                        <label class="form-label">Amount</label>
                                        <input type="text" class="form-control" name="invoiceAmount" />
                                        <div id="invoiceAmount"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label for="" class="form-label">Billed On</label>
                                        <input class="form-control flatpickr-input" name="invoiceBilledDate" placeholder="Pick date" id="kt_datepicker_1" type="text" readonly="readonly">
                                        <div id="invoiceBilledDate"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label for="" class="form-label">Invoice Due Date</label>
                                        <input class="form-control flatpickr-input" name="invoiceDueDate" placeholder="Pick date" id="kt_datepicker_2" type="text" readonly="readonly">
                                        <div id="invoiceDueDate"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end" style="margin-top:-5rem;">
                            <button type="reset" class="btn btn-light me-3" id="discardInvoiceButton" data-bs-dismiss="modal">Discard</button>
                            <button id="submitInvoiceButton" type="submit" class="btn btn-primary" id>
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
                            document.getElementById('discardInvoiceButton').click();
                        };
                        closeModal();
                        window.location.reload();
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

    submitFormEntities('kt_modal_add_invoice_form', 'submitInvoiceButton', '{{ route('invoices.add') }}');
</script>
