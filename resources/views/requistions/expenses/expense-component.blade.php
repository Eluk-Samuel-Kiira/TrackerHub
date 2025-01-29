<div class="card-body py-4" id="reloadRequisitionComponent">
    <div class="table-responsive">
         <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5"
            id="kt_table_users"
            data-bs-theme="light">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox"
                                data-kt-check="true"
                                data-kt-check-target="#kt_table_users .form-check-input"
                                value="1" />
                        </div>
                    </th>
                    <th class="min-w-125px">{{ __('Project Code') }}</th>
                    <th class="min-w-125px">{{ __('Project Name') }}</th>
                    <th class="min-w-125px">{{ __('Budget Limit') }}</th>
                    <th class="min-w-125px">{{ __('Approved (Spent)') }}</th>
                    <th class="min-w-125px">{{ __('Limit Balance') }}</th>
                    <th class="min-w-125px">{{ __('Status') }}</th>
                    <th class="min-w-125px">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 fw-semibold">
                @if (!empty($combinedData) && $combinedData->count() > 0)
                    @foreach ($combinedData as $data)
                        @php
                            $project = $data['project'];
                            $client_payments = $data['client_payments'];
                            $totalApproved = $data['total_approved'];
                            $requisitions = $data['requisitions'];
                            $invoices = $data['invoices'];

                            $limitBalance = $project->projectBudgetLimit - $totalApproved;
                            $percentageSpent = $project->projectBudgetLimit > 0 ? ($totalApproved / $project->projectBudgetLimit) * 100 : 0;

                            // Calculate overall cost
                            $payments_received = $client_payments->sum('amount');

                            // Calculate client balance
                            $client_balance = $project->projectCost - $payments_received;

                            // Handle cases where projectCost or client_balance is negative
                            if ($project->projectCost != 0) {
                                $percentage_left = ($client_balance / abs($project->projectCost)) * 100;
                            } else {
                                $percentage_left = 0;
                            }

                            // Explanation of client balance
                            $balance_type = '';
                            if ($client_balance == 0) {
                                $balance_type = 'Fully Paid';
                            } else {
                                $balance_type = $client_balance < 0 ? 'Overpaid' : 'Pending';
                            }



                            // Additional Calculations
                            $expectedProfit = $project->projectCost - $project->projectBudget;
                            // actual profit is the amount the client has paid minus what we have spent already 
                            $actualProfit = $payments_received - $totalApproved;

                            // Ensure calculations account for negative values
                            $profitMargin = $expectedProfit != 0 
                                ? ($actualProfit / abs($expectedProfit)) * 100 
                                : 0;

                            // If balance is negative, calculate the over-budget amount; otherwise, it's zero
                            $balance = $project->projectBudget - $project->projectBudgetLimit;
                            $overBudgetAmount = $balance < 0 ? abs($balance) : 0;

                            // Calculate the budget difference
                            $isWithInBudget = $project->projectBudget - $project->projectBudgetLimit;

                            // Handle negative and positive cases
                            if ($isWithInBudget >= 0) {
                                $budget_status = 'Within Budget';
                            } else {
                                $budget_status = 'Over Budget';
                            }


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
                            <td>{{ number_format($limitBalance, 2) }}</td>
                            <td>
                                @if ($balance < 0)
                                    <span class="badge badge-danger">{{ __('Over Budget') }}</span>
                                @else
                                    <span class="badge badge-success">{{ __('Within Budget') }}</span>
                                @endif
                            </td>
                            <td class="d-flex align-items-center gap-2 flex-column flex-sm-row">
                            <div class="d-flex justify-content-start align-items-center flex-sm-row">
                                 @can('view report')
                                    <button 
                                    class="btn btn-sm btn-light btn-active-color-primary d-flex align-items-center mx-2 px-3 py-2"
                                    data-bs-toggle="modal" 
                                        data-bs-target="#viewReport{{ $project->id }}">
                                        <i class="bi bi-printer fs-5 me-1"></i><span>{{ __('Detailed Report') }}</span>
                                    </button>
                                @endcan

                                @can('view requisitions')
                                    <button 
                                    class="btn btn-sm btn-light btn-active-color-success d-flex align-items-center mx-2 px-3 py-2"
                                    data-bs-toggle="modal" 
                                        data-bs-target="#viewRequisition{{ $project->id }}">
                                        <i class="bi bi-bar-chart-line fs-5 me-1"></i><span>{{ __('Approved Requisitions') }}</span>
                                    </button>
                                @endcan
                                
                                @can('view invoice')
                                    <button 
                                    class="btn btn-sm btn-light btn-active-color-primary d-flex align-items-center px-3 py-2"
                                    data-bs-toggle="modal" 
                                        data-bs-target="#viewInvoices{{ $project->id }}">
                                        <i class="bi bi-receipt fs-5 me-1"></i><span>{{ __('Paid Invoices') }}</span>
                                    </button>
                                @endcan
                            </div>
                            <div class= "py-2">
                                @include('requistions.expenses.detail-report')
                                @include('requistions.expenses.requisition-details')
                                @include('requistions.expenses.invoices-paid')
                            </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
    function setupTableSearch(inputId, tableId) {
        LiveBlade.searchTableItems(inputId, tableId)
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        setupTableSearch('searchInput', 'kt_table_users');
        
    });
</script>

