 
<div class="modal fade" id="editRequisition{{ $requisition->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_client">
                <h2 class="fw-bold">{{__('Edit Requisition')}}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_edit_requisition_form{{ $requisition->id }}" class="form">
                    @csrf
                    @method('PUT')
                    <div class="text-center pt-10">
                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Title</span>
                                </label>
                                <select name="project_id" class="form-select form-select" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}" {{ $requisition->project_id == $project->id ? 'selected' : '' }}>{{ $project->projectName }}</option>
                                    @endforeach
                                </select>
                                <div id="project_id{{ $requisition->id }}"></div>
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Requisition Total Amount</span>
                                </label>
                                <input type="text" value="{{ $requisition->amount }}" class="form-control form-control-solid" name="amount" />
                                <div id="amount{{ $requisition->id }}"></div>
                            </div>
                        </div>

                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-12">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Requisition Purpose/Description</span>
                                </label>
                                <textarea name="description" id="kt_docs_ckeditor_classic_{{$requisition->id}}">
                                    {!! e($requisition->description) !!}
                                </textarea>
                                <div id="description{{ $requisition->id }}"></div>
                            </div>
                        </div>
                        
                        <div class="row g-9 mb-8">
                            @foreach($requisitionItems as $key => $item)
                                @if($item->requisition_id === $requisition->id)
                                    <div class="col-md-12 mb-3" id="row_{{ $key }}">
                                        <div class="row" id="requisitionRow_{{ $key }}">
                                            <!-- Requisition Title -->
                                            <div class="col-md-2">
                                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                    <span class="required">Requisition Title/Name</span>
                                                </label>
                                                <input type="text" class="form-control" name="requisitionTitle[]" value="{{ $item->title }}" required>
                                            </div>
                                            <!-- Category -->
                                            <div class="col-md-2">
                                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                    <span class="required">Category</span>
                                                </label>
                                                <select class="form-select" name="requisitionCategoryId[]" required>
                                                    <option></option>
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}" {{ $item->category_id == $department->id ? 'selected' : '' }}>
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- UoM -->
                                            <div class="col-md-2">
                                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                    <span class="required">UoM</span>
                                                </label>
                                                <select class="form-select" name="uom[]" required>
                                                    <option></option>
                                                    @foreach ($uoms as $uom)
                                                        <option value="{{ $uom->id }}" {{ $item->uom_id == $uom->id ? 'selected' : '' }}>
                                                            {{ $uom->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Quantity -->
                                            <div class="col-md-1">
                                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                    <span class="required">Quantity</span>
                                                </label>
                                                <input type="number" class="form-control qty" name="quantity[]" value="{{ $item->quantity }}" oninput="calculateRowAmount(this)" required>
                                            </div>
                                            <!-- Unit Cost -->
                                            <div class="col-md-2">
                                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                    <span class="required">Unit Cost</span>
                                                </label>
                                                <input type="number" class="form-control unit-cost" name="unitCost[]" value="{{ $item->unit_cost }}" oninput="calculateRowAmount(this)" required>
                                            </div>
                                            <!-- Amount -->
                                            <div class="col-md-2">
                                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                    <span class="required">Amount</span>
                                                </label>
                                                <input type="number" class="form-control amount" name="total_amount[]" value="{{ $item->amount }}" readonly>
                                            </div>
                                            <!-- Remove Button -->
                                            <div class="col-md-1">
                                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                    <span class="required">Action</span>
                                                </label>
                                                <button type="button" class="btn btn-danger btn-sm removeRow">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <div class="d-flex justify-content-end mt-2">
                                <button type="button" class="btn btn-sm btn-primary" id="addRow">
                                    <i class="bi bi-plus-lg"></i> Add Item
                                </button>
                            </div>
                            <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                // Calculate total amount when changing quantity or unit cost
                                function calculateRowAmount(input) {
                                    const row = input.closest(".row");
                                    const qty = row.querySelector(".qty").value || 0;
                                    const unitCost = row.querySelector(".unit-cost").value || 0;
                                    const amountField = row.querySelector(".amount");
                                    amountField.value = (qty * unitCost).toFixed(2);
                                    calculateGrandTotal();
                                }

                                // Calculate the grand total of all rows
                                function calculateGrandTotal() {
                                    let total = 0;
                                    const amounts = document.querySelectorAll(".amount");
                                    amounts.forEach(amount => {
                                        total += parseFloat(amount.value) || 0;
                                    });
                                    document.getElementById("grandTotal").value = total.toFixed(2);
                                }

                                // Initialize total calculation
                                document.querySelectorAll('.qty, .unit-cost').forEach(input => {
                                    input.addEventListener('input', function() {
                                        calculateRowAmount(input);
                                    });
                                });

                                // Calculate grand total on page load in case values are already populated
                                calculateGrandTotal();
                            });
                        </script>
                        </div>

                        
                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-12">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Status Reasons</span>
                                </label>
                                <input type="text" value="{{ $requisition->reasons }}" class="form-control form-control-solid" name="name" disabled/>
                            </div>
                        </div>

                        <button type="reset" class="btn btn-light me-3" id="closeModalEditButton{{ $requisition->id }}" data-bs-dismiss="modal">Discard</button>
                        <button onclick="editInstanceLoop({{$requisition->id }})" id="editClientButton{{ $requisition->id }}" type="button" class="btn btn-primary" {{ $requisition->status === 'approved' ? 'disabled' : '' }}>
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

<style>
    .ck-editor__editable {
        min-height: 200px; /* Adjust the height as needed */
    }
    .ck-toolbar {
        position: fixed; 
        top: 0;
        z-index: 10;
    }
</style>

<script>

    function editInstanceLoop(uniqueId) {
        const submitButton = document.getElementById('editClientButton' + uniqueId);
        LiveBlade.toggleButtonLoading(submitButton, true);

        // Select the form and create FormData from it
        var form = document.getElementById('kt_modal_edit_requisition_form' + uniqueId);
        var formData = new FormData(form);
        if (editorInstance) {
            var editorContent = editorInstance.getData(); 
            formData.append('description', editorContent); 
        }

        var data = Object.fromEntries(formData.entries());
        // console.log(data);

        // Set up the URL dynamically
        var updateUrl = '{{ route('requistion.update', ['requistion' => ':id']) }}'.replace(':id', uniqueId);

        // Submit form data asynchronously
        LiveBlade.editLoopForms(data, updateUrl)
            .then(noErrorStatus => {
                if (noErrorStatus) {
                    var closeButton = document.getElementById('closeModalEditButton' + uniqueId);
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


