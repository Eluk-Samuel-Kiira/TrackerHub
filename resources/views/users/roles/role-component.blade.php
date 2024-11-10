
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
    @foreach ($roles as $role)
        <div class="col-md-4 role-card" data-role="{{ $role->name }}">
            <div class="card card-flush h-md-100">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ ucwords(str_replace('_', ' ', $role->name)) }}</h2>
                    </div>
                </div>
                <div class="card-body pt-1">
                    <div class="fw-bold text-gray-600 mb-5">Total users with this role: {{ $role->user_count }}</div>
                    <div class="d-flex flex-column text-gray-600">
                        @foreach ($role->permissions->take(7) as $permission)
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>
                                {{ $permission->name }}
                            </div>
                        @endforeach
                        @if ($role->permissions->count() > 7)
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>
                                <a href="javascript:void(0);" onclick="showAllPermissions({{ $role->id }})">
                                    <em>and {{ $role->permissions->count() - 7 }} more...</em>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer flex-wrap pt-0">
                    <button type="button" class="btn btn-light btn-active-light-primary my-1" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Edit Role</button>
                </div>
            </div>
        </div>

        <!-- Modal for displaying all permissions -->
        <div class="modal fade" id="permissionsModal{{ $role->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">All Permissions for {{ ucwords(str_replace('_', ' ', $role->name)) }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- First Section: Permissions Group 1 -->
                        <div class="row">
                            <div class="col-4">
                                @foreach ($role->permissions->slice(0, ceil($role->permissions->count() / 3)) as $permission)
                                    <div class="d-flex align-items-center py-2">
                                        <span class="bullet bg-primary me-3"></span>
                                        {{ $permission->name }}
                                    </div>
                                @endforeach
                            </div>

                            <!-- Second Section: Permissions Group 2 -->
                            <div class="col-4">
                                @foreach ($role->permissions->slice(ceil($role->permissions->count() / 3), ceil($role->permissions->count() / 3)) as $permission)
                                    <div class="d-flex align-items-center py-2">
                                        <span class="bullet bg-primary me-3"></span>
                                        {{ $permission->name }}
                                    </div>
                                @endforeach
                            </div>

                            <!-- Third Section: Permissions Group 3 -->
                            <div class="col-4">
                                @foreach ($role->permissions->slice(ceil($role->permissions->count() * 2 / 3)) as $permission)
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
    function showAllPermissions(roleId) {
        const modalId = `#permissionsModal${roleId}`;
        const modal = new bootstrap.Modal(document.querySelector(modalId));
        modal.show();
    }


    document.addEventListener('DOMContentLoaded', function() {
        const roleFilterSelect = document.querySelector('[data-kt-user-table-filter="role"]');
        const roleCards = document.querySelectorAll('.role-card');

        // Filter roles based on the selected option
        roleFilterSelect.addEventListener('change', function() {
            const selectedRole = roleFilterSelect.value;

            roleCards.forEach(card => {
                const roleName = card.getAttribute('data-role');

                // Show card if it matches the selected role or if no role is selected
                if (selectedRole === "" || roleName === selectedRole) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

</script>


