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
                        <select name="file_type" class="form-select">
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
                        <button type="button" class="btn btn-light-primary w-100" 
                                onclick="document.getElementById('imageInput_{{ $requisition->id }}').click()">
                            <i class="ki-duotone ki-folder-up fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            {{ __('Select Files') }}
                        </button>
                        <input type="file" id="imageInput_{{ $requisition->id }}" style="display:none;" multiple class="w-100"
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
                                            <p class="mb-0 text-muted">Document Type: {{ $file->fileType->name ?? 'none' }}</p>
                                        </div>
                                        <!-- Action Buttons -->
                                        <div>
                                            <a href="{{ asset('storage/requisition_files/' . $file->requisition_id . '/' . $file->file_name) }}" 
                                            class="btn btn-info btn-sm me-2" download>
                                                Download
                                            </a>
                                            <button class="btn btn-danger btn-sm delete-file" 
                                                    data-file-id="{{ $file->id }}" 
                                                    data-file-location="{{ asset('storage/requisition_files/' . $file->requisition_id . '/' . $file->file_name) }}"
                                                    data-requisition-id="{{ $file->requisition_id }}">
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
    // Delete button click handler
    $(document).on('click', '.delete-file', function() {
        var fileId = $(this).data('file-id');  // Get the file ID
        var fileLocation = $(this).data('file-location');  // Get the file location
        var requisitionId = $(this).data('requisition-id');  // Get the requisition ID
        var fileItem = $('#file-' + fileId); 
        

        // Confirm the delete action with the user
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                fileItem.css('display', 'none');
                $.ajax({
                    url: '{{ route('requisition.deleteFile') }}', 
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',       
                        file_id: fileId,               // The ID of the file to delete
                        file_location: fileLocation,   // The file location (path) to delete from storage
                        requisition_id: requisitionId,       
                    },
                    success: function(response) {
                        if(response.success) {
                            Swal.fire('Deleted!', 'Your file has been deleted.', 'success');
                        } else {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'There was an error processing your request.', 'error');
                        fileItem.css('display', 'block');
                    }
                });
            } else {
                fileItem.css('display', 'block');
            }
        });
    });

</script>

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
                text: 'Please select a file type before uploading.',
                toast: true,
                showConfirmButton: false,
                position: 'top-end',
                timer: 3000,
            });
            return;
        }

        if (files.length > 0) {
            const formData = new FormData();

            // Append all files to the FormData object
            Array.from(files).forEach((file, index) => {
                formData.append(`files[${index}]`, file);
            });

            // Append the selected file type to FormData
            formData.append('file_type', selectedFileType);
            console.log(formData);

            fetch(uploadRoute, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to upload image');
                }
                return response.json();
            })
            .then(data => {
                const message = '{{__('Image Updated Successfully')}}'
                console.log(message, data);
                // Optionally handle success or update image path here
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: message,
                }).then(() => {
                    // Refresh the page after success
                    location.reload();
                });
            })
            .catch(error => {
                const message = '{{__('File Are Larger than 5mbs')}}'
                console.error(message, error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: message,
                });
            });

        }
    }
</script>
