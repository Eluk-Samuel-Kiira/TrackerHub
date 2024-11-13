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
                    <table class="table table-bordered">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800">
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                                <td>$320,800</td>
                            </tr>
                            <tr>
                                <td>Garrett Winters</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>63</td>
                                <td>2011/07/25</td>
                                <td>$170,750</td>
                            </tr>
                            <tr>
                                <td>Ashton Cox</td>
                                <td>Junior Technical Author</td>
                                <td>San Francisco</td>
                                <td>66</td>
                                <td>2009/01/12</td>
                                <td>$86,000</td>
                            </tr>
                            <tr>
                                <td>Cedric Kelly</td>
                                <td>Senior Javascript Developer</td>
                                <td>Edinburgh</td>
                                <td>22</td>
                                <td>2012/03/29</td>
                                <td>$433,060</td>
                            </tr>
                            <tr>
                                <td>Airi Satou</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>33</td>
                                <td>2008/11/28</td>
                                <td>$162,700</td>
                            </tr>
                            <tr>
                                <td>Brielle Williamson</td>
                                <td>Integration Specialist</td>
                                <td>New York</td>
                                <td>61</td>
                                <td>2012/12/02</td>
                                <td>$372,000</td>
                            </tr>
                            <tr>
                                <td>Herrod Chandler</td>
                                <td>Sales Assistant</td>
                                <td>San Francisco</td>
                                <td>59</td>
                                <td>2012/08/06</td>
                                <td>$137,500</td>
                            </tr>
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
                                                <select id="user" class="form-select form-select" name="projectMemberIds" data-control="select2" data-allow-clear="true" data-dropdown-parent="#add_project_modal" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                                                    <option></option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-stacked-modal="#add_users_modal">Add</button>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-6 col-md-4">
                                        <div class="mb-10">
                                            <label class="form-label">Budget</label>
                                            <input type="text" class="form-control" name="projectBudget" placeholder="Budget">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="mb-10">
                                            <label class="form-label">Budget Limit</label>
                                            <input type="text" class="form-control" name="projectBudgetLimit" placeholder="Budget Limit">
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

@endsection
