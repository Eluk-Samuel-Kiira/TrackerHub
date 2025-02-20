
<div class="tab-pane fade" id="tasks" role="tabpanel">
    <div class="card my-5">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <h3 class="card-title text-gray-900 fw-bold fs-3">Tasks</h3><div id="status"></div>
                @can('create task')
                    <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal"
                        data-bs-target="#add_project_tasks_modal">
                        Add Task
                    </a>
                @endcan
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr class="fw-bold fs-6 text-gray-800">
                        <th>Task Code</th>
                        <th>Task</th>
                        <th>Start Date</th>
                        <th>Deadline</th>
                        <th>Assigned To</th>
                        <th>Completed On</th>
                        <th>Status</th>
                        <th class="w-auto"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($project->tasks as $task)
                        <tr>
                            <td>{{ $task->taskCode }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->created_at ?? '-' }}</td>
                            <td>{{ $task->dueDate ?? '-' }}</td>
                            <td>{{ $task->user->first_name }} {{ $task->user->last_name }}</td>
                            <td>{{ $task->completionDate ?? '-' }}</td>
                            <td>
                                {{ $task->status == '0' ? 'Not Started' : ($task->status == '1' ? 'Completed' : 'Completed') }}
                            </td>
                            <td class="d-flex align-items-center gap-2 flex-column flex-sm-row">
                            <div class="d-flex gap-2">
                                    @can('update task')
                                        <button 
                                        class="btn btn-sm btn-light btn-active-color-primary d-flex align-items-center px-3 py-2" 
                                        data-bs-toggle="modal" 
                                            data-bs-target="#completeTaskModal{{$task->id}}">
                                            <i class="bi bi-infinity me-1 fs-5"></i> <span>{{ __('Update') }}</span>
                                        </button>
                                    @endcan

                                    
                                    <div class="modal fade" id="completeTaskModal{{$task->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered mw-450px">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ __('Mark Task As Completed') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="pay_task_form{{ $task->id }}" class="form">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                        <div class="text-center pt-10">
                                                            <div class="row g-9 mb-8">
                                                                <div class="d-flex flex-column mb-8 fv-row col-md-12">
                                                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                        <span class="required">Completed On</span>
                                                                    </label>
                                                                    <input class="form-control flatpickr-input" name="completionDate" type="date" >
                                                                    <div id="completionDate{{ $task->id }}"></div>
                                                                </div>
                                                            </div>

                                                            <button type="reset" class="btn btn-light me-3" id="closeModalEditTaskButton{{ $task->id }}" data-bs-dismiss="modal">Discard</button>
                                                            <button onclick="editInstanceLoopTask({{$task->id }})" id="editTaskButton{{ $task->id }}" type="button" class="btn btn-primary" id>
                                                                <span class="indicator-label">Update</span>
                                                                <span class="indicator-progress">Please wait...
                                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @can('delete task')
                                        <form action="{{ route('tasks.remove', $task) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                            class="btn btn-sm btn-light btn-active-color-danger d-flex align-items-center px-3 py-2" 
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
        </div>
    </div>
</div>


<div class="modal bg-body fade" tabindex="-1" id="add_project_tasks_modal">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content shadow-none">
            <div class="modal-header">
                <h1>Add Project Task</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span
                                class="path2"></span></i>
                    </div>
                    <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="col-12">
                    <form class="card"  id="kt_modal_add_task_form">
                        @csrf
                        <input type="hidden" name="projectId" value="{{ $project->id }}">
                        <div class="card-body shadow-none">
                            <div class="row row-cards py-5">
                                <div class="col-md-12">
                                    <div class="mb-10">
                                        <label class="form-label">Task</label>
                                        <input type="text" class="form-control" name="task" />
                                        <div id="task"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label">Deadline</label>
                                        <input class="form-control flatpickr-input" name="taskDeadlineDate"
                                            placeholder="Pick date" id="taskDeadlindDate" type="text"
                                            readonly="readonly">
                                    </div>
                                    <div id="taskDeadlineDate"></div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label class="form-label">Assign To</label>
                                        <select class="form-select form-select" name="projectMemberId"
                                            data-control="select2" data-allow-clear="true"
                                            data-close-on-select="false" data-placeholder="Select an option"
                                            data-allow-clear="true">
                                            <option></option>
                                            @foreach ($project->users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        <div id="projectMemberId"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end" style="margin-top:-5rem;">
                            <button type="reset" class="btn btn-light me-3" id="discardTaskButton" data-bs-dismiss="modal">Discard</button>
                            <button id="submitTaskButton" type="submit" class="btn btn-primary">
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



<script>
    
    function editInstanceLoopTask(uniqueId) {
        const submitButton = document.getElementById('editTaskButton' + uniqueId);
        LiveBlade.toggleButtonLoading(submitButton, true);

        // Select the form and create FormData from it
        var form = document.getElementById('pay_task_form' + uniqueId);
        var formData = new FormData(form);

        var data = Object.fromEntries(formData.entries());
        console.log(data);

        // Set up the URL dynamically
        var updateUrl = '{{ route('tasks.update', ['task' => ':id']) }}'.replace(':id', uniqueId);

        // Submit form data asynchronously
        LiveBlade.editLoopForms(data, updateUrl)
            .then(noErrorStatus => {
                if (noErrorStatus) {
                    var closeButton = document.getElementById('closeModalEditTaskButton' + uniqueId);
                    if (closeButton) {
                        closeButton.click();
                    }

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

    submitFormEntities('kt_modal_add_task_form', 'submitTaskButton', '{{ route('tasks.add') }}');
</script>


