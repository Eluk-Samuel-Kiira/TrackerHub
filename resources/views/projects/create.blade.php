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
                                <label class="form-label">Project Category</label>
                                <div class="d-flex">
                                    <select id="project_category" class="form-select me-2" data-control="select2" data-placeholder="Select a category">
                                        <option></option>
                                        @foreach ($projectCategories as $projectCategory)
                                            <option value="{{ $projectCategory->id }}">{{ $projectCategory->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-toggle="modal" data-bs-target="#add_project_category_modal">Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <div class="mb-10">
                                <label class="form-label">Department</label>
                                <div class="d-flex">
                                    <select id="department" class="form-select me-2" data-control="select2" data-placeholder="Select a department">
                                        <option></option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-toggle="modal" data-bs-target="#add_department_modal">Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <div class="mb-10">
                                <label class="form-label">Client</label>
                                <div class="d-flex">
                                    <select id="client" class="form-select me-2" data-control="select2" data-placeholder="Select a client">
                                        <option></option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-toggle="modal" data-bs-target="#add_clients_modal">Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-12">
                            <div class="mb-10">
                                <label class="form-label">Project Members</label>
                                <div class="d-flex">
                                    <select id="user" class="form-select form-select" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                                        <option></option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-toggle="modal" data-bs-target="#add_users_modal">Add</button>
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
                                    <select id="currency" class="form-select form-select" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                                        <option></option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-toggle="modal" data-bs-target="#add_currency_modal">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end" style="margin-top:-5rem;">
                    <button type="submit" class="btn btn-primary">Create Project</button>
                </div>
            </form>
        </div>
    </div>


</div>

<!--begin::Modal - New Target-->
<div class="modal fade" id="add_currency_modal" tabindex="-1" aria-hidden="true">
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
                <form id="add_currency_modal_form">
                    @csrf
                    <!--begin::Heading-->
                    <div class="mb-13 text-center">
                        <!--begin::Title-->
                        <h1 class="mb-3">Add Currency</h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-8 fv-row">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">Currency Code</span>
                        </label>
                        <!--end::Label-->
                        <input type="text" id="currency_code" class="form-control form-control-solid" placeholder="Eg. UGX" name="currency_code" />
                    </div>
                    <!--end::Input group-->
                    <div class="text-center">
                        <button class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
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

<!--begin::Modal - New Target-->
<div class="modal fade" id="add_project_category_modal" tabindex="-1" aria-hidden="true">
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
                <form id="add_project_category_modal_form">
                    @csrf
                    <!--begin::Heading-->
                    <div class="mb-13 text-center">
                        <!--begin::Title-->
                        <h1 class="mb-3">Add Project Category</h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-8 fv-row">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">Project Category Name</span>
                        </label>
                        <!--end::Label-->
                        <input type="text" id="project_category_name" class="form-control form-control-solid" name="project_category_name" />
                    </div>
                    <!--end::Input group-->
                    <div class="text-center">
                        <button class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
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

<!--begin::Modal - New Target-->
<div class="modal fade" id="add_department_modal" tabindex="-1" aria-hidden="true">
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
                <form id="add_department_modal_form">
                    @csrf
                    <!--begin::Heading-->
                    <div class="mb-13 text-center">
                        <!--begin::Title-->
                        <h1 class="mb-3">Add Department</h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-8 fv-row">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">Department Name</span>
                        </label>
                        <!--end::Label-->
                        <input type="text" id="department_name" class="form-control form-control-solid" name="department_name" />
                    </div>
                    <!--end::Input group-->
                    <div class="text-center">
                        <button class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
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

<!--begin::Modal - New Target-->
<div class="modal fade" id="add_clients_modal" tabindex="-1" aria-hidden="true">
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
                <form id="add_clients_modal_form">
                    @csrf
                    <!--begin::Heading-->
                    <div class="mb-13 text-center">
                        <!--begin::Title-->
                        <h1 class="mb-3">Add Client</h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Input group-->
                    <div class="row g-9 mb-8">
                        <div class="d-flex flex-column mb-8 fv-row col-md-6">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Client Name</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" id="client_name" class="form-control form-control-solid" name="client_name" />
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row col-md-6">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Client Email</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" id="client_email" class="form-control form-control-solid" name="client_email" />
                        </div>
                    </div>
                    <div class="row g-9 mb-8">
                        <div class="d-flex flex-column mb-8 fv-row col-md-6">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Client Phone</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" id="client_phone" class="form-control form-control-solid" name="client_phone" />
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row col-md-6">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Client Address</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" id="client_address" class="form-control form-control-solid" name="client_address" />
                        </div>
                    </div>
                    <!--end::Input group-->
                    <div class="text-center">
                        <button class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
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
                                <option value=""></option>
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
                                <option value=""></option>
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
                            <span class="indicator-label">Submit</span>
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#kt_datepicker_1').flatpickr();
        $('#kt_datepicker_2').flatpickr();
        ClassicEditor
        .create(document.querySelector('#kt_docs_ckeditor_classic'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
    });
</script>

<script>
    document.getElementById('add_currency_modal_form').addEventListener('submit', function(event) {
    event.preventDefault();

    let currencyCode = document.getElementById('currency_code').value;
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("{{ route('currencies.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ currency_code: currencyCode })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Append new currency to the dropdown
            let option = new Option(data.currency.name, data.currency.id);
            document.getElementById('currency').appendChild(option);

            // Select the newly added currency
            document.getElementById('currency').value = data.currency.id;

            // Clear the input field
            document.getElementById('currency_code').value = '';

            // Close the modal
            const addCurrencyModalElement = document.getElementById('add_currency_modal');
            const addCurrencyModal = bootstrap.Modal.getInstance(addCurrencyModalElement) || new bootstrap.Modal(addCurrencyModalElement);
            addCurrencyModal.hide();
        } else {
            alert('Failed to add currency.');
        }
    })
    .catch(error => console.error('Error:', error));
});

</script>


<script>
    document.getElementById('add_project_category_modal_form').addEventListener('submit', function(event) {
    event.preventDefault();

    let projectCategoryName = document.getElementById('project_category_name').value;
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("{{ route('project_categories.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ project_category_name: projectCategoryName })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Append new currency to the dropdown
            let option = new Option(data.project_category.name, data.project_category.id);
            document.getElementById('project_category').appendChild(option);

            // Select the newly added currency
            document.getElementById('project_category').value = data.project_category.id;

            // Clear the input field
            document.getElementById('project_category_name').value = '';

            // Close the modal
            const addProjectCategoryModalElement = document.getElementById('add_project_category_modal');
            const addProjectCategoryModal = bootstrap.Modal.getInstance(addProjectCategoryModalElement) || new bootstrap.Modal(addProjectCategoryModalElement);
            addProjectCategoryModal.hide();
        } else {
            alert('Failed to add project category.');
        }
    })
    .catch(error => console.error('Error:', error));
});

</script>

<script>
    document.getElementById('add_department_modal_form').addEventListener('submit', function(event) {
    event.preventDefault();

    let departmentName = document.getElementById('department_name').value;
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch("{{ route('departments.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ department_name: departmentName })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Append new currency to the dropdown
            let option = new Option(data.department.name, data.department.id);
            document.getElementById('department').appendChild(option);

            // Select the newly added currency
            document.getElementById('department').value = data.department.id;

            // Clear the input field
            document.getElementById('department_name').value = '';

            // Close the modal
            const addDepartmentModalElement = document.getElementById('add_department_modal');
            const addDepartmentModal = bootstrap.Modal.getInstance(addDepartmentModalElement) || new bootstrap.Modal(addDepartmentModalElement);
            addDepartmentModal.hide();
        } else {
            alert('Failed to add department.');
        }
    })
    .catch(error => console.error('Error:', error));
});

</script>


<script>
    document.getElementById('add_clients_modal_form').addEventListener('submit', function(event) {
    event.preventDefault();

    let clientName = document.getElementById('client_name').value;
    let clientEmail = document.getElementById('client_email').value;
    let clientPhone = document.getElementById('client_phone').value;
    let clientAddress = document.getElementById('client_address').value;
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch("{{ route('clients.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ client_name: clientName, client_email: clientEmail, client_phone: clientPhone, client_address: clientAddress })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Append new currency to the dropdown
            let option = new Option(data.client.name, data.client.id);
            document.getElementById('client').appendChild(option);

            // Select the newly added currency
            document.getElementById('client').value = data.client.id;

            // Clear the input field
            document.getElementById('client_name').value = '';
            document.getElementById('client_email').value = '';
            document.getElementById('client_phone').value = '';
            document.getElementById('client_address').value = '';

            // Close the modal
            const addClientsModalElement = document.getElementById('add_clients_modal');
            const addClientsModal = bootstrap.Modal.getInstance(addClientsModalElement) || new bootstrap.Modal(addClientsModalElement);
            addClientsModal.hide();
        } else {
            alert('Failed to add client.');
        }
    })
    .catch(error => console.error('Error:', error));
});

</script>

<script>
    document.getElementById('add_users_modal_form').addEventListener('submit', function(event) {
    event.preventDefault();

    let userFirstName = document.getElementById('user_first_name').value;
    let userLastName = document.getElementById('user_last_name').value;
    let userEmail = document.getElementById('user_email').value;
    let userRole = document.getElementById('user_role').value;
    let userDepartment = document.getElementById('user_department').value;

    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("/users", {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
    },
    body: JSON.stringify({ user_first_name: userFirstName, user_last_name: userLastName, user_email: userEmail, user_role: userRole, user_department: userDepartment })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Append new currency to the dropdown
            let option = new Option(data.user.name, data.user.id);
            document.getElementById('user').appendChild(option);

            // Select the newly added currency
            document.getElementById('user').value = data.user.id;

            // Clear the input field
            document.getElementById('user_first_name').value = '';
            document.getElementById('user_last_name').value = '';
            document.getElementById('user_email').value = '';
            document.getElementById('user_role').value = '';
            document.getElementById('user_department').value = '';

            // Close the modal
            const addUsersModalElement = document.getElementById('add_users_modal');
            const addUsersModal = bootstrap.Modal.getInstance(addUsersModalElement) || new bootstrap.Modal(addUsersModalElement);
            addUsersModal.hide();
        } else {
            alert('Failed to add user.');
        }
    })
    .catch(error => console.error('Error:', error));
});

</script>



@endpush
