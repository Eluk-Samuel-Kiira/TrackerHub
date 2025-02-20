@extends('layouts.app')
@section('title', __($project->projectName))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Projects
                </h1>
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
        </div>

    </div>
    <div class="container">
        <div class="card ">
            <div class="card-header card-header-stretch d-flex align-items-center">
                <h3 class="card-title">{{ $project->projectName }}</h3>
                <div class="card-toolbar">
                    <ul class="nav nav-tabs nav-pills fs-6 border-0">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#overview">Overview</a>
                        </li>
                        @can('view members')
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#members">Members</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#meetings">Meetings</a>
                            </li>
                        @endcan
                        @can('view task')
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tasks">Tasks</a>
                            </li>
                        @endcan
                        @can('view files')
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#files">Files</a>
                            </li>
                        @endcan
                        @can('view invoice')
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#invoices">Invoices</a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                <div class="row">
                    <div class="col-md-6 my-5">
                        <div class="card hover-elevate-up shadow-sm parent-hover">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class="col">
                                        <h3 class="card-title text-gray-900 fw-bold fs-3 mb-4">Project Progress</h3>

                                        <!-- Progress Bar -->
                                        <div class="progress mb-4">
                                            <div 
                                                class="progress-bar progress-bar-striped bg-primary" 
                                                role="progressbar"
                                                style="width: {{ number_format($percentageCompletion, 2) }}%" 
                                                aria-valuenow="{{ number_format($percentageCompletion, 2) }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                                {{ number_format($percentageCompletion, 2) }}%
                                            </div>
                                        </div>

                                        <!-- Project Status Details -->
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <span class="fw-bold">Payment Status:</span> 
                                                <span class="{{ $project->txn_status == 'paid' ? 'text-success' : 'text-danger' }}">
                                                    {{ ucfirst($project->txn_status) }}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="fw-bold">Task Completion Status:</span> 
                                                <span class="{{ $project->completionStatus == 1 ? 'text-success' : 'text-warning' }}">
                                                    {{ $project->completionStatus == 1 ? 'Completed' : 'In Progress' }}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="fw-bold">Activity Status:</span> 
                                                <span class="{{ $project->isActive == 1 ? 'text-success' : 'text-muted' }}">
                                                    {{ $project->isActive == 1 ? 'Active' : 'Inactive' }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 my-5">
                        <div class="card shadow-sm border-0 hover-elevate-up">
                            <div class="card-body">
                                <div class="row gy-4">
                                    <!-- Client Section -->
                                    <div class="col-md-4 text-start">
                                        <h5 class="text-primary fw-bold text-uppercase mb-2">Client</h5>
                                        <p class="text-gray-800 fs-5 mb-0">{{ $project->client->name ?? 'none'  }}</p>
                                    </div>

                                    <!-- Category Section -->
                                    <div class="col-md-4 text-start">
                                        <h5 class="text-primary fw-bold text-uppercase mb-2">Category</h5>
                                        <p class="text-gray-800 fs-5 mb-0">{{ $project->projectCategory->name ?? 'none'  }}</p>
                                    </div>

                                    <!-- Department Section -->
                                    <div class="col-md-4 text-center">
                                        <h5 class="text-primary fw-bold text-uppercase mb-2">Client Reference</h5>
                                        <p class="text-gray-800 fs-5 mb-0">{{ $project->clientReference ?? 'none' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 my-5">
                        <div class="card shadow-sm border-0 hover-elevate-up">
                            <div class="card-body">
                                <div class="row text-center gy-4">
                                    <!-- Start Date Section -->
                                    <div class="col-md-4">
                                        <h5 class="text-primary fw-bold text-uppercase mb-2">Start Date</h5>
                                        <p class="text-gray-800 fs-5 mb-0">{{ $project->projectStartDate }}</p>
                                    </div>

                                    <!-- Deadline Section -->
                                    <div class="col-md-4">
                                        <h5 class="text-danger fw-bold text-uppercase mb-2">Deadline</h5>
                                        <p class="text-gray-800 fs-5 mb-0">{{ $project->projectDeadlineDate }}</p>
                                    </div>

                                    <!-- Created On Section -->
                                    <div class="col-md-4">
                                        <h5 class="text-success fw-bold text-uppercase mb-2">Created On</h5>
                                        <p class="text-gray-800 fs-5 mb-0">{{ $project->created_at->format('d M Y, h:i a') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 my-5">
                        <div class="card shadow-sm border-0 hover-elevate-up">
                            <div class="card-body">
                                <div class="row text-center gy-4">
                                    <!-- Project Cost Section -->
                                    <div class="col-md-4">
                                        <h5 class="text-primary fw-bold text-uppercase mb-2">Project Cost</h5>
                                        <p class="text-gray-800 fs-5 mb-0">
                                            {{ $project->currency->name }} {{ number_format($project->projectCost, 2) }}
                                        </p>
                                    </div>

                                    <!-- Project Budget Section -->
                                    <div class="col-md-4">
                                        <h5 class="text-success fw-bold text-uppercase mb-2">Project Budget</h5>
                                        <p class="text-gray-800 fs-5 mb-0">
                                            {{ $project->currency->name }} {{ number_format($project->projectBudget, 2) }}
                                        </p>
                                    </div>

                                    <!-- Budget Limit Section -->
                                    <div class="col-md-4">
                                        <h5 class="text-danger fw-bold text-uppercase mb-2">Budget Limit</h5>
                                        <p class="text-gray-800 fs-5 mb-0">
                                            {{ $project->currency->name }} {{ number_format($project->projectBudgetLimit, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 my-5">
                        <div class="card shadow-sm border-0 hover-elevate-up">
                            <div class="card-body">
                                <div class="mb-4">
                                    <h3 class="fs-2 text-primary fw-bold mb-4">Project Description</h3>
                                    <p class="fs-5 text-gray-700 fw-normal">
                                        {!! $project->projectDescription !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="tab-pane fade" id="members" role="tabpanel">
                <div class="card my-5">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="card-title text-gray-900 fw-bold fs-3">Members</h3>
                            @can('create members')
                                <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#add_project_users_modal">
                                    Add Members
                                </a>
                            @endcan
                        </div>
                        <table class="table table-bordered">
                            <table class="table">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800">
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th>System Role</th>
                                        <th class="w-auto"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->users as $user)
                                        <tr>
                                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                            <td>{{ $user->job_title }}</td>
                                            <td>{{ $user->departmentName->name }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>
                                                @can('delete members')
                                                <form
                                                    action="{{ route('projects.users.remove', ['project' => $project->id, 'user' => $user->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>

            
            <div class="tab-pane fade" id="meetings" role="tabpanel">
                <div class="card my-5">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="card-title text-gray-900 fw-bold fs-3">Meetings</h3>
                            @can('create members')
                                <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#add_project_meetings_modal">
                                    Schedule Meetings
                                </a>
                            @endcan
                        </div>
                        @include('projects.meetings')
                    </div>
                </div>
            </div>
            
            @include('projects.task')

            <div class="tab-pane fade" id="files" role="tabpanel">
                <div class="card my-5">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="card-title text-gray-900 fw-bold fs-3">Files</h3>
                            @can('create documents')
                                <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#add_project_files_modal">
                                    Add File
                                </a>
                            @endcan
                        </div>
                        <table class="table table-bordered">
                            <table class="table">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800">
                                        <th>Document Name</th>
                                        <th>Document Type</th>
                                        <th>Uploaded By</th>
                                        <th>Uploaded On</th>
                                        <th class="w-auto"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->projectFiles as $projectFile)
                                        <tr>
                                            <td>
                                                <a href="{{ asset('storage/'.$projectFile->document_path) }}" target="_blank" rel="noopener noreferrer" download>
                                                    {{ $projectFile->document_name }}
                                                </a>
                                            </td>
                                            <td>{{ $projectFile->documentType->name }}</td>
                                            <td>{{ $projectFile->createdBy->first_name }} {{ $projectFile->createdBy->last_name }}</td>
                                            <td>{{ $projectFile->created_at }}</td>
                                            {{-- <td>
                                                <a href="{{ asset('storage/'.$projectFile->document_path) }}" target="_blank" rel="noopener noreferrer">View</a>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="invoices" role="tabpanel">
                <div class="card my-5">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="card-title text-gray-900 fw-bold fs-3">Invoices</h3>
                            <p class="mb-4 text-muted">
                                Total Amount Paid: {{ $project->invoices->where('isPaid', 1)->sum('amount') ?? 0 }}
                            </p>
                            <p class="mb-4 text-muted">
                                Balance: {{ $project->projectCost - $project->invoices->where('isPaid', 1)->sum('amount') ?? 0 }}
                            </p>
                            @can('create invoice')
                                <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#add_project_invoices_modal">
                                    Add Invoice
                                </a>
                            @endcan
                            @include('projects.invoices.create-invoice')
                        </div>
                        @include('projects.invoices.invoice-component')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal bg-body fade" tabindex="-1" id="add_project_users_modal">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content shadow-none">
                <div class="modal-header">
                    <h1>Add Project Members</h3>
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span
                                    class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="col-12">
                        <form class="card" action="{{ route('projects.users.add', $project) }}" method="POST">
                            @csrf
                            <div class="card-body shadow-none">
                                <div class="row row-cards py-5">

                                    <div class="col-sm-6 col-md-12">
                                        <div class="mb-10">
                                            <label class="form-label">Project Members</label>
                                            <div class="d-flex">
                                                <select id="user" class="form-select form-select"
                                                    name="projectMemberIds[]" data-control="select2"
                                                    data-allow-clear="true" data-close-on-select="false"
                                                    data-placeholder="Select an option" data-allow-clear="true"
                                                    multiple="multiple">
                                                    <option></option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-sm btn-secondary mx-2"
                                                    data-bs-stacked-modal="#add_users_modal">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end" style="margin-top:-5rem;">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Members</button>
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
                                <input type="text" id="user_first_name" class="form-control form-control-solid"
                                    name="user_first_name" />
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Last Name</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" id="user_last_name" class="form-control form-control-solid"
                                    name="user_last_name" />
                            </div>
                        </div>
                        <div class="row g-9 mb-8">

                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">User Email</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" id="user_email" class="form-control form-control-solid"
                                    name="user_email" />
                            </div>
                        </div>
                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Role</span>
                                </label>
                                <!--end::Label-->
                                <select id="user_role" name="user_role" class="form-select form-select"
                                    data-control="select2" data-close-on-select="false"
                                    data-placeholder="Select an option" data-allow-clear="true">
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
                                <select id="user_department" name="user_department" class="form-select form-select"
                                    data-control="select2" data-close-on-select="false"
                                    data-placeholder="Select an option" data-allow-clear="true">
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


    <div class="modal bg-body fade" tabindex="-1" id="add_project_files_modal">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content shadow-none">
                <div class="modal-header">
                    <h1>Add Project File</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span
                                class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="col-12">
                        <form class="card" enctype="multipart/form-data" action="{{ route('files.add') }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="projectId" value="{{ $project->id }}">
                            <div class="card-body shadow-none">
                                <div class="row row-cards py-5">
                                    <div class="col-md-6">
                                        <div class="mb-10">
                                            <label class="form-label">Document Name</label>
                                            <input type="text" class="form-control" name="documentName" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
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
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-10">
                                            <label class="form-label">Document</label>
                                            <input type="file" class="form-control" name="document" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end" style="margin-top:-5rem;">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add File</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
