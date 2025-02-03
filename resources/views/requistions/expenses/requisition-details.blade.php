<div class="modal fade" id="viewRequisition{{ $project->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content shadow-lg rounded-lg" id="requisitionModal">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h2 class="fw-bold mb-0">
                    <i class="ki-duotone ki-file fs-2 me-2"></i>
                    {{ __('Project Requisitions - ') }} {{ $project->projectName }}
                </h2>
                <button type="button" class="btn btn-icon btn-sm text-white" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-2"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body px-5 py-4">
                <div class="row g-3">
                    <div class="col-12">
                        <!-- Table for Requisitions -->
                        <h4 class="fw-bold text-dark mb-3">Requisitions Summary</h4>
                        <table class="table table-bordered bg-white shadow-sm">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Amount Spent</th>
                                    <th>Voucher Number</th>
                                    <th>Spent By</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requisitions as $key => $requisition)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $requisition->name }}</td>
                                        <td>${{ number_format($requisition->amount ?? 0, 2) }}</td>
                                        <td>{{ $requisition->voucher ?? '---' }}</td>
                                        <td>{{ $requisition->requisitionCreater->name ?? 'None' }}</td>
                                        <td>{{ $requisition->created_at->format('d M Y, h:i a') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12">
                        <!-- Table for Requisition Items -->
                        <h4 class="fw-bold text-dark mb-3">Requisition Items</h4>
                        @foreach($requisitions as $requisition)
                            <div class="mb-4 p-3 border rounded bg-light">
                                <h5 class="text-primary fw-bold">
                                    {{ $requisition->name }} (Voucher: {{ $requisition->voucher ?? '---' }})
                                </h5>
                                <table class="table table-bordered bg-white shadow-sm">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($requisition->requisitionItems as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>${{ number_format($item->unit_cost, 2) }}</td>
                                                <td>${{ number_format($item->quantity * $item->unit_cost, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Print Button -->
                <div class="mt-4 text-end">
                    <button class="btn btn-success" onclick="printModal()">
                        <i class="ki-duotone ki-printer fs-5"></i> Print All
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
