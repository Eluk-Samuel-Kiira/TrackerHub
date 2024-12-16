<div class="modal fade" id="viewRequisition{{ $project->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" id="kt_modal_add_client">
                <h2 class="fw-bold">{{ __('Project Requisitions - ') }} {{ $project->projectName }}</h2>
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
                    <!-- Files List -->
                    <div class="files-list">
                        @foreach($requisitions as $requisition)
                            <div class="file-item border p-3 mb-3 rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- File Information -->
                                    <div>
                                        <h5 class="mb-1">{{ $requisition->name }}</h5>
                                        <p class="mb-0 text-muted">Amount Spent: {{ $requisition->amount ?? 0 }}</p>
                                        <p class="mb-0 text-muted">Voucher Number: {{ $requisition->voucher ?? '---' }}</p>
                                    </div>
                                    <!-- Action Buttons -->
                                    <div>
                                        <h5 class="mb-1">{{ $requisition->created_at->format('d M Y, h:i a') }}</h5>
                                        <p class="mb-0 text-muted">Spent By: {{ $requisition->requisitionCreater->name ?? 'None' }}</p>
                                    </div>
                                </div>
                                <div class="mt-3 text-end">
                                    <!-- Print Button -->
                                    <button 
                                        class="btn btn-primary btn-sm" 
                                        onclick="printReceipt({{ $requisition->id }}, '{{ $requisition->name }}', '{{ $requisition->amount ?? 0 }}', '{{ $requisition->requisitionCreater->name ?? 'None' }}', '{{ $requisition->created_at->format('d M Y, h:i a') }}', '{{ $requisition->voucher }}')">
                                        Print Receipt
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printReceipt(id, name, amount, spentBy, createdAt, voucher) {
        // Fallback for missing voucher
        const voucherNumber = voucher;
        
        // Create the printable content
        const receiptContent = `
            <div style="padding: 20px; font-family: Arial, sans-serif; line-height: 1.6;">
                <h2 style="text-align: center;">Requisition Receipt</h2>
                <hr>
                <p><strong>Voucher Number:</strong> ${voucherNumber}</p>
                <p><strong>Name:</strong> ${name}</p>
                <p><strong>Amount Spent:</strong> ${amount}</p>
                <p><strong>Spent By:</strong> ${spentBy}</p>
                <p><strong>Created At:</strong> ${createdAt}</p>
                <hr>
                <p style="text-align: center;">Thank you for using our services!</p>
            </div>
        `;

        // Open a new window for printing
        const printWindow = window.open('', '_blank', 'width=600,height=600');
        printWindow.document.write('<html><head><title>Print Receipt</title></head><body>');
        printWindow.document.write(receiptContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();

        // Wait for the content to load and trigger the print
        printWindow.onload = function () {
            printWindow.print();
            printWindow.close();
        };
    }
</script>
