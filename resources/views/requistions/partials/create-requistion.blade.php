 
<div class="modal fade" id="kt_modal_add_requistion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_requistion">
                <h2 class="fw-bold">{{__('Create New Requistion')}}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_add_requistion_form" class="form">
                    @csrf
                    <input type="hidden" class="form-control form-control-solid" name="requistion_page" value="true"/>
                    <div class="text-center pt-10">
                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Select Project</span>
                                </label>
                                <select name="project_id" class="form-select form-select" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->projectName }}</option>
                                    @endforeach
                                </select>
                                <div id="project_id"></div>
                            </div>

                            <div class="d-flex flex-column mb-8 fv-row col-md-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Requisition Total Amount</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="amount_create" readonly/>
                                <div id="amount_create"></div>
                            </div>
                        </div>
                        
                        <div class="row g-9 mb-8">
                            <div class="d-flex flex-column mb-8 fv-row col-md-12">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Requisition Purpose/Description</span>
                                </label>
                                <textarea name="description" class="form-control"></textarea>
                                <div id="description"></div>
                            </div>
                        </div> 

                        <div class="table-responsive">
                            <table class="table table-bordered" id="requisitionTable">
                                <thead>
                                    <tr>
                                        <th>S/No</th>
                                        <th>Requisition Title/Name</th>
                                        <th>Category</th>
                                        <th>UoM</th>
                                        <th>Qtn</th>
                                        <th>Unit Cost</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control" name="CreateRequisitionTitle[]" required></td>
                                        <td>
                                            <select class="form-select" name="CreateRequisitionCategoryId[]" required>
                                                <option></option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select" name="CreateUom[]" required>
                                                <option></option>
                                                @foreach ($uoms as $uom)
                                                    <option value="{{ $uom->id }}">{{ $uom->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control qty_create" name="CreateQuantity[]" oninput="calculateRowAmount(this)" required></td>
                                        <td><input type="number" class="form-control unit-cost_create" name="CreateUnitCost[]" oninput="calculateRowAmount(this)" required></td>
                                        <td><input type="number" class="form-control amount_create" name="CreateTotal_amount[]" readonly></td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm removeRow"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end mt-2">
                                <button type="button" class="btn btn-sm btn-primary" id="addRow">
                                    <i class="bi bi-plus-lg"></i> Add Item
                                </button>
                            </div>
                        </div>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                let table = document.getElementById("requisitionTable").getElementsByTagName("tbody")[0];
                                let totalAmountField = document.querySelector("input[name='amount_create']");

                                // Add new row
                                document.getElementById("addRow").addEventListener("click", function () {
                                    let rowCount = table.rows.length + 1;
                                    let newRow = table.insertRow();
                                    
                                    newRow.innerHTML = `
                                        <td>${rowCount}</td>
                                        <td><input type="text" class="form-control" name="CreateRequisitionTitle[]" required></td>
                                        <td>
                                            <select class="form-select" name="CreateRequisitionCategoryId[]" required>
                                                <option></option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select" name="CreateUom[]" required>
                                                <option></option>
                                                @foreach ($uoms as $uom)
                                                    <option value="{{ $uom->id }}">{{ $uom->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control qty_create" name="CreateQuantity[]" oninput="calculateRowAmount(this)" required></td>
                                        <td><input type="number" class="form-control unit-cost_create" name="CreateUnitCost[]" oninput="calculateRowAmount(this)" required></td>
                                        <td><input type="number" class="form-control amount_create" name="CreateTotal_amount[]" readonly></td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm removeRow"><i class="bi bi-trash"></i></button>
                                        </td>
                                    `;

                                    updateRowNumbers();
                                    calculateTotalAmount();
                                });

                                // Remove row
                                table.addEventListener("click", function (e) {
                                    if (e.target.closest(".removeRow")) {
                                        e.target.closest("tr").remove();
                                        updateRowNumbers();
                                        calculateTotalAmount();
                                    }
                                });

                                // Update row numbering
                                function updateRowNumbers() {
                                    let rows = table.getElementsByTagName("tr");
                                    for (let i = 0; i < rows.length; i++) {
                                        rows[i].cells[0].textContent = i + 1;
                                    }
                                }

                                // Calculate row amount and update total
                                window.calculateRowAmount = function (input) {
                                    let row = input.closest("tr");
                                    let qty = row.querySelector(".qty_create").value || 0;
                                    let unitCost = row.querySelector(".unit-cost_create").value || 0;
                                    let amountField = row.querySelector(".amount_create");
                                    amountField.value = (qty * unitCost).toFixed(2);
                                    calculateTotalAmount();
                                }

                                // Calculate total amount of all rows
                                function calculateTotalAmount() {
                                    let total = 0;
                                    let amounts = document.querySelectorAll(".amount_create");
                                    amounts.forEach(amount => {
                                        total += parseFloat(amount.value) || 0;
                                    });
                                    totalAmountField.value = total.toFixed(2);
                                }
                            });
                        </script>

                        <button type="reset" class="btn btn-light me-3" id="discardCategoryButton" data-bs-dismiss="modal">Discard</button>
                        <button id="submitRequisitionButton" type="submit" class="btn btn-primary" id>
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait... 
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>  


<script>
    const submitFormEntities = (formId, submitButtonId, url, method = 'POST') => {
        document.getElementById(formId).addEventListener('submit', function(e) {
            e.preventDefault();

            // Collect form data and add additional fields
            const formData = Object.fromEntries(new FormData(this));
            formData._method = method;
            formData.routeName = url;

            // Reference the submit button and reloading
            const submitButton = document.getElementById(submitButtonId);
            LiveBlade.toggleButtonLoading(submitButton, true);

            // Collecting array data manually
            let requisitionTitles = [];
            let requisitionCategoryIds = [];
            let uoms = [];
            let quantities = [];
            let unitCosts = [];
            let total_amounts = [];

            document.querySelectorAll("input[name='CreateRequisitionTitle[]']").forEach(input => {
                requisitionTitles.push(input.value);
            });

            document.querySelectorAll("select[name='CreateRequisitionCategoryId[]']").forEach(select => {
                requisitionCategoryIds.push(select.value);
            });

            document.querySelectorAll("select[name='CreateUom[]']").forEach(select => {
                uoms.push(select.value);
            });

            document.querySelectorAll("input[name='CreateQuantity[]']").forEach(input => {
                quantities.push(input.value);
            });

            document.querySelectorAll("input[name='CreateUnitCost[]']").forEach(input => {
                unitCosts.push(input.value);
            });

            document.querySelectorAll("input[name='CreateTotal_amount[]']").forEach(input => {
                total_amounts.push(input.value);
            });

            // append items
            formData.requisitionTitle = requisitionTitles;
            formData.requisitionCategoryId = requisitionCategoryIds;
            formData.uom = uoms;
            formData.quantity = quantities;
            formData.unitCost = unitCosts;
            formData.total_amount = total_amounts;

            console.log(formData);
            // Submit form data asynchronously
            LiveBlade.submitFormItems(formData)
                .then(noErrors => {
                    console.log(noErrors);
                    
                    if (noErrors) {
                        // Close the modal if no errors
                        const closeModal = () => {
                            document.getElementById('discardCategoryButton').click();
                        };
                        closeModal();
                    }
                })
                .catch(error => {
                    console.error('An unexpected error occurred:', error);
                })
                .finally(() => {
                    LiveBlade.toggleButtonLoading(submitButton, false);
                });

                
        });
    };

    submitFormEntities('kt_modal_add_requistion_form', 'submitRequisitionButton', '{{ route('requistion.store') }}');
</script>

