 
<div class="modal fade" id="editRequisition{{ $requisition->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_client">
                <h2 class="fw-bold">{{__('Edit Requisition')}}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_edit_requisition_form{{ $requisition->id }}" class="form">
                    @csrf
                    @method('PUT')
                    <div class="text-center pt-10">
                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Title</span>
                                </label>
                                <select name="project_id" class="form-select form-select" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}" {{ $requisition->project_id == $project->id ? 'selected' : '' }}>{{ $project->projectName }}</option>
                                    @endforeach
                                </select>
                                <div id="project_id{{ $requisition->id }}"></div>
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Requisition Amount</span>
                                </label>
                                <input type="number" value="{{ $requisition->amount }}" class="form-control form-control-solid" name="amount" />
                                <div id="amount{{ $requisition->id }}"></div>
                            </div>
                        </div>

                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-12">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Requisition Title</span>
                                </label>
                                <input type="text" value="{{ $requisition->name }}" class="form-control form-control-solid" name="name" />
                                <div id="name{{ $requisition->id }}"></div>
                            </div>
                        </div>

                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-12">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Requisition Description</span>
                                </label>
                                <textarea name="description" id="kt_docs_ckeditor_classic_{{$requisition->id}}">
                                    {!! e($requisition->description) !!}
                                </textarea>
                                <div id="description{{ $requisition->id }}"></div>
                            </div>
                        </div>

                        <button type="reset" class="btn btn-light me-3" id="closeModalEditButton{{ $requisition->id }}" data-bs-dismiss="modal">Discard</button>
                        <button onclick="editInstanceLoop({{$requisition->id }})" id="editClientButton{{ $requisition->id }}" type="button" class="btn btn-primary" {{ $requisition->status === 'approved' ? 'disabled' : '' }}>
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
<style>
    .ck-editor__editable {
        min-height: 200px; /* Adjust the height as needed */
    }
    .ck-toolbar {
        position: fixed; 
        top: 0;
        z-index: 10;
    }
</style>

<script>
    let editorInstance = null; // Store the CKEditor instance globally

    function initializeCKEditor(textareaId) {
        // If an editor instance already exists, destroy it
        if (editorInstance) {
            editorInstance.destroy().then(() => {
                // console.log('CKEditor instance destroyed');
            }).catch(error => {
                // console.error('Error destroying CKEditor:', error);
            });
        }

        // Initialize CKEditor for the new textarea
        ClassicEditor
            .create(document.querySelector(`#${textareaId}`))
            .then(editor => {
                editorInstance = editor; // Store the new CKEditor instance
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
    }
    
    function editInstanceLoop(uniqueId) {
        const submitButton = document.getElementById('editClientButton' + uniqueId);
        LiveBlade.toggleButtonLoading(submitButton, true);

        // Select the form and create FormData from it
        var form = document.getElementById('kt_modal_edit_requisition_form' + uniqueId);
        var formData = new FormData(form);
        if (editorInstance) {
            var editorContent = editorInstance.getData(); 
            formData.append('description', editorContent); 
        }

        var data = Object.fromEntries(formData.entries());
        // console.log(data);

        // Set up the URL dynamically
        var updateUrl = '{{ route('requistion.update', ['requistion' => ':id']) }}'.replace(':id', uniqueId);

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


