 
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
                                <input type="text" name="amount" id="totalRequisitionAmount_{{ $requisition->id }}" value="{{ $requisition->amount }}" class="form-control form-control-solid"  readonly/>
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
                                        <div class="row requisition-row" id="requisitionRow_{{ $key }}" data-requisition-id="{{ $item->requisition_id }}">

                                            <input type="hidden" class="form-control" name="requisitionItemId[]" value="{{ $item->id }}" required>
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
                                            <div class="col-md-2">
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
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            
                        </div>
                        
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                function calculateRowAmount(input) {
                                    const row = input.closest(".requisition-row"); // Make sure this matches the correct class

                                    if (!row) {
                                        console.error("Row not found for input", input);
                                        return;
                                    }

                                    const qty = parseFloat(row.querySelector(".qty")?.value) || 0;
                                    const unitCost = parseFloat(row.querySelector(".unit-cost")?.value) || 0;
                                    const amountField = row.querySelector(".amount");

                                    // Calculate amount for the row
                                    amountField.value = (qty * unitCost).toFixed(2);

                                    // Recalculate total for requisition
                                    calculateGrandTotal();
                                }

                                function calculateGrandTotal() {
                                    let requisitionTotals = {}; // Store totals per requisition ID

                                    document.querySelectorAll(".amount").forEach(amountField => {
                                        const row = amountField.closest(".requisition-row");

                                        if (!row) {
                                            console.error("Row not found for amount field", amountField);
                                            return;
                                        }

                                        const requisitionId = row.getAttribute("data-requisition-id");

                                        if (!requisitionId) {
                                            // console.error("Requisition ID not found for row", row);
                                            return;
                                        }

                                        if (!requisitionTotals[requisitionId]) {
                                            requisitionTotals[requisitionId] = 0;
                                        }

                                        requisitionTotals[requisitionId] += parseFloat(amountField.value) || 0;
                                    });

                                    // Update the respective requisition total amount fields
                                    Object.keys(requisitionTotals).forEach(requisitionId => {
                                        const totalAmountDiv = document.getElementById(`amount${requisitionId}`);
                                        if (totalAmountDiv) {
                                            totalAmountDiv.innerHTML = `<strong>Total: ${requisitionTotals[requisitionId].toFixed(2)}</strong>`;
                                        }

                                        // Update the input field
                                        const totalAmountInput = document.getElementById(`totalRequisitionAmount_${requisitionId}`);
                                        if (totalAmountInput) {
                                            totalAmountInput.value = requisitionTotals[requisitionId].toFixed(2);
                                        }
                                    });
                                }

                                document.querySelectorAll('.qty, .unit-cost').forEach(input => {
                                    input.addEventListener('input', function() {
                                        calculateRowAmount(input);
                                    });
                                });

                                calculateGrandTotal(); // Recalculate on page load
                            });
                        </script>
                        
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
        
        let requisitionTitles = [];
        let requisitionItemIds = [];
        let requisitionCategoryIds = [];
        let uoms = [];
        let quantities = [];
        let unitCosts = [];
        let total_amounts = [];

        document.querySelectorAll(".requisition-row").forEach(row => {
            // Ensure the row is not hidden and matches the requisition_id
            let rowRequisitionId = row.getAttribute("data-requisition-id");
            if (row.style.display !== "none" && rowRequisitionId == uniqueId) {

                requisitionItemIds.push(row.querySelector("input[name='requisitionItemId[]']").value);
                requisitionTitles.push(row.querySelector("input[name='requisitionTitle[]']").value);

                let categorySelect = row.querySelector("select[name='requisitionCategoryId[]']");
                requisitionCategoryIds.push(categorySelect ? categorySelect.value : "");

                let uomSelect = row.querySelector("select[name='uom[]']");
                uoms.push(uomSelect ? uomSelect.value : "");

                quantities.push(row.querySelector("input[name='quantity[]']").value);
                unitCosts.push(row.querySelector("input[name='unitCost[]']").value);
                total_amounts.push(row.querySelector("input[name='total_amount[]']").value);
            }
        });

        // append items
        data.requisitionItemId = requisitionItemIds;
        data.requisitionTitle = requisitionTitles;
        data.requisitionCategoryId = requisitionCategoryIds;
        data.uom = uoms;
        data.quantity = quantities;
        data.unitCost = unitCosts;
        data.total_amount = total_amounts;

        console.log(data);

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
                    // window.location.href = '{{ route('requistion.index') }}';
                });


    }

</script>


