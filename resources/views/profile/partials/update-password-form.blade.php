<section>
    

    <form id="updatePasswordForm">
        @csrf
        @method('put')
        <div class="mb-4">
            <label for="current-password" class="form-label">Current Password</label>
            <input type="password" id="update_password_current_password" name="current_password" class="form-control" />
            <div id="current_password"></div>
        </div>
        <div class="mb-4">
            <label for="new-password" class="form-label">New Password</label>
            <input type="password" id="update_password_password" name="password" class="form-control"/>
            <div id="password"></div>
        </div>
        <div class="mb-4">  
            <label for="confirm-password" class="form-label">Confirm Password</label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation"  class="form-control" />
            <div id="password_confirmation"></div>
        </div>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button id="submitPasswordButton" type="submit" class="btn btn-primary">
                <span class="indicator-label">Submit</span>
                <span class="indicator-progress" style="display: none;">
                    Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    </form>
    
</section>
