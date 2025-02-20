 
<div class="modal fade" id="viewReport{{ $project->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">{{ __('Project Report - ') }} {{ $project->projectName }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <div id="printableReport{{ $project->id }}" class="report-container">
                    <!-- Header Section -->
                    <div class="report-header">
                        <h3>{{ $project->projectName }}</h3>
                        <p><strong>{{ __('Project Code:') }}</strong> {{ $project->projectCode }}</p>
                        <p><strong>{{ __('Start Date:') }}</strong> {{ \Carbon\Carbon::parse($project->projectStartDate)->format('d M Y') }}</p>
                        <p><strong>{{ __('Deadline:') }}</strong> {{ \Carbon\Carbon::parse($project->projectDeadlineDate)->format('d M Y') }}</p>
                    </div>

                    <!-- Budget Expenditure Summary -->
                    <div class="report-section">
                        <h4>{{ __(' Budget Expenditure Summary') }}</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Budget Limit') }}</th>
                                    <th>{{ __('Total Expenditure') }}</th>
                                    <th>{{ __('Budget Limit Balance') }}</th>
                                    <th>{{ __('% Spent') }}</th>
                                    <th>{{ __('Over Budget') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ number_format($project->projectBudgetLimit, 2) }}</td>
                                    <td>{{ number_format($totalApproved, 2) }}</td>
                                    <td>{{ number_format($limitBalance, 2) }}</td>
                                    <td>{{ number_format($percentageSpent, 2) }}%</td>
                                    <td>{{ number_format($overBudgetAmount, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Project Cost Summary -->
                    <div class="report-section">
                        <h4>{{ __('Project Cost Summary') }}</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Expected Cost') }}</th>
                                    <th>{{ __('Actual Cost Paid') }}</th>
                                    <th>{{ __('Balance') }}</th>
                                    <th>{{ __('% Balance') }}</th>
                                    <th>{{ __('Balance Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ number_format($project->projectCost, 2) }}</td><!-- Amount Expected to be Paid by Client -->
                                    <td>{{ number_format($payments_received, 2) }}</td> <!-- Amount Paid by Client -->
                                    <td>{{ number_format($client_balance, 2) }}</td><!-- Balance to be paid by Client -->
                                    <td>{{ number_format($percentage_left, 2) }}%</td> <!-- % Paid by Client -->
                                    <td>{{ $balance_type }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Profit Analysis -->
                    <div class="report-section">
                        <h4>{{ __('Profit Analysis') }}</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Expected Profit') }}</th>
                                    <th>{{ __('Actual Profit') }}</th>
                                    <th>{{ __('Profit Margin') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ number_format($expectedProfit, 2) }}</td>
                                    <td>{{ number_format($actualProfit, 2) }}</td>
                                    <td>{{ number_format($profitMargin, 2) }}%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Description Section -->
                    <div class="report-section">
                        <h4>{{ __('Project Description') }}</h4>
                        <p>{!! $project->projectDescription !!}</p>
                    </div>

                    <!-- Project Status -->
                    <div class="report-section">
                        <h4>{{ __('Project Status') }}</h4>
                        <p>
                            {{ $budget_status }}
                        </p>
                    </div>
                    <div class="px-5 my-7">
                    <div class="row g-4">
                        @foreach($requisitions as $requisition)
                            <div class="col-md-6">
                                <div class="border p-3 rounded bg-light dark-mode-bg">
                                    <h6 class="mb-1">{{ $requisition->name }}</h6>
                                    <p class="text-muted mb-1">Amount Spent: {{ $requisition->amount ?? 0 }}</p>
                                    <p class="text-muted mb-1">Voucher Number: {{ $requisition->voucher ?? '---' }}</p>
                                    <small class="text-muted">Spent By: {{ $requisition->requisitionCreater->name ?? 'None' }} on 
                                        {{ $requisition->created_at->format('d M Y, h:i a') }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> 
                </div>
            </div>
            <div class="modal-footer">
                <button 
                    class="btn btn-primary" 
                    onclick="printReport('printableReport{{ $project->id }}')">
                    {{ __('Print Report') }}
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>
 

<script>
    function printReport(reportId) {
        var printContents = document.getElementById(reportId).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload(); // Reload page after printing
    }
</script>


<style>
    .report-container {
        padding: 20px;
        font-family: Arial, sans-serif;
        color: #333;
        background-color: #f9f9f9;
        border-radius: 8px;
    }

    .report-header {
        text-align: center;
        margin-bottom: 20px;
        background-color: #007bff;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
    }

    .report-header h3 {
        margin: 0;
        font-size: 24px;
    }

    .report-section {
        margin-bottom: 20px;
    }

    .report-section h4 {
        font-size: 18px;
        font-weight: bold;
        border-bottom: 2px solid #007bff;
        margin-bottom: 10px;
        padding-bottom: 5px;
    }

    .table-bordered {
        width: 100%;
        border: 1px solid #ddd;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .table-bordered th, .table-bordered td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .table-bordered th {
        background-color: #f1f1f1;
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

</style>