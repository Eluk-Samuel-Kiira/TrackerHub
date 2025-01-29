
<div class="modal bg-body fade" tabindex="-1" id="edit_project_modal{{$project->id}}">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content shadow-none">
            <div class="modal-header">
                <h1>Edit Project - {{$project->projectName}}</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="col-12">
                    <form class="card" id="editProjectForm{{$project->id}}">
                        @csrf   
                        @method('PUT')                                  

                        <div class="card-body shadow-none">
                            <div class="row row-cards py-5">
                                <div class="col-sm-6 col-md-2">
                                    <div class="mb-10">
                                        <label class="form-label">Code</label>
                                        <input type="text" name="projectCode" value="{{ $project->projectCode }}" class="form-control" readonly>
                                        <div id="projectCode{{$project->id}}"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-10">
                                        <label class="form-label">Project Name</label>
                                        <input type="text" name="projectName" value="{{ $project->projectName }}"  class="form-control" placeholder="Project Name">
                                        <div id="projectName{{$project->id}}"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-10">
                                        <label for="" class="form-label">Start Date</label>
                                        <input class="form-control flatpickr-input" name="projectStartDate"  value="{{ $project->projectStartDate }}" placeholder="Pick date" id="kt_datepicker_1edit" type="text" readonly="readonly">
                                        <div id="projectStartDate{{$project->id}}"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-10">
                                        <label for="" class="form-label">Deadline</label>
                                        <input class="form-control flatpickr-input" name="projectDeadlineDate" value="{{ $project->projectDeadlineDate }}"  placeholder="Pick date" id="kt_datepicker_2edit" type="text" readonly="readonly">
                                        <div id="projectDeadlineDate{{$project->id}}"></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-10">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="projectDescription" >
                                            {!! $project->projectDescription !!}
                                        </textarea>
                                        <div id="projectDescription{{$project->id}}"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label">Project Category</label>
                                        <div class="d-flex">
                                            <select id="project_category" name="projectCategoryId" class="form-select me-2" data-dropdown-parent="#edit_project_modal" data-allow-clear="true" data-control="select2" data-placeholder="Select a category">
                                                <option></option>
                                                @foreach ($projectCategories as $projectCategory)
                                                    <option value="{{ $projectCategory->id }}" {{ $project->projectCategoryId == $projectCategory->id ? 'selected' : '' }}>{{ $projectCategory->name }}</option>
                                                @endforeach
                                            </select>
                                            <div id="projectCategoryId{{$project->id}}"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label">Client</label>
                                        <div class="d-flex">
                                            <select id="client" class="form-select me-2" name="projectClientId" data-dropdown-parent="#edit_project_modal" data-control="select2" data-allow-clear="true" data-placeholder="Select a client">
                                                <option></option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}"  {{ $project->projectClientId == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                                @endforeach
                                            </select>
                                            <div id="projectClientId{{$project->id}}"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-10">
                                        <label class="form-label">Budget</label>
                                        <input type="text" class="form-control"  value="{{ $project->projectBudget }}"  name="projectBudget" placeholder="Budget">
                                        <div id="projectBudget{{$project->id}}"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-10">
                                        <label class="form-label">Budget Limit</label>
                                        <input type="text" class="form-control"  value="{{ $project->projectBudgetLimit }}" name="projectBudgetLimit" placeholder="Budget Limit">
                                        <div id="projectBudgetLimit{{$project->id}}"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-10">
                                        <label class="form-label">Project Cost</label>
                                        <input type="text" class="form-control"  value="{{ $project->projectCost }}" name="projectCost" placeholder="Project Cost">
                                        <div id="projectCost{{$project->id}}"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-10">
                                        <label class="form-label">Currency</label>
                                        <div class="d-flex">
                                            <select id="currency" class="form-select form-select" name="projectCurrencyId" data-dropdown-parent="#edit_project_modal" data-control="select2" data-allow-clear="true" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                                                <option></option>
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}"  {{ $project->projectCurrencyId == $currency->id ? 'selected' : '' }}>{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                            <div id="projectCurrencyId{{$project->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end" style="margin-top:-5rem;">
                            <button type="reset" class="btn btn-light me-3" id="closeModalEditButton{{ $project->id }}" data-bs-dismiss="modal">Discard</button>
                            <button onclick="editInstanceLoop({{$project->id }})" id="editProjectButton{{ $project->id }}" type="button" class="btn btn-primary">
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
</div>


<script>
        function editInstanceLoop(uniqueId) {
        const submitButton = document.getElementById('editProjectButton' + uniqueId);
        LiveBlade.toggleButtonLoading(submitButton, true);

        // Select the form and create FormData from it
        var form = document.getElementById('editProjectForm' + uniqueId);
        var formData = new FormData(form);
        

        var data = Object.fromEntries(formData.entries());
        // console.log(data);

        // Set up the URL dynamically
        var updateUrl = '{{ route('projects.update', ['project' => ':id']) }}'.replace(':id', uniqueId);

        // Submit form data asynchronously
        LiveBlade.editLoopForms(data, updateUrl)
            .then(noErrorStatus => {
                if (noErrorStatus) {
                    var closeButton = document.getElementById('closeModalEditButton' + uniqueId);
                    if (closeButton) {
                        closeButton.click();
                    }
                    
                    window.location.href = '{{ route('projects.index') }}';
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
