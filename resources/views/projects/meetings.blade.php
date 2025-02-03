<table class="table table-bordered">
    <thead>
        <tr class="fw-bold fs-6 text-gray-800">
            <th>Next Meeting</th>
            <th>Meeting Type</th>
            <th>Meeting Location</th>
            <th>Meeting Status</th>
            <th>Scheduled On</th>
            <th>Days Left</th>
            <th class="w-auto">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($project->meetings as $meeting)
            <tr>
                <!-- Format the meeting date -->
                <td>{{ \Carbon\Carbon::parse($meeting->meetingDate)->format('F j, Y g:i A') }}</td>
                <td>{{ $meeting->meetingType }}</td>
                <td>{{ $meeting->meetingLocation ?? 'Online' }}</td>
                
                <!-- Display meeting status -->
                <td>
                    @if ($meeting->status == 1)
                        <span class="badge bg-success">Done</span>
                    @else
                        <span class="badge bg-warning">Not Yet</span>
                    @endif
                </td>

                <!-- Format the creation date -->
                <td>{{ \Carbon\Carbon::parse($meeting->created_at)->format('F j, Y g:i A') }}</td>
                
                <!-- Calculate days left -->
                <td>
                    @php
                        $now = \Carbon\Carbon::now();
                        $meetingDate = \Carbon\Carbon::parse($meeting->meetingDate);
                        $daysLeft = $now->diffInDays($meetingDate, false); // false ensures that we get negative values for past dates

                        // Round to 2 decimal places
                        $daysLeft = round($daysLeft, 2);

                        // If days are between -0.9 and 0.9, consider it 'Today'
                        if ($daysLeft > 0.9) {
                            echo $daysLeft . ' days left'; // If meeting is in the future
                        } elseif ($daysLeft >= -0.9 && $daysLeft <= 0.9) {
                            echo 'Today (Within 24hrs now)'; // If meeting is today (in between 0.1 to 0.9 days)
                        } else {
                            echo abs($daysLeft) . ' days overdue'; // If meeting is in the past
                        }
                    @endphp

                </td>

                <!-- Action Buttons -->
                <td class="d-flex align-items-center gap-2 flex-column flex-sm-row">
                <div class="d-flex justify-content-start align-items-center">

                        @can('edit members')
                            <button 
                            class="btn btn-sm btn-light btn-active-color-primary d-flex align-items-center px-3 py-2" 
                            data-bs-toggle="modal" 
                                data-bs-target="#editMeeting{{$meeting->id}}">
                                <i class="bi bi-pencil-square me-1 fs-5"></i><span>{{ __('Edit') }}</span>
                            </button>
                        @endcan

                                                
                        <div class="modal fade" id="editMeeting{{$meeting->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered mw-850px">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3>Writing Meeting Summary Here</h3>
                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                                        </div>
                                    </div>

                                    <div class="modal-body">
                                        <div class="col-12">
                                            <form class="card"  id="kt_modal_edit_meeting_form{{ $meeting->id }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                                                <div class="card-body shadow-none">
                                                    <div class="row row-cards py-5">
                                                        <div class="col-sm-6 col-md-12">
                                                            <div class="mb-10">
                                                                <label class="form-label" for="meetingDate">Meeting Summary</label><br>
                                                                <textarea class="form-control" name="meetingDescription">{!! $meeting->description !!}</textarea>                                                              </div>
                                                            <div id="meetingDescription{{ $meeting->id }}"></div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card-footer text-end" style="margin-top:-5rem;">
                                                    @if ($meeting->status == 0)
                                                        <button type="reset" class="btn btn-light me-3" id="discardMeetingButton{{$meeting->id}}" data-bs-dismiss="modal">Discard</button>
                                                        
                                                        <button onclick="editInstanceLoopMeeting({{$meeting->id }})" id="editMeetingButton{{ $meeting->id }}" type="button" class="btn btn-primary" >
                                                            <span class="indicator-label">Update</span>
                                                            <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        @can('delete members')
                            <form
                                action="{{ route('meeting.destroy', $meeting->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"  class="btn btn-sm btn-light btn-active-color-danger d-flex align-items-center px-3 py-2" 
                                >
                                <i class="bi bi-trash me-1 fs-5"></i> <span>{{ __('Delete') }}</span>
                                </button>
                            </form>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


<div class="modal fade" id="add_project_meetings_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Schedule Next Project Meeting for {{ $project->projectName }}</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>

            <div class="modal-body">
                <div class="col-12">
                    <form class="card"  id="kt_modal_add_meeting_form">
                        @csrf
                        <input type="hidden" name="projectId" value="{{ $project->id }}">
                        
                        <div class="col-sm-6 col-md-12">
                            <div class="mb-10">
                                <label class="form-label">Meeting Type</label><br>
                                <div>
                                    <input type="radio" id="onlineMeeting" name="meetingType" value="online" onclick="toggleMeetingFields()" checked>
                                    <label for="onlineMeeting">Online</label>
                                </div>
                                <div>
                                    <input type="radio" id="physicalMeeting" name="meetingType" value="physical" onclick="toggleMeetingFields()">
                                    <label for="physicalMeeting">Physical</label>
                                </div>
                            </div>

                            <div class="mb-10">
                                <label class="form-label" for="meetingDate">Schedule Meeting</label><br>
                                <input id="meetingDate" name="meetingDate" class="form-control" type="datetime-local" />
                            </div>

                            <!-- Meeting Location (Only for Physical) -->
                            <div class="mb-10" id="locationField" style="display: none;">
                                <label class="form-label" for="meetingLocation">Meeting Location</label><br>
                                <input id="meetingLocation" name="meetingLocation" class="form-control" type="text" placeholder="Enter location" />
                            </div>

                            <!-- Meeting Link (Only for Online) -->
                            <div class="mb-10" id="meetingLinkField">
                                <label class="form-label" for="meetingLink">Meeting Link</label><br>
                                <input id="meetingLink" name="meetingLink" class="form-control" type="url" placeholder="Enter meeting link" />
                            </div>
                        </div>

                        <script>
                            function toggleMeetingFields() {
                                const isPhysical = document.getElementById('physicalMeeting').checked;
                                document.getElementById('locationField').style.display = isPhysical ? 'block' : 'none';
                                document.getElementById('meetingLinkField').style.display = isPhysical ? 'none' : 'block';
                            }

                            // Ensure correct initial state
                            document.addEventListener("DOMContentLoaded", toggleMeetingFields);
                        </script>

                        <div class="card-footer text-end" style="margin-top:-2rem;">
                            <button type="reset" class="btn btn-light me-3" id="discardMeetingButton" data-bs-dismiss="modal">Discard</button>
                            <button id="submitMeetingButton" type="submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait... 
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Initialize Flatpickr on the input field
    flatpickr("#meetingDate", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
</script>



<script>
    
    function editInstanceLoopMeeting(uniqueId) {
        const submitButton = document.getElementById('editMeetingButton' + uniqueId);
        LiveBlade.toggleButtonLoading(submitButton, true);

        // Select the form and create FormData from it
        var form = document.getElementById('kt_modal_edit_meeting_form' + uniqueId);
        var formData = new FormData(form);

        var data = Object.fromEntries(formData.entries());

        // Set up the URL dynamically
        var updateUrl = '{{ route('meeting.update', ['meeting' => ':id']) }}'.replace(':id', uniqueId);

        // Submit form data asynchronously
        LiveBlade.editLoopForms(data, updateUrl)
        .then(noErrorStatus => {
            if (noErrorStatus) {
                var closeButton = document.getElementById('discardMeetingButton' + uniqueId);
                if (closeButton) {
                    closeButton.click();
                }
                
                const currentUrl = "{{ url()->current() }}"; 
                window.location.href = currentUrl;
            }
        })
        .catch(error => {
            console.error('An unexpected error occurred:', error);
            // Display user-friendly error feedback here, if needed
        })
        .finally(() => {
            // End loading state using reusable function
            LiveBlade.toggleButtonLoading(submitButton, false);
        });


    }
</script>


<script>
    
    const submitFormEntities = (formId, submitButtonId, url, method = 'POST') => {
        document.getElementById(formId).addEventListener('submit', function(e) {
            e.preventDefault();

            // Collect form data and add additional fields
            const formData = Object.fromEntries(new FormData(this));
            formData._method = method;
            formData.routeName = url;

            // Reference the submit button and reloading
            const submitButton = document.getElementById(submitButtonId);
            LiveBlade.toggleButtonLoading(submitButton, true);
            console.log(formData);

            // Submit form data asynchronously
            LiveBlade.submitFormItems(formData)
                .then(noErrors => {
                    console.log(noErrors);
                    
                    if (noErrors) {
                        // Close the modal if no errors
                        const closeModal = () => {
                            document.getElementById('discardMeetingButton').click();
                        };
                        closeModal();
                        
                        const currentUrl = "{{ url()->current() }}"; 
                        window.location.href = currentUrl;
                    }
                })
                .catch(error => {
                    console.error('An unexpected error occurred:', error);
                })
                .finally(() => {
                    LiveBlade.toggleButtonLoading(submitButton, false);
                });

                
        });
    };

    submitFormEntities('kt_modal_add_meeting_form', 'submitMeetingButton', '{{ route('meeting.store') }}');
</script>

