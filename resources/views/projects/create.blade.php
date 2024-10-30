@extends('layouts.app')
@section('title', 'New Project')

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
            <a href="{{ route('projects.index') }}" class="btn btn-sm fw-bold btn-primary">Back</a>
        </div>

    </div>

</div>
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="col-12">
            <form class="card" action="./users.html">
                <div class="card-body">
                    <h1>Project Information</h3>
                    <div class="row row-cards py-5">
                        <div class="col-sm-6 col-md-2">
                            <div class="mb-10">
                                <label class="form-label">Code</label>
                                <input type="text" class="form-control" placeholder="Project Code">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="mb-10">
                                <label class="form-label">Project Name</label>
                                <input type="text" class="form-control" placeholder="Project Name">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="mb-10">
                                <label for="" class="form-label">Start Date</label>
                                <input class="form-control flatpickr-input" placeholder="Pick date" id="kt_datepicker_1" type="text" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="mb-10">
                                <label for="" class="form-label">Deadline</label>
                                <input class="form-control flatpickr-input" placeholder="Pick date" id="kt_datepicker_2" type="text" readonly="readonly">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-10">
                                <label class="form-label">Description</label>
                                <textarea id="kt_docs_ckeditor_classic">
                                </textarea>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="mb-10">
                                <label class="form-label">Category</label>
                                <div class="d-flex">
                                    <select class="form-select me-2" data-control="select2" data-placeholder="Select a category">
                                        <option></option>
                                        @foreach ($projectCategories as $projectCategory)
                                            <option value="{{ $projectCategory->id }}">{{ $projectCategory->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-sm btn-secondary mx-2">Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <div class="mb-10">
                                <label class="form-label">Department</label>
                                <div class="d-flex">
                                    <select class="form-select me-2" data-control="select2" data-placeholder="Select a department">
                                        <option></option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-sm btn-secondary mx-2">Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <div class="mb-10">
                                <label class="form-label">Client</label>
                                <div class="d-flex">
                                    <select class="form-select me-2" data-control="select2" data-placeholder="Select a client">
                                        <option></option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-sm btn-secondary mx-2">Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-12">
                            <div class="mb-10">
                                <label class="form-label">Project Members</label>
                                <div class="d-flex">
                                    <select class="form-select form-select" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                                        <option></option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-sm btn-secondary mx-2">Add</button>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-6 col-md-4">
                            <div class="mb-10">
                                <label class="form-label">Budget</label>
                                <input type="text" class="form-control" placeholder="Budget">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="mb-10">
                                <label class="form-label">Budget Limit</label>
                                <input type="text" class="form-control" placeholder="Budget Limit">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="mb-10">
                                <label class="form-label">Currency</label>
                                <div class="d-flex">
                                    <select class="form-select form-select" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                                        <option></option>
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                    </select>
                                    <button type="button" class="btn btn-sm btn-secondary mx-2">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end" style="margin-top:-5rem;">
                    <button type="submit" class="btn btn-primary">create User</button>
                </div>
            </form>
        </div>
    </div>


</div>

@endsection
