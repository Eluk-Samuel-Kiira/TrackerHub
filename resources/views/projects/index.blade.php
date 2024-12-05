@extends('layouts.app')
@section('title', 'Projects')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">{{__('Projects Table')}}</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        @php
                            $previousUrl = url()->previous();
                            $previousRouteName = optional(app('router')->getRoutes()->match(request()->create($previousUrl)))->getName();
                            $formattedRouteName = $previousRouteName 
                                ? Str::of($previousRouteName)->replace('.', ' ')->title() 
                                : __('Back');
                        @endphp
                        <a href="{{ $previousUrl }}" class="text-muted text-hover-primary">
                            {{ $formattedRouteName }}
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{__('Projects')}}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <button type="button" class="btn btn-sm btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <i class="ki-duotone ki-filter fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>{{__('Filter')}}</button>
                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                    <div class="px-7 py-5">
                        <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                    </div>
                    <div class="separator border-gray-200"></div>
                    
                    <!-- Search Bar -->
                    <div class="px-7 py-5">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search Projects...">
                    </div>
                </div>

                <button class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#add_project_modal">Add Project</button>
                
                @include('projects.projects.create-project')   
            </div>
        </div>
    </div>
    
    <div class="card-body py-4" id="">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
                        </div>
                    </th>
                    <th class="min-w-50px">Code</th>
                    <th class="min-w-100px">Name</th>
                    <!-- <th class="min-w-100px">Start Date</th> -->
                    <th class="min-w-100px">Deadline</th>
                    <!-- <th class="min-w-200px">Description</th> -->
                    <th class="min-w-150px">Category</th>
                    <!-- <th class="min-w-150px">Department</th> -->
                    <th class="min-w-150px">Client</th>
                    <!-- <th class="min-w-200px">Members</th> -->
                    <th class="min-w-150px">Project Cost</th>
                    <!-- <th class="min-w-150px">Budget</th>
                    <th class="min-w-150px">Budget Limit</th> -->
                    <th class="min-w-150px">Progress</th>
                    <th class="w-auto">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td>{{ $project->projectCode }}</td>
                        <td>{{ $project->projectName }}</td>
                        <!-- <td>{{ $project->projectStartDate }}</td> -->
                        <td>{{ $project->projectDeadlineDate }}</td>
                        <!-- <td>{!! trim_description($project->projectDescription,5) !!}</td> -->
                        <td>{{ $project->projectCategory->name }}</td>
                        <!-- <td>{{ $project->department->name }}</td> -->
                        <td>{{ $project->client->name }}</td>
                        <!-- <td>
                            @foreach ($project->users as $index => $member)
                                {{ $member->first_name }} {{ $member->last_name }}@if($index < $project->users->count() - 1), @endif
                            @endforeach
                        </td> -->
                        <td>{{ $project->currency->name }} {{ number_format($project->projectCost,2) }}</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar"
                                    style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </td>
                        <!-- <td>{{ $project->currency->name }} {{ number_format($project->projectBudgetLimit,2) }}</td> -->
                        <td class="d-flex align-items-center justify-content-start">
                            <a href="{{route('projects.show', $project) }}" class="btn btn-sm btn-icon btn-bg-light btn-active-color-success w-30px h-30px" >
                            <i class="bi bi-eye fs-2"></i></a>
                            <button 
                                class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editClient{{$project->id}}">
                                <i class="bi bi-pencil-square fs-2"></i>
                            </button>
                            <button 
                                class="btn btn-sm btn-icon btn-bg-light btn-active-color-danger w-30px h-30px" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteProject{{$project->id}}">
                                <i class="bi bi-trash fs-2"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No projects found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="modal bg-body fade" tabindex="-1" id="edit_project_modal">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content shadow-none">
                <div class="modal-header">
                    <h1>Edit Project</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="col-12">
                        <form class="card" id="editProjectForm" method="POST">
                            @method("PUT")
                            @csrf
                            <div class="card-body shadow-none">
                                <div class="row row-cards py-5">
                                    <div class="col-sm-6 col-md-2">
                                        <div class="mb-10">
                                            <label class="form-label">Code</label>
                                            <input type="text" name="projectCode" class="form-control" placeholder="Project Code">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="mb-10">
                                            <label class="form-label">Project Name</label>
                                            <input type="text" name="projectName" class="form-control" placeholder="Project Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-10">
                                            <label for="" class="form-label">Start Date</label>
                                            <input class="form-control flatpickr-input" name="projectStartDate" placeholder="Pick date" id="kt_datepicker_1edit" type="text" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-10">
                                            <label for="" class="form-label">Deadline</label>
                                            <input class="form-control flatpickr-input" name="projectDeadlineDate" placeholder="Pick date" id="kt_datepicker_2edit" type="text" readonly="readonly">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-10">
                                            <label class="form-label">Description</label>
                                            <textarea id="kt_docs_ckeditor_classic1" name="projectDescription">
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="mb-10">
                                            <label class="form-label">Project Category</label>
                                            <div class="d-flex">
                                                <select id="project_category" name="projectCategoryId" class="form-select me-2" data-dropdown-parent="#edit_project_modal" data-allow-clear="true" data-control="select2" data-placeholder="Select a category">
                                                    <option></option>
                                                    @foreach ($projectCategories as $projectCategory)
                                                        <option value="{{ $projectCategory->id }}">{{ $projectCategory->name }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-stacked-modal="#add_project_category_modal">Add</button> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4">
                                        <div class="mb-10">
                                            <label class="form-label">Department</label>
                                            <div class="d-flex">
                                                <select id="department" class="form-select me-2" name="projectDepartmentId" data-dropdown-parent="#edit_project_modal" data-control="select2" data-allow-clear="true" data-placeholder="Select a department">
                                                    <option></option>
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-stacked-modal="#add_department_modal">Add</button> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4">
                                        <div class="mb-10">
                                            <label class="form-label">Client</label>
                                            <div class="d-flex">
                                                <select id="client" class="form-select me-2" name="projectClientId" data-dropdown-parent="#edit_project_modal" data-control="select2" data-allow-clear="true" data-placeholder="Select a client">
                                                    <option></option>
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-stacked-modal="#add_clients_modal">Add</button> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-12">
                                        <div class="mb-10">
                                            <label class="form-label">Project Members</label>
                                            <div class="d-flex">
                                                <select id="user" class="form-select form-select" name="projectMemberIds[]" data-control="select2" data-allow-clear="true" data-dropdown-parent="#edit_project_modal" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                                                    <option></option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-stacked-modal="#add_users_modal">Add</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-10">
                                            <label class="form-label">Budget</label>
                                            <input type="text" class="form-control" name="projectBudget" placeholder="Budget">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-10">
                                            <label class="form-label">Budget Limit</label>
                                            <input type="text" class="form-control" name="projectBudgetLimit" placeholder="Budget Limit">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-10">
                                            <label class="form-label">Project Cost</label>
                                            <input type="text" class="form-control" name="projectCost" placeholder="Project Cost">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-10">
                                            <label class="form-label">Currency</label>
                                            <div class="d-flex">
                                                <select id="currency" class="form-select form-select" name="projectCurrencyId" data-dropdown-parent="#edit_project_modal" data-control="select2" data-allow-clear="true" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                                                    <option></option>
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-stacked-modal="#add_currency_modal">Add</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end" style="margin-top:-5rem;">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--begin::Modal - New Target-->
    <div class="modal fade" id="add_users_modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <!--begin:Form-->
                    <form id="add_users_modal_form">
                        @csrf
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 class="mb-3">Add User</h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="row g-9 mb-8">

                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">First Name</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" id="user_first_name" class="form-control form-control-solid" name="user_first_name" />
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Last Name</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" id="user_last_name" class="form-control form-control-solid" name="user_last_name" />
                            </div>
                        </div>
                        <div class="row g-9 mb-8">

                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">User Email</span>
                                </label>
                                <!--end::Label-->
                                    <input type="text" id="user_email" class="form-control form-control-solid" name="user_email" />
                            </div>
                        </div>
                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Role</span>
                                </label>
                                <!--end::Label-->
                                <select id="user_role" name="user_role" class="form-select form-select" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">User Department</span>
                                </label>
                                <!--end::Label-->
                                <select id="user_department" name="user_department" class="form-select form-select" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <div class="text-center">
                            <button class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Add</span>
                            </button>
                        </div>
                    </form>
                    <!--end:Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - New Target-->

<script>
    
    function setupTableSearch(inputId, tableId) {
        LiveBlade.searchTableItems(inputId, tableId)
    }
    
    
    document.addEventListener('DOMContentLoaded', function() {
        setupTableSearch('searchInput', 'kt_table_users');
        
    });
</script>

@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editProjectModal = document.getElementById('edit_project_modal');
        var editorInstance; // Variable to store the CKEditor instance

        // Initialize CKEditor and store the instance
        if (!editorInstance) {
            ClassicEditor
                .create(document.querySelector('#kt_docs_ckeditor_classic1'))
                .then(editor => {
                    editorInstance = editor;
                })
                .catch(error => {
                    console.error(error);
                });
        }

        editProjectModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var project = JSON.parse(button.getAttribute('data-project'));

            //console.log(project); // Log the project object to verify data

            // Update form action with project ID
            var form = document.getElementById('editProjectForm');
            form.action = '/projects/' + project.id;

            // Populate the modal fields
            editProjectModal.querySelector('input[name="projectCode"]').value = project.projectCode || '';
            editProjectModal.querySelector('input[name="projectName"]').value = project.projectName || '';
            editProjectModal.querySelector('input[name="projectStartDate"]').value = project.projectStartDate || '';
            editProjectModal.querySelector('input[name="projectDeadlineDate"]').value = project.projectDeadlineDate || '';

            // Set CKEditor content
            if (editorInstance) {
                editorInstance.setData(project.projectDescription || '');
            }

            // Set selected values for dropdowns
            setDropdownSelectedValue(editProjectModal, 'select[name="projectCategoryId"]', project.projectCategoryId);
            setDropdownSelectedValue(editProjectModal, 'select[name="projectDepartmentId"]', project.projectDepartmentId);
            setDropdownSelectedValue(editProjectModal, 'select[name="projectClientId"]', project.projectClientId);
            setDropdownSelectedValue(editProjectModal, 'select[name="projectCurrencyId"]', project.projectCurrencyId);

            editProjectModal.querySelector('input[name="projectBudget"]').value = project.projectBudget || '';
            editProjectModal.querySelector('input[name="projectBudgetLimit"]').value = project.projectBudgetLimit || '';
            editProjectModal.querySelector('input[name="projectCost"]').value = project.projectCost || '';

            // Populate project members
            var projectMembersSelect = editProjectModal.querySelector('select[name="projectMemberIds[]"]');
            $(projectMembersSelect).val(null).trigger('change'); // Clear previous selections
            var selectedUserIds = project.users.map(user => user.id);
            $(projectMembersSelect).val(selectedUserIds).trigger('change'); // Set new selections

            // Trigger change event for Select2 to update the display
            $(editProjectModal).find('select').each(function() {
                $(this).trigger('change');
            });
        });

        // Function to set the selected value for a dropdown
        function setDropdownSelectedValue(modal, selector, value) {
            var dropdown = modal.querySelector(selector);
            if (dropdown) {
                var option = dropdown.querySelector('option[value="' + value + '"]');
                if (option) {
                    option.selected = true;
                }
            }
        }
    });
</script>
@endpush
