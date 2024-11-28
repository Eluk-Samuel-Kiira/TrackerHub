@extends('layouts.app')
@section('title', 'Projects')

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Projects</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Projects</li>
            </ul>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <button class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#add_project_modal">Add Project</button>
        </div>

    </div>

</div>
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1>
                Projects
            </h1>
            <div class="my-5">
                <div class="table-responsive">
                    <table class="table table-striped gy-7 gs-7">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                <th class="min-w-50px">Code</th>
                                <th class="min-w-100px">Name</th>
                                <th class="min-w-100px">Start Date</th>
                                <th class="min-w-100px">Deadline</th>
                                <th class="min-w-200px">Description</th>
                                <th class="min-w-150px">Category</th>
                                <th class="min-w-150px">Department</th>
                                <th class="min-w-150px">Client</th>
                                <th class="min-w-200px">Members</th>
                                <th class="min-w-150px">Budget</th>
                                <th class="min-w-150px">Budget Limit</th>
                                <th class="w-auto"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($projects as $project)
                                <tr>
                                    <td>{{ $project->projectCode }}</td>
                                    <td>{{ $project->projectName }}</td>
                                    <td>{{ $project->projectStartDate }}</td>
                                    <td>{{ $project->projectDeadlineDate }}</td>
                                    <td>{!! trim_description($project->projectDescription,5) !!}</td>
                                    <td>{{ $project->projectCategory->name }}</td>
                                    <td>{{ $project->department->name }}</td>
                                    <td>{{ $project->client->name }}</td>
                                    <td>
                                        @foreach ($project->users as $index => $member)
                                            {{ $member->first_name }} {{ $member->last_name }}@if($index < $project->users->count() - 1), @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $project->currency->name }} {{ number_format($project->projectBudget,2) }}</td>
                                    <td>{{ $project->currency->name }} {{ number_format($project->projectBudgetLimit,2) }}</td>
                                    <td><a href="{{route('projects.show', $project) }}">View</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">No projects found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

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
                        <form class="card" action="{{ route('projects.store') }}" method="POST">
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
                                            <input class="form-control flatpickr-input" name="projectStartDate" placeholder="Pick date" id="kt_datepicker_1" type="text" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-10">
                                            <label for="" class="form-label">Deadline</label>
                                            <input class="form-control flatpickr-input" name="projectDeadlineDate" placeholder="Pick date" id="kt_datepicker_2" type="text" readonly="readonly">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-10">
                                            <label class="form-label">Description</label>
                                            <textarea id="kt_docs_ckeditor_classic" name="projectDescription">
                                            </textarea>
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
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4">
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
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4">
                                        <div class="mb-10">
                                            <label class="form-label">Client</label>
                                            <div class="d-flex">
                                                <select id="client" class="form-select me-2" name="projectClientId" data-dropdown-parent="#add_project_modal" data-control="select2" data-allow-clear="true" data-placeholder="Select a client">
                                                    <option></option>
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-stacked-modal="#add_clients_modal">Add</button>
                                            </div>
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
                                                <select id="currency" class="form-select form-select" name="projectCurrencyId" data-dropdown-parent="#add_project_modal" data-control="select2" data-allow-clear="true" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                                                    <option></option>
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-stacked-modal="#add_currency_modal">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end" style="margin-top:-5rem;">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
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

@endsection
