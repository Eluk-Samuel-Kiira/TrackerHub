<div class="modal fade" id="attachDocuments{{ $requisition->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" id="kt_modal_add_client">
                <h2 class="fw-bold">{{ __('Requisition Files for ') . $requisition->name }}</h2>
                <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body px-5 my-7">
                <div class="row g-9 mb-8">
                    <!-- Select Project -->
                    <div class="d-flex flex-column mb-8 fv-row col-md-6">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">Select File Type </span>
                        </label>
                        <select name="file_type" class="form-select" data-control="select2" 
                                data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                            <option></option>
                            @foreach ($document_types as $document_type)
                                <option value="{{ $document_type->id }}">{{ $document_type->name }}</option>
                            @endforeach
                        </select>
                        <div id="file_type{{ $requisition->id }}"></div>
                    </div>

                    <!-- Upload Files -->
                    <div class="d-flex flex-column mb-8 fv-row col-md-6">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span>Upload Files</span>
                        </label>
                        <div class="input-group">
                            <button type="button" class="btn btn-light-primary" 
                                    onclick="document.getElementById('imageInput_{{ $requisition->id }}').click()">
                                <i class="ki-duotone ki-folder-up fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ __('Select Files') }}
                            </button>
                            <input type="file" id="imageInput_{{ $requisition->id }}" style="display:none;" multiple 
                                onchange="previewAndUploadImages(event, '{{ $requisition->id }}', '{{ route('requisition.upload', $requisition->id) }}')">
                        </div>
                    </div>

                    <!-- Files List -->
                    <div class="files-list">
                        @foreach($requistion_files as $file)
                            @if($file->requisition_id == $requisition->id)
                                <div id="file-{{ $file->id }}" class="file-item border p-3 mb-3 rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- File Information -->
                                        <div>
                                            <h5 class="mb-1">{{ $file->file_name }}</h5>
                                            <p class="mb-0 text-muted">Type: {{ $file->fileType->name ?? 'none' }}</p>
                                        </div>
                                        <!-- Action Buttons -->
                                        <div>
                                            <a href="{{ asset('requisition_files/' . $file->requisition_id . '/' . $file->file_name) }}" 
                                            class="btn btn-info btn-sm me-2" target="_blank">
                                                Download
                                            </a>
                                            <button class="btn btn-danger btn-sm delete-file" data-file-id="{{ $file->id }}">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>


<script>
    function previewAndUploadImages(event, requisitionId, uploadRoute) {
        const fileInput = event.target;
        const files = fileInput.files;

        // Get the selected file type value
        const fileTypeSelect = document.querySelector(`select[name="file_type"]`);
        const selectedFileType = fileTypeSelect.value;

        if (!selectedFileType) {
            Swal.fire({
                icon: 'warning',
                title: 'No File Type Selected',
                text: 'Please select a file type before uploading.',
                confirmButtonText: 'OK'
            });
            return; // Stop if no file type is selected
        }

        if (files.length > 0) {
            const formData = new FormData();

            // Append all files to the FormData object
            Array.from(files).forEach((file, index) => {
                formData.append(`files[${index}]`, file);
            });

            // Append the selected file type to FormData
            formData.append('file_type', selectedFileType);

            console.log('Uploading files...'); // Optional debug message

            fetch(uploadRoute, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'  // Include CSRF token
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Upload Successful',
                        text: 'Your files have been uploaded successfully!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Optional: Refresh file list or update UI
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Failed',
                        text: data.message || 'An error occurred while uploading the files.',
                        confirmButtonText: 'Try Again'
                    });
                }
            })
            .catch(error => {
                console.error('Error uploading files:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Failed',
                    text: 'An unexpected error occurred. Please try again later.',
                    confirmButtonText: 'OK'
                });
            });
        }
    }
</script>
