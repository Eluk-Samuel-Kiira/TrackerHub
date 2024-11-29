<div class="card-body py-4" id="reloadRequisitionComponent">
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
                    </div>
                </th>
                <th class="min-w-125px">{{ __('Project Code') }}</th>
                <th class="min-w-125px">{{ __('Project Name') }}</th>
                <th class="min-w-125px">{{ __('Budget Limit') }}</th>
                <th class="min-w-125px">{{ __('Total Approved') }}</th>
                <th class="min-w-125px">{{ __('Balance') }}</th>
                <th class="min-w-125px">{{ __('Status') }}</th>
                <th class="min-w-125px">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            @if (!empty($combinedData) && $combinedData->count() > 0)
                @foreach ($combinedData as $data)
                    @php
                        $project = $data['project'];
                        $totalApproved = $data['total_approved'];
                        $requisitions = $data['requisitions'];

                        $balance = $project->projectBudgetLimit - $totalApproved;
                        $percentageSpent = $project->projectBudgetLimit > 0 ? ($totalApproved / $project->projectBudgetLimit) * 100 : 0;

                        // Additional Calculations
                        $expectedProfit = $project->projectBudget - $project->projectCost;
                        $actualProfit = $expectedProfit - $totalApproved;
                        $profitMargin = $expectedProfit > 0 ? ($actualProfit / $expectedProfit) * 100 : 0;
                        $overBudgetAmount = $balance < 0 ? abs($balance) : 0;
                    @endphp
                    <tr>
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td>{{ $project->projectCode }}</td>
                        <td>{{ $project->projectName }}</td>
                        <td>{{ number_format($project->projectBudgetLimit, 2) }}</td>
                        <td>{{ number_format($totalApproved, 2) }}</td>
                        <td>{{ number_format($balance, 2) }}</td>
                        <td>
                            @if ($balance < 0)
                                <span class="badge badge-danger">{{ __('Over Budget') }}</span>
                            @else
                                <span class="badge badge-success">{{ __('Within Budget') }}</span>
                            @endif
                        </td>
                        <td>
                            <button 
                                class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px" 
                                data-bs-toggle="modal" 
                                data-bs-target="#viewReport{{ $project->id }}">
                                <i class="bi bi-printer fs-2"></i>
                            </button>
                            <button 
                                class="btn btn-sm btn-icon btn-bg-light btn-active-color-success w-30px h-30px" 
                                data-bs-toggle="modal" 
                                data-bs-target="#viewRequisition{{ $project->id }}">
                                <i class="bi bi-bar-chart-line fs-2"></i>
                            </button>
                            @include('requistions.expenses.detail-report')
                            @include('requistions.expenses.requisition-details')
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<script>
    function setupTableSearch(inputId, tableId) {
        LiveBlade.searchTableItems(inputId, tableId)
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        setupTableSearch('searchInput', 'kt_table_users');
        
    });
</script>
