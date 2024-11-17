<section>
    <form id="updateProfileInfoForm" class="form">
        @csrf
        @method('patch')
        <div class="card-body border-top p-9">
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
                <div class="col-lg-8">
                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                        <div class="image-input-wrapper w-125px h-125px" id="profile-img-preview" style="background-image: url(assets/media/avatars/300-1.jpg)"></div>
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                            <i class="ki-duotone ki-pencil fs-7">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg" onchange="previewAndUploadProfileImage(event)"/>
                            <input type="hidden" name="avatar_remove" />
                        </label>
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                            <i class="ki-duotone ki-cross fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                            <i class="ki-duotone ki-cross fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                    </div>
                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                </div>
            </div>

            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-semibold fs-6">Full Name</label>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-6 fv-row">
                            <input type="text" name="first_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{ $user->first_name }}" />
                            <div id="first_name"></div>
                        </div>
                        <div class="col-lg-6 fv-row">
                            <input type="text" name="last_name" class="form-control form-control-lg form-control-solid" value="{{ $user->last_name }}" />
                            <div id="last_name"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-semibold fs-6">Email</label>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12 fv-row">
                            <input type="email" name="email" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{ $user->email }}" />
                            <div id="email"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button id="submitProfileButton" type="submit" class="btn btn-primary">
                <span class="indicator-label">Submit</span>
                <span class="indicator-progress" style="display: none;">
                    Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    </form>



    
    <script>
        
        // Function to preview and upload the selected profile image with validation
        function previewAndUploadProfileImage(event) {
            const image = document.getElementById('profile-img-preview');
            const file = event.target.files[0];
            
            // Validate file type (accept only images)
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            const allowedError = '{{__('Image Type Not Allowed')}}'
            if (!allowedTypes.includes(file.type)) {
                alert(allowedError);
                return;
            }

            // Validate file size (e.g., limit to 2MB)
            const maxSize = 5 * 1024 * 1024; // 5MB in bytes
            const allowedSize = '{{__('Image Size Too Large')}}'
            if (file.size > maxSize) {
                alert(allowed_size);
                return;
            }

            // If validation passes, show image preview and upload file
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    image.src = e.target.result;
                }
                reader.readAsDataURL(file);

                // Automatically upload the file
                uploadProfileImage(file);
            }
        }

        // Function to upload the image via AJAX
        function uploadProfileImage(file) {
            const formData = new FormData();
            formData.append('profile_image', file); // Append the file to the FormData object

            fetch('{{ route("profile.upload_image") }}', {
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
                const message = '{{__('An Error Occurred')}}'
                console.error(message, error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: message,
                });
            });
        }
    </script>

</section>
