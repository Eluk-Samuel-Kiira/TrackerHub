<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9" id="reloadPermissionComponent">
    @foreach ($users as $user)
        <div class="col-md-4 permission-card" data-perm="{{ $user->name }}">
            <div class="card card-flush h-md-100">
                <div class="card-header">
                    <div class="card-title">
                    <h2>{{ ucwords(str_replace('_', ' ', $user->first_name . ' ' . $user->last_name)) }}</h2>
                        </div>
                </div>
                <div class="card-body pt-1">
                    <div class="fw-bold text-gray-600 mb-5">Direct Permissions Count: {{ $user->getDirectPermissions()->count() }}</div>
                    <div class="d-flex flex-column text-gray-600">
                    @foreach ($user->getDirectPermissions()->take(5) as $permission)
                        <div class="d-flex align-items-center py-2">
                            <span class="bullet bg-primary me-3"></span>
                            {{ $permission->name }}
                        </div>
                    @endforeach

                    @if ($user->getDirectPermissions()->count() > 5)
                        <div class="d-flex align-items-center py-2">
                            <span class="bullet bg-primary me-3"></span>
                            <a href="javascript:void(0);" onclick="showAllPermissions({{ $user->id }})">
                                <em>and {{ $user->getDirectPermissions()->count() - 5 }} more...</em>
                            </a>
                        </div>
                    @endif
                    </div>
                </div>
                <div class="card-footer flex-wrap pt-0">
                    @can('update permission')
                        <button type="button" class="btn btn-light btn-active-light-primary my-1" data-bs-toggle="modal" data-bs-target="#direct_permissions{{ $user->id }}"  onclick="initializeModalOnClick({{ $user->id }})">
                            {{__('Grant/Revoke')}}
                        </button>
                    @endcan
                    @include('users.permissions.direct-permissions')
                </div>
            </div>
        </div>

        <!-- Modal for displaying all permissions -->
        <div class="modal fade" id="permissionsModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">All Permissions for {{ ucwords(str_replace('_', ' ', $user->first_name . ' ' . $user->last_name)) }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- First Column: First Group of Permissions -->
                        <div class="row">
                            <div class="col-4">
                                @foreach ($user->getDirectPermissions()->slice(0, ceil($user->getDirectPermissions()->count() / 3)) as $permission)
                                    <div class="d-flex align-items-center py-2">
                                        <span class="bullet bg-primary me-3"></span>
                                        {{ $permission->name }}
                                    </div>
                                @endforeach
                            </div>

                            <!-- Second Column: Second Group of Permissions -->
                            <div class="col-4">
                                @foreach ($user->getDirectPermissions()->slice(ceil($user->getDirectPermissions()->count() / 3), ceil($user->getDirectPermissions()->count() / 3)) as $permission)
                                    <div class="d-flex align-items-center py-2">
                                        <span class="bullet bg-primary me-3"></span>
                                        {{ $permission->name }}
                                    </div>
                                @endforeach
                            </div>

                            <!-- Third Column: Last Group of Permissions -->
                            <div class="col-4">
                                @foreach ($user->getDirectPermissions()->slice(ceil($user->getDirectPermissions()->count() * 2 / 3)) as $permission)
                                    <div class="d-flex align-items-center py-2">
                                        <span class="bullet bg-primary me-3"></span>
                                        {{ $permission->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
</div>

<script>
    function initializeComponentScripts() {
        setupCardSearch('permissionSearchBar', '.permission-card', 'data-perm', '.card-title h2');
    }


    function showAllPermissions(userId) {
    var modal = new bootstrap.Modal(document.getElementById('permissionsModal' + userId));
    modal.show();
}
</script>
