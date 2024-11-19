<x-app-layout>
    @section('title', __('Basic Settings'))
    @section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">{{__('Basic Settings')}}</h1>
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
                    <li class="breadcrumb-item text-muted">{{__('Basic Settings')}}</li>
                </ul>
            </div>
        </div>
    </div>

    
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card mb-5 mb-xl-10">
                <div class="card-body pt-9 pb-0">
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold" id="account_tabs">
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 active" id="logo_favicon-tab" data-bs-toggle="tab" href="#logo-favicon">Logo & Favicon</a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" id="app-informaton-tab" data-bs-toggle="tab" href="#app-informaton"> Application Info</a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" id="smtp-informaton-tab" data-bs-toggle="tab" href="#smtp-information">SMTP Info</a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" id="deactivate-tab" data-bs-toggle="tab" href="#meta-information">Meta Info</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content mt-5" id="account_tabs_content">
                <!-- logo-favicon Information Tab -->
                <div class="tab-pane fade show active" id="logo-favicon">
                    <div class="card mb-5 mb-xl-10" role="button" data-bs-toggle="collapse">
                        <div class="card-body" class="collapse show">
                            @include('settings.partials.logo-favicon') 
                        </div>
                    </div>
                </div>

                
                <!-- Update App Info Tab -->
                <div class="tab-pane fade" id="app-informaton">
                    <div class="card">
                        <div class="card-body">
                            @include('settings.partials.app-information')
                        </div>
                    </div>
                </div>

                <!-- Account smtp Tab -->
                <div class="tab-pane fade" id="smtp-information">
                    <div class="card">
                        <div class="card-body">
                            @include('settings.partials.smtp-settings')
                        </div>
                    </div>
                </div>

                <!-- Account smtp Tab -->
                <div class="tab-pane fade" id="meta-information">
                    <div class="card">
                        <div class="card-body">
                            @include('settings.partials.meta-settings')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    @endsection
</x-app-layout>
