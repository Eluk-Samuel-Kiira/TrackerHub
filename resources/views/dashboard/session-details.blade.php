
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