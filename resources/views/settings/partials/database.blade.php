<section>
    <div class="card-body border-top p-9 d-flex">
        <!-- Backup Section -->
        <div class="d-flex flex-column align-items-center pe-6" style="flex: 1; border-right: 1px solid #e0e0e0;">
            <div class="row mb-6">
                <label class="col-form-label fw-semibold fs-6">Database Backup</label>
                <div class="col">
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <form id="backupForm">
                            @csrf
                            <button type="button" onclick="databaseBackup('backup')" id="backupButton" class="btn btn-primary">
                                <span class="indicator-label">Backup</span>
                                <span class="indicator-progress" style="display: none;">
                                    Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Restore Section -->
        <div class="d-flex flex-column align-items-center ps-6" style="flex: 1;">
            <div class="row mb-6">
                <label class="col-form-label fw-semibold fs-6">Database Restore</label>
                <div class="col">
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <form id="restoreForm" method="POST" action="{{ route('database.restore') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="sql_file" accept=".sql" required class="form-control mb-3" />
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Restore</span>
                                <span class="indicator-progress" style="display: none;">
                                    Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    function databaseBackup(action) {
        // Reference the submit button and enable loading
        const submitButton = document.getElementById('backupButton');
        LiveBlade.toggleButtonLoading(submitButton, true);

        // Construct the dynamic URL
        const actionUrl = `/database/backup/${action}`;

        LiveBlade.actionDriven(actionUrl)
            .then(noErrors => {
                console.log(noErrors);
                if (noErrors) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'The database backup was successful.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: 'An unexpected error occurred. Please try again later.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error('An unexpected error occurred:', error);
            })
            .finally(() => {
                LiveBlade.toggleButtonLoading(submitButton, false);
            });
    }

</script>
