<div class="card-body py-4" id="invoiceIndexTable">
    <div class="table-responsive">
        <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5">
            <thead class="table-light">
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Billed On</th>
                    <th>Due Date</th>
                    <th>Billed By</th>
                    <th>Is Paid</th>
                    <th>Paid On</th>
                    <th>Paid By</th>
                    <th>Reference Number</th>
                    <th class="w-auto">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($project->invoices as $invoice)
                    <tr
                        style="{{ $invoice->isPaid === 1 ? 'background-color: #f8d7da;' : '' }}"
                    >
                        <td>{{ $invoice->description }}</td>
                        <td>{{ $invoice->project->currency->name }} {{ number_format($invoice->amount,2) }}</td>
                        <td>{{ $invoice->billing_date }}</td>
                        <td>{{ $invoice->due_date ?? '' }}</td>
                        <td>{{ $invoice->createdByUser->first_name }} {{ $invoice->createdByUser->last_name }}</td>
                        <td>{{ $invoice->isPaid == 0 ? 'No' : 'Yes' }}</td>
                        <td>{{ $invoice->paidOn ?? '' }}</td>
                        <td>{{ $invoice->ClientPayer->name ?? '' }}</td>
                        <td>{{ $invoice->reference_number ?? '' }}</td>
                        @if ($invoice->isPaid == 0)
                        <td class="d-flex align-items-center gap-2 flex-column flex-sm-row">
                        <div class="d-flex justify-content-start align-items-center">
                        @can('update invoice')
                                    <button 
                                        class="btn btn-sm btn-light btn-active-color-primary d-flex align-items-center px-3 py-2"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#payInvoiceModal{{$invoice->id}}">
                                        <i class="bi bi-credit-card-2-back me-1 fs-5"></i><span>Update Payment</span>
                                    </button>
                                @endcan

                                @can('send invoice')
                                    <button 
                                        class="btn btn-sm btn-light btn-active-color-success d-flex align-items-center mx-2 px-3 py-2"                                             
                                        data-bs-toggle="modal" 
                                        data-bs-target="#sendInvoiceMail{{$invoice->id}}">
                                        <i class="bi bi-send-check me-1 fs-5"></i> <span>Send Invoice</span>
                                    </button>
                                @endcan

                                @can('delete invoice')
                                    <button 
                                    class="btn btn-sm btn-light btn-active-color-danger d-flex align-items-center mx-2 px-3 py-2"                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteInvoiceModal{{$invoice->id}}">
                                        <i class="bi bi-trash me-1 fs-5"></i> <span>Delete</span>
                                    </button>
                                @endcan
                            </div>
                        </td>          
                                    <!-- Delete Invoce Modal -->
                        <div class="modal fade" id="deleteInvoiceModal{{$invoice->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('Confirm Deletion') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{ __('Are you sure you want to delete this Invoice?') }}</p>
                                        <p>{{ __('This action cannot be undone.') }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- Discard Button -->
                                        <button type="button" id="closeDeleteModal{{$invoice->id}}" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('Discard') }}</button>
                                        <!-- Confirm Button -->
                                        <button type="button" id="deleteButton{{$invoice->id}}" class="btn btn-danger" 
                                            data-item-url="{{ route('invoice.destroy', $invoice->id) }}" 
                                            data-item-id="{{ $invoice->id }}"
                                            onclick="deleteItem(this)">
                                            <span class="indicator-label">{{ __('Confirm') }}</span>
                                            <span class="indicator-progress" style="display: none;">
                                                {{ __('Please wait...') }}
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Resend Invoce Modal -->
                        <div class="modal fade" id="sendInvoiceMail{{$invoice->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('Resend Invoice') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{ __('Are you sure you want to resend this Invoice?') }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- Discard Button -->
                                        <button type="button" id="closeInvoiceModal{{$invoice->id}}" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('Discard') }}</button>
                                        <!-- Confirm Button -->
                                        <button type="button" id="invoiceButton{{$invoice->id}}" class="btn btn-success" 
                                            onclick="resendInvoiceMail({{ $invoice->id }})">
                                            <span class="indicator-label">{{ __('Confirm') }}</span>
                                            <span class="indicator-progress" style="display: none;">
                                                {{ __('Please wait...') }}
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="modal fade" id="payInvoiceModal{{$invoice->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('Confirm Payment') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="pay_invoice_form{{ $invoice->id }}" class="form">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="invoiceId" value="{{ $invoice->id }}">
                                            <div class="text-center pt-10">
                                                <div class="row g-9 mb-8">
                                                    <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                            <span class="required">Paid On</span>
                                                        </label>
                                                        <input class="form-control flatpickr-input" name="paidOn" type="date" >
                                                        <div id="paidOn{{ $invoice->id }}"></div>
                                                    </div>

                                                    <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                            <span class="required">Client Name</span>
                                                        </label>
                                                        <div class="d-flex">
                                                            <select class="form-select me-2" name="paidBy" >
                                                                <option></option>
                                                                @foreach ($clients as $client)
                                                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div id="paidBy{{ $invoice->id }}"></div>
                                                    </div>
                                                </div>

                                                <button type="reset" class="btn btn-light me-3" id="closeModalEditButton{{ $invoice->id }}" data-bs-dismiss="modal">Discard</button>
                                                <button onclick="editInstanceLoop({{$invoice->id }})" id="editInvoiceButton{{ $invoice->id }}" type="button" class="btn btn-primary" id>
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
                        @else
                        <td>
                            <button 
                                class="btn btn-sm btn-icon btn-bg-light btn-active-color-danger w-30px h-30px">
                                Paid
                            </button>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<script>
    function resendInvoiceMail(invoiceId) {
        const submitButton = document.getElementById(`invoiceButton${invoiceId}`);

        LiveBlade.toggleButtonLoading(submitButton, true);

        // Construct the dynamic URL for the specific invoice
        const actionUrl = `/invoice/resend/${invoiceId}`;

        // Send the request to the backend
        LiveBlade.actionDriven(actionUrl)
            .then(noErrors => {
                if (noErrors) {
                    Swal.fire({
                        title: 'Success!',
                        text: `Invoice ${invoiceId} email was resent successfully.`,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    
                    var closeButton = document.getElementById('closeInvoiceModal' + invoiceId);
                    if (closeButton) {
                        closeButton.click();
                    }
                
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: `Failed to resend invoice ${invoiceId}. Please try again later.`,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error(`Error resending invoice ${invoiceId}:`, error);
            })
            .finally(() => {
                // Disable loading state for the button
                LiveBlade.toggleButtonLoading(submitButton, false);
            });
    }

    function resendInvoicesBatch(invoiceIds) {
        invoiceIds.forEach(invoiceId => {
            resendInvoiceMail(invoiceId);
        });
    }
</script>



<script>
    function deleteItem(button) {
        const itemId = button.getAttribute('data-item-id');
        const deleteUrl = button.getAttribute('data-item-url');

        const deleteButton = document.getElementById('deleteButton' + itemId);
        LiveBlade.toggleButtonLoading(deleteButton, true);
        
        // Call the delete function to handle the deletion
        LiveBlade.deleteItemInLoop(deleteUrl)
            .then(noErrorStatus => {
                console.log(noErrorStatus)
                if (noErrorStatus) {
                    var closeButton = document.getElementById('closeDeleteModal' + itemId);
                    if (closeButton) {
                        closeButton.click();
                    }
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('An unexpected error occurred:', error);
                // Handle error gracefully
            })
            .finally(() => {
                // End loading state using reusable function
                LiveBlade.toggleButtonLoading(deleteButton, false);
            });
    }
</script>




<script>
    
    function editInstanceLoop(uniqueId) {
        const submitButton = document.getElementById('editInvoiceButton' + uniqueId);
        LiveBlade.toggleButtonLoading(submitButton, true);

        // Select the form and create FormData from it
        var form = document.getElementById('pay_invoice_form' + uniqueId);
        var formData = new FormData(form);

        var data = Object.fromEntries(formData.entries());
        console.log(data);

        // Set up the URL dynamically
        var updateUrl = '{{ route('invoice.update', ['invoice' => ':id']) }}'.replace(':id', uniqueId);

        // Submit form data asynchronously
        LiveBlade.editLoopForms(data, updateUrl)
            .then(noErrorStatus => {
                if (noErrorStatus) {
                    var closeButton = document.getElementById('closeModalEditButton' + uniqueId);
                    if (closeButton) {
                        closeButton.click();
                    }
                    window.location.reload();
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

