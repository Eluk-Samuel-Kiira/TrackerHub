 
<div class="modal fade" id="editClient{{ $client->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_client">
                <h2 class="fw-bold">{{__('Edit Client')}} - {{ $client->name }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_edit_client_form{{ $client->id }}" class="form">
                    @csrf
                    @method('PUT')
                    <div class="text-center pt-10">
                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Client Name</span>
                                </label>
                                <input type="text"  value="{{ $client->name }}" class="form-control form-control-solid" name="client_name" />
                                <div id="client_name{{ $client->id }}"></div>
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Client Email</span>
                                </label>
                                <input type="email" value="{{ $client->email }}" class="form-control form-control-solid" name="client_email" />
                                <div id="client_email{{ $client->id }}"></div>
                            </div>
                        </div>

                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Address</span>
                                </label>
                                <input type="text" value="{{ $client->address }}" class="form-control form-control-solid" name="client_address" />
                                <div id="client_address{{ $client->id }}"></div>
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Phone Number</span>
                                </label>
                                <input type="text" value="{{ $client->phone }}" class="form-control form-control-solid" name="client_phone" />
                                <div id="client_phone{{ $client->id }}"></div>
                            </div>
                        </div>

                        <button type="reset" class="btn btn-light me-3" id="closeModalEditButton{{ $client->id }}" data-bs-dismiss="modal">Discard</button>
                        <button onclick="editInstanceLoop({{$client->id }})" id="editClientButton{{ $client->id }}" type="button" class="btn btn-primary" id>
                            <span class="indicator-label">Update</span>
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
    
    function editInstanceLoop(uniqueId) {
        const submitButton = document.getElementById('editClientButton' + uniqueId);
        LiveBlade.toggleButtonLoading(submitButton, true);

        // Select the form and create FormData from it
        var form = document.getElementById('kt_modal_edit_client_form' + uniqueId);
        var formData = new FormData(form);

        var data = Object.fromEntries(formData.entries());
        // console.log(data);

        // Set up the URL dynamically
        var updateUrl = '{{ route('clients.update', ['client' => ':id']) }}'.replace(':id', uniqueId);

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


