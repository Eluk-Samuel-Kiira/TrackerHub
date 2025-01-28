
@foreach ($recentActivities as $index => $activity)
    <!-- Modal for Each Session -->
    <div class="modal fade" id="sessionModal{{ $index }}" tabindex="-1" aria-labelledby="sessionModalLabel{{ $index }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sessionModalLabel{{ $index }}">Session Details - {{ $activity['user'] }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <strong>IP Address:</strong> {{ $activity['ip_address'] }}<br>
                        <strong>User Agent:</strong> {{ $activity['user_agent'] }}<br>
                        <strong>Last Active:</strong> {{ $activity['time'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach


                                    <!-- @foreach($dashboardData['users'] as $user)
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="{{ $user->first_name .' '. $user->last_name }}">
                                            @if(!empty($user->profile_image) && file_exists(public_path('storage/' . $user->profile_image)))
                                                <img alt="P" src="{{ asset('storage/' . $user->profile_image) }}" />
                                            @else
                                                <span class="symbol-label bg-secondary text-inverse-secondary fw-bold">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if($dashboardData['users']->count() > 6)
                                        <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
                                            <span class="symbol-label bg-dark text-gray-300 fs-8 fw-bold">+{{ $dashboardData['users']->count() - 6 }}</span>
                                        </a>
                                    @endif
                                    @include('dashboard.user-modal') -->


                                    