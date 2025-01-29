
<div class="modal bg-body fade" tabindex="-1" id="add_project_modal">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content shadow-none">
            <div class="modal-header">
                <h1>Project Information</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="col-12">
                    <form class="card" id="kt_modal_add_project_form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body shadow-none">
                            <div class="row row-cards py-5">
                                <!-- <div class="col-sm-6 col-md-2">
                                    <div class="mb-10">
                                        <label class="form-label">Code</label>
                                        <input type="text" name="projectCode" class="form-control" placeholder="Project Code">
                                        <div id="projectCode"></div>
                                    </div>
                                </div> -->
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label class="form-label">Project Name</label>
                                        <input type="text" name="projectName" class="form-control" placeholder="Project Name">
                                        <div id="projectName"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label for="" class="form-label">Start Date</label>
                                        <input class="form-control flatpickr-input" name="projectStartDate" placeholder="Pick date" id="kt_datepicker_1" type="text" readonly="readonly">
                                        <div id="projectStartDate"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label for="" class="form-label">Deadline</label>
                                        <input class="form-control flatpickr-input" name="projectDeadlineDate" placeholder="Pick date" id="kt_datepicker_2" type="text" readonly="readonly">
                                        <div id="projectDeadlineDate"></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-10">
                                        <label class="form-label">Description</label>
                                        <textarea id="kt_docs_ckeditor_classic" name="projectDescription">
                                        </textarea>                                        
                                        <div id="projectDescription"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label class="form-label">Project Category</label>
                                        <div class="d-flex">
                                            <select id="project_category" name="projectCategoryId" class="form-select me-2" data-dropdown-parent="#add_project_modal" data-allow-clear="true" data-control="select2" data-placeholder="Select a category">
                                                <option></option>
                                                @foreach ($projectCategories as $projectCategory)
                                                    <option value="{{ $projectCategory->id }}">{{ $projectCategory->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-stacked-modal="#add_project_category_modal">Add</button>
                                        </div>
                                        <div id="projectCategoryId"></div>
                                    </div>
                                </div>

                                <!-- <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label class="form-label">Department</label>
                                        <div class="d-flex">
                                            <select id="department" class="form-select me-2" name="projectDepartmentId" data-dropdown-parent="#add_project_modal" data-control="select2" data-allow-clear="true" data-placeholder="Select a department">
                                                <option></option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-stacked-modal="#add_department_modal">Add</button>
                                        </div>                                            
                                        <div id="projectDepartmentId"></div>
                                    </div>
                                </div> -->

                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label class="form-label">Client/Company</label>
                                        <div class="d-flex">
                                            <select id="client" class="form-select me-2" name="projectClientId" data-dropdown-parent="#add_project_modal" data-control="select2" data-allow-clear="true" data-placeholder="Select a client">
                                                <option></option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-stacked-modal="#add_clients_modal">Add</button>
                                        </div>
                                        <div id="projectClientId"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label class="form-label">Currency</label>
                                        <div class="d-flex">
                                            <select id="currency" class="form-select form-select" name="projectCurrencyId" data-dropdown-parent="#add_project_modal" data-control="select2" data-allow-clear="true" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                                                <option></option>
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-stacked-modal="#add_currency_modal">Add</button>
                                        </div>
                                        <div id="projectCurrencyId"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-12">
                                    <div class="mb-10">
                                        <label class="form-label">Project Members</label>
                                        <div class="d-flex">
                                            <select id="user" class="form-select form-select" name="projectMemberIds[]" data-control="select2" data-allow-clear="true" data-dropdown-parent="#add_project_modal" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                                                <option></option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-stacked-modal="#add_users_modal">Add</button>
                                        </div>
                                        <div id="projectMemberIds"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-12">
                                    <div class="mb-10">
                                        <label class="form-label">Meeting Type</label><br>
                                        <div>
                                            <input type="radio" id="onlineMeeting" name="meetingType" value="online" onclick="toggleMeetingType()" checked>
                                            <label for="onlineMeeting">Online</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="physicalMeeting" name="meetingType" value="physical" onclick="toggleMeetingType()">
                                            <label for="physicalMeeting">Physical</label>
                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <label class="form-label" for="meetingDate">Schedule Meeting</label><br>
                                        <input id="meetingDate" name="meetingDate" class="form-control" type="text" placeholder="Select a date and time" />
                                    </div>

                                    <!-- Location field, hidden by default -->
                                    <div class="mb-10" id="locationField" style="display: none;">
                                        <label class="form-label" for="meetingLocation">Meeting Location</label><br>
                                        <input id="meetingLocation" name="meetingLocation" class="form-control" type="text" placeholder="Enter location" />
                                    </div>
                                </div>
                                <script>
                                    function toggleMeetingType() {
                                        const isPhysical = document.getElementById('physicalMeeting').checked;
                                        const locationField = document.getElementById('locationField');

                                        if (isPhysical) {
                                            locationField.style.display = 'block'; // Show location input
                                        } else {
                                            locationField.style.display = 'none'; // Hide location input
                                        }
                                    }
                                </script>


                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label class="form-label">Budget</label>
                                        <input type="text" class="form-control" name="projectBudget" placeholder="Budget">
                                        <div id="projectBudget"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label class="form-label">Budget Limit</label>
                                        <input type="text" class="form-control" name="projectBudgetLimit" placeholder="Budget Limit">
                                        <div id="projectBudgetLimit"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label class="form-label">Project Cost</label>
                                        <input type="text" class="form-control" name="projectCost" placeholder="Project Cost">
                                        <div id="projectCost"></div>
                                    </div>
                                </div>
                                
                                <div class="mb-10">
                                    <label class="form-label">Attach Files(Optional)</label><br>
                                </div>
                                    
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label class="form-label">Document Name</label>
                                        <input type="text" class="form-control" name="documentName" />
                                        <div id="documentName"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label class="form-label">Document Type</label>
                                        <select class="form-select form-select" name="documentTypeId"
                                            data-control="select2" data-allow-clear="true"
                                            data-close-on-select="false" data-placeholder="Select an option"
                                            data-allow-clear="true">
                                            <option></option>
                                            @foreach ($documentTypes as $documentType)
                                                <option value="{{ $documentType->id }}">{{ $documentType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="documentTypeId"></div>
                                </div>
                                    
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label class="form-label">Document</label>
                                        <input type="file" class="form-control" name="document" />
                                    </div>
                                    <div id="document"></div>
                                </div>

                            </div>
                            <button type="reset" class="btn btn-light me-3" id="discardCategoryButton" data-bs-dismiss="modal">Discard</button>
                            <button id="submitProjectButton" type="submit" class="btn btn-primary" id>
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
    function getSelectedProjectMemberIds() {
        const selectElement = document.getElementById('user');
        return Array.from(selectElement.selectedOptions).map(option => option.value);
    }


    const submitFormEntities = (formId, submitButtonId, url, method = 'POST') => {
        document.getElementById(formId).addEventListener('submit', function(e) {
            e.preventDefault();
            // Reference the submit button and reloading
            const submitButton = document.getElementById(submitButtonId);
            LiveBlade.toggleButtonLoading(submitButton, true);

            let projectMemberIds = [];
            document.querySelectorAll('#user option:checked').forEach((option) => {
                projectMemberIds.push(option.value);
            });

            // Collect form data and add additional fields
            const formData = Object.fromEntries(new FormData(this));
            formData._method = method;
            formData.routeName = url;
            formData.projectMemberIds = projectMemberIds;

            console.log(formData);
            


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
                        window.location.href = '{{ route('projects.index') }}';
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

    submitFormEntities('kt_modal_add_project_form', 'submitProjectButton', '{{ route('projects.store') }}');
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Initialize Flatpickr on the input field
    flatpickr("#meetingDate", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
</script>

