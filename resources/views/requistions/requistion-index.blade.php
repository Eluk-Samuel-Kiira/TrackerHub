<x-app-layout>
    @section('title', __('Requistion Index'))
    @section('content')
    
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">{{__('Requistions Table')}}</h1>
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
                    <li class="breadcrumb-item text-muted">{{__('Requistions')}}</li>
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
                        <input type="text" id="searchInput" class="form-control" placeholder="Search requistions...">
                    </div>
                </div>

                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_requistion">
                <i class="ki-duotone ki-plus fs-2"></i>{{__('Add Requistion')}}</button>
                @include('requistions.partials.create-requistion')    
            </div>
        </div>
    </div>
     
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div id="status"></div>
                <div class="card">
                    @include('requistions.partials.requistion-component')
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateStatus(uniqueId, selectedStatus) {
            // console.log(" ID:", uniqueId, "Selected status:", selectedStatus);
            const updateRoute = '/requisition-status/' + uniqueId;
            LiveBlade.loopUpdateStatus(updateRoute, selectedStatus);
        }

        function updateResponse(uniqueId, selectedStatus) {
            const updateRoute = '/requisition-response/' + uniqueId;

            // SweetAlert confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: `If a requisition is set to ${selectedStatus}, it is irreversible. Make sure you have agreed with other stakeholders before proceeding.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with submission
                    LiveBlade.loopUpdateStatus(updateRoute, selectedStatus);
                } else {
                    // Optional: Handle cancellation
                    console.log('Action cancelled by user.');
                }
            });
        }

    </script>   
        
    @endsection
</x-app-layout>