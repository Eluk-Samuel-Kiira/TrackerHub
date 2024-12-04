<div class="modal fade" id="viewInvoices{{ $project->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" id="kt_modal_add_client">
                <h2 class="fw-bold">{{ __('Project Invoices - ') }} {{ $project->projectName }}</h2>
                <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body px-5 my-7">
                <div class="row g-9 mb-8">
                    <p class="mb-4 text-muted">Total Amount Paid: {{ $invoices->sum('amount') ?? 0 }}</p>
                    <div class="files-list">
                        @foreach($invoices as $invoice)
                            <div class="file-item border p-3 mb-3 rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">{{ $invoice->description }}</h5>
                                        <p class="mb-0 text-muted">Amount Paid: {{ $invoice->amount ?? 0 }}</p>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">
                                            {{ \Carbon\Carbon::parse($invoice->paidOn)->format('d M Y') }}
                                        </h5>
                                        <p class="mb-0 text-muted">Paid By: {{ $invoice->ClientPayer->name ?? 'None' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
