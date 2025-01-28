<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<title>@yield('title')</title>
		<meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="The most advanced Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
        <meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="Metronic - The World's #1 Selling Bootstrap Admin Template by KeenThemes" />
        <meta property="og:url" content="https://keenthemes.com/metronic" />
        <meta property="og:site_name" content="Metronic by Keenthemes" />
        <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
        <link rel="shortcut icon" href="{{ getFaviconImage() }}" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
        <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />


        <script>
            if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
        </script>
		@livewireStyles
        {{-- laravel bladeLive.js library --}}
        @include('layouts.liveblade-imports')
    </head>
	<body id="kt_app_body" data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">

        <div class="page-loader flex-column">
            <span class="spinner-border text-primary" role="status"></span>
            <span class="text-muted fs-6 fw-semibold mt-5">Loading...</span>
        </div>
	@php
		use Illuminate\Support\Str;
	@endphp
	<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>


		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
        <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
            <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				@include('layouts.header')
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                    <div id="kt_app_sidebar" class="app-sidebar flex-column"
                        style="background-color: #0F172A;"
                        data-kt-drawer="true"
                        data-kt-drawer-name="app-sidebar"
                        data-kt-drawer-activate="{default: true, lg: false}"
                        data-kt-drawer-overlay="true"
                        data-kt-drawer-width="225px"
                        data-kt-drawer-direction="start"
                        data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
                        {{--
                        <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
                            <a href="{{ Route::currentRouteName() }}" class="d-block mb-4"> 
                                <img 
                                    src="{{ getLogoImage() }}" 
                                    class="img-fluid" 
                                    style="height: 60px; display: block; margin: 0 auto;" 
                                    alt="Logo" 
                                />
                            </a>
                            
                            <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
                                <i class="ki-duotone ki-black-left-line fs-3 rotate-180"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                        </div>
                        --}}

                        <!--begin::Logo-->
						<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
							<!--begin::Logo image-->
                            <h1 class="flex items-center">
                                <a href="{{ Route::currentRouteName() }}" class="flex items-center text-white text-2xl font-bold">
                                    <span class="app-sidebar-logo-default mr-2">
                                        {{ __('Bamzee PMS') }}
                                    </span>
                                    <span class="app-sidebar-logo-minimize hidden">
                                        {{ __('B') }}
                                    </span>
                                </a>
                            </h1>
							<!--end::Logo image-->
							<!--begin::Sidebar toggle-->
							<div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
								<i class="ki-duotone ki-black-left-line fs-3 rotate-180">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</div>
							<!--end::Sidebar toggle-->
						</div>
						<!--end::Logo-->
                        @include('layouts.navigation')
                    </div>
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<div class="d-flex flex-column flex-column-fluid">
							@yield('content')
						</div>
					</div>
				</div>
			</div>
		</div>

         // <!--begin::Modal - New Target-->
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
                                <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
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
        // <!--end::Modal - New Target-->

        // <!--begin::Modal - New Target-->
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
                                <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
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
        // <!--end::Modal - New Target-->

        // <!--begin::Modal - New Target-->
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
                                <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
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
        // <!--end::Modal - New Target-->

        // <!--begin::Modal - New Target-->
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
                                <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
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
        // <!--end::Modal - New Target-->

		<script>var hostUrl = "{{ asset('assets/') }}";</script>
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>

		<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>

		<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
		<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
		<script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
		<script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
		<script src="{{ asset('assets/js/custom/utilities/modals/new-target.js') }}"></script>
		<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>

		<script src="{{ asset('assets/js/custom/apps/user-management/users/list/table.js') }}"></script>
		<script src="{{ asset('assets/js/custom/apps/user-management/users/list/export-users.js') }}"></script>
		<script src="{{ asset('assets/js/custom/apps/user-management/users/list/add.js') }}"></script>

        // <!--CKEditor Build Bundles:: Only include the relevant bundles accordingly-->
        <script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#kt_datepicker_1').flatpickr();
                $('#kt_datepicker_2').flatpickr();
                $('#taskDeadlindDate').flatpickr();
                $('#kt_datepicker_1edit').flatpickr();
                $('#kt_datepicker_2edit').flatpickr();
                ClassicEditor
                .create(document.querySelector('#kt_docs_ckeditor_classic'))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });

                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toastr-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

            });
        </script>

        <script>
            var elements = Array.prototype.slice.call(document.querySelectorAll("[data-bs-stacked-modal]"));

            if (elements && elements.length > 0) {
                elements.forEach((element) => {
                    if (element.getAttribute("data-kt-initialized") === "1") {
                        return;
                    }

                    element.setAttribute("data-kt-initialized", "1");

                    element.addEventListener("click", function(e) {
                        e.preventDefault();

                        const modalEl = document.querySelector(this.getAttribute("data-bs-stacked-modal"));

                        if (modalEl) {
                            const modal = new bootstrap.Modal(modalEl);
                            modal.show();
                        }
                    });
                });
            }
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

                    // document.getElementById('currency1').appendChild(option);

                    // // Select the newly added currency
                    // document.getElementById('currency1').value = data.currency.id;

                    // Clear the input field
                    document.getElementById('currency_code').value = '';

                    // Close the modal
                    const addCurrencyModalElement = document.getElementById('add_currency_modal');
                    const addCurrencyModal = bootstrap.Modal.getInstance(addCurrencyModalElement) || new bootstrap.Modal(addCurrencyModalElement);
                    addCurrencyModal.hide();
                    toastr.success("Currency has been added!");
                } else {
                    toastr.error("Error adding currency!");
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


                    // document.getElementById('project_category1').appendChild(option);

                    // // Select the newly added currency
                    // document.getElementById('project_category1').value = data.project_category.id;

                    // Clear the input field
                    document.getElementById('project_category_name').value = '';

                    // Close the modal
                    const addProjectCategoryModalElement = document.getElementById('add_project_category_modal');
                    const addProjectCategoryModal = bootstrap.Modal.getInstance(addProjectCategoryModalElement) || new bootstrap.Modal(addProjectCategoryModalElement);
                    addProjectCategoryModal.hide();
                    toastr.success("Project category has been added!");
                } else {
                    toastr.error("Error adding Project category!");
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

                    // document.getElementById('department1').appendChild(option);

                    // // Select the newly added currency
                    // document.getElementById('department1').value = data.department.id;

                    // Clear the input field
                    document.getElementById('department_name').value = '';

                    // Close the modal
                    const addDepartmentModalElement = document.getElementById('add_department_modal');
                    const addDepartmentModal = bootstrap.Modal.getInstance(addDepartmentModalElement) || new bootstrap.Modal(addDepartmentModalElement);
                    addDepartmentModal.hide();
                    toastr.success("Department has been added!");
                } else {
                    toastr.error("Error adding department!");
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

                    // document.getElementById('client1').appendChild(option);

                    // // Select the newly added currency
                    // document.getElementById('client1').value = data.client.id;

                    // Clear the input field
                    document.getElementById('client_name').value = '';
                    document.getElementById('client_email').value = '';
                    document.getElementById('client_phone').value = '';
                    document.getElementById('client_address').value = '';

                    // Close the modal
                    const addClientsModalElement = document.getElementById('add_clients_modal');
                    const addClientsModal = bootstrap.Modal.getInstance(addClientsModalElement) || new bootstrap.Modal(addClientsModalElement);
                    addClientsModal.hide();
                    toastr.success("Client has been added!");
                } else {
                    toastr.error("Error adding Client!");
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
                    // Append new user to the dropdown
                    let option = new Option(data.user.name, data.user.id, true, true); // Setting the last two params to true marks it as selected
                    document.getElementById('user').appendChild(option);

                    // Get currently selected options and add the new user ID
                    let selectedOptions = $('#user').val() || []; // Retrieve current selection or an empty array if none
                    selectedOptions.push(data.user.id); // Add the new user to the selections

                    // document.getElementById('user1').appendChild(option);

                    // // Get currently selected options and add the new user ID
                    // let selectedOptions1 = $('#user1').val() || []; // Retrieve current selection or an empty array if none
                    // selectedOptions1.push(data.user.id); // Add the new user to the selections

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
                    toastr.success("User has been added!");
                } else {
                    toastr.error("Error adding User!");
                }
            })
            .catch(error => console.error('Error:', error));
        });

        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                @if(session('toast'))
                    var toastType = "{{ session('toast.type') }}";
                    var toastMessage = "{{ session('toast.message') }}";

                    // Trigger Metronic toast
                    toastr[toastType](toastMessage); // success, info, warning, error
                @endif
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const navLinks = document.querySelectorAll('.nav-link');

                // Add click event listener to each tab link
                navLinks.forEach(link => {
                    link.addEventListener('click', function () {
                        // Update the URL fragment when a tab is clicked
                        const target = this.getAttribute('href');
                        if (history.pushState) {
                            history.pushState(null, null, target);
                        } else {
                            window.location.hash = target;
                        }
                    });
                });

                // Activate the correct tab on page load based on the URL fragment
                const hash = window.location.hash;
                if (hash) {
                    const activeTab = document.querySelector(`.nav-link[href="${hash}"]`);
                    if (activeTab) {
                        const tab = new bootstrap.Tab(activeTab);
                        tab.show();
                    }
                }
            });
        </script>

        @stack('scripts')
		@livewireScripts
	</body>
</html>

