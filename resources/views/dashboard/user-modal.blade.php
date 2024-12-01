

<!-- Modal -->
<div class="modal fade" id="kt_modal_view_users" tabindex="-1" aria-labelledby="kt_modal_view_users_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kt_modal_view_users_label">All Users</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach($dashboardData['users'] as $index => $user)
                        @if($index >= 6)  <!-- Only show users beyond the first 6 -->
                            <div class="col-md-4 mb-3">
                                <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="{{ $user->name }}">
                                    @if(!empty($user->image) && file_exists(public_path('assets/media/avatars/' . $user->image)))
                                        <img alt="Pic" src="{{ asset('assets/media/avatars/' . $user->image) }}" />
                                    @else
                                        <span class="symbol-label bg-secondary text-inverse-secondary fw-bold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-2 text-center">{{ $user->name }}</div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
