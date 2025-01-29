
<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
    <thead>
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
            <th class="w-10px pe-2">
                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
                </div>
            </th>
            <th class="min-w-125px">{{__('Code')}}</th>
            <th class="min-w-125px">{{__('Name')}}</th>
            <th class="min-w-125px">{{__('Deadline')}}</th>
            <th class="min-w-125px">{{__('Category')}}</th>
            <th class="min-w-125px">{{__('Client')}}</th>
            <th class="min-w-125px">{{__('Project Cost')}}</th>
            <th class="min-w-125px">{{__('Progress')}}</th>
            <th class="text-end min-w-100px">{{__('Actions')}}</th>
        </tr>
    </thead>
    <tbody class="text-gray-600 fw-semibold">
        @if (!empty($projects) && $projects->count() > 0)
            @foreach ($projects as $project)
                <tr data-role="{{ strtolower($project->id) }}">
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="1" />
                        </div>
                    </td>
                    <td>
                        <div class="badge badge-light fw-bold">{{ $project->projectCode }}</div>
                    </td>
                    <td class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                            <a href="{{route('projects.show', $project) }}" class="text-gray-800 text-hover-primary mb-1">{{ $project->projectName }}</a>
                        </div>
                    </td>
                    <td>{{ $project->projectDeadlineDate }}</td>
                    <td>
                        <div class="badge badge-light fw-bold">{{ $project->projectCategory->name ?? 'N\A' }}</div>
                    </td>
                    <td>{{ $project->client->name }}</td>
                    <td>{{ $project->currency->name ?? 'N|A' }} {{ number_format($project->projectCost,2) }}</td>
                    <td>
                        <div class="progress">
                            <div
                                class="progress-bar progress-bar-striped bg-primary"
                                role="progressbar"
                                style="width: {{ number_format($project->percentageCompletion, 2) ?? 0}}%"
                                aria-valuenow="{{ number_format($project->percentageCompletion, 2) ?? 0 }}"
                                aria-valuemin="0"
                                aria-valuemax="100">
                                {{ number_format($project->percentageCompletion, 2) ?? 0 }}%
                            </div>
                        </div>
                    </td>
                    <td class="d-flex align-items-start flex-column">
                        @can('view project')
                        <div class="mb-2">
                            <a href="{{ route('projects.show', $project) }}" 
                            class="btn btn-icon btn-bg-light btn-active-color-success w-auto h-30px d-flex align-items-center">
                                <i class="bi bi-eye fs-5 me-2"></i> 
                                <span class="fw-semibold">{{ __('More Info') }}</span>
                            </a>
                        </div>
                        @endcan

                        @can('edit project')
                        <div>
                            <button class="btn btn-icon btn-bg-light btn-active-color-primary w-auto h-30px d-flex align-items-center"
                                data-bs-toggle="modal" 
                                data-bs-target="#edit_project_modal{{$project->id}}">
                                <i class="bi bi-pencil-square fs-5 me-2"></i> 
                                <span class="fw-semibold">{{ __('Edit') }}</span>
                            </button>
                        </div>
                        @endcan

                        @include('projects.projects.edit-project')
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>