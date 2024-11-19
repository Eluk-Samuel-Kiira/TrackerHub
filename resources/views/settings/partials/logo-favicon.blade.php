<div class="card-body border-top p-9 d-flex">

<div class="d-flex flex-column align-items-center pe-6" style="flex: 1; border-right: 1px solid #e0e0e0;">
    <div class="row mb-6">
        <label class="col-form-label fw-semibold fs-6">Logo</label>
        <div class="col">
            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                <div class="image-input-wrapper w-125px h-125px" data-preview="logo-preview" style="background-image: url(assets/media/avatars/300-1.jpg)"></div>
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                    <i class="ki-duotone ki-pencil fs-7">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="file" data-type="logo" accept=".png, .jpg, .jpeg" onchange="previewAndUploadProfileImage(event)" />
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
        </div>
    </div>
</div>

<div class="d-flex flex-column align-items-center ps-6" style="flex: 1;">
    <div class="row mb-6">
        <label class="col-form-label fw-semibold fs-6">Favicon</label>
        <div class="col">
            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                <div class="image-input-wrapper w-125px h-125px" data-preview="favicon-preview" style="background-image: url(assets/media/avatars/300-1.jpg)"></div>
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                    <i class="ki-duotone ki-pencil fs-7">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="file" data-type="favicon" accept=".ico" onchange="previewAndUploadProfileImage(event)" />
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
        </div>
    </div>
</div>
</div>

<script>

    function previewAndUploadProfileImage(event) {
    const input = event.target; // Get the file input element
    const fileType = input.dataset.type; // Get the data-type (logo or favicon)
    const previewSelector = `[data-preview="${fileType}-preview"]`; // Match the correct preview container

    console.log(fileType)
    if (input.files && input.files[0]) {
        const file = input.files[0]; // Get the selected file
        const reader = new FileReader(); // Create a FileReader object

        reader.onload = function (e) {
            // Find the preview container based on the data-type
            const previewElement = document.querySelector(previewSelector);
            if (previewElement) {
                // Set the background image
                previewElement.style.backgroundImage = `url(${e.target.result})`;
            }
        };

        const formData = new FormData();
        formData.append("file", file); // Append the file
        formData.append("type", fileType); // Append the file type (logo or favicon)

        // Call the function to upload the file to the server
        uploadFile(formData);

        // Read the file as a Data URL
        reader.readAsDataURL(file);

    }

    function uploadFile(formData) {
        const type = formData.get('type'); // Extract the type (logo or favicon)
    
    // Determine the URL based on the type (logo or favicon)
    let uploadUrl = "";
    if (type === "logo") {
        uploadUrl = '{{ route('logo.upload') }}'; // Set URL for logo upload
    } else if (type === "favicon") {
        uploadUrl = '{{ route('favicon.upload') }}'; // Set URL for favicon upload
    } else {
        alert("Invalid file type");
        return; // Exit if the type is invalid
    }

    // Use fetch API to upload the file via POST request
    console.log(uploadUrl)
}




}

</script>