<section>
    <form id="updateSMTPForm" class="form">
        @csrf
        @method('patch')
        <div class="card-body border-top p-9">
            <div class="row">
                <!-- Column 1 -->
                <div class="col-lg-6">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail Mailer</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="mail_mailer" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{ $app_info->mail_mailer }}" />
                                    <div id="mail_mailer"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail Host</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="mail_host" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{ $app_info->mail_host }}" />
                                    <div id="mail_host"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail Name</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="mail_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{ $app_info->mail_name }}" />
                                    <div id="mail_name"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail Host</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="mail_password" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{ $app_info->mail_password }}" />
                                    <div id="mail_password"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Column 2 -->
                <div class="col-lg-6">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail Port</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="mail_port" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{ $app_info->mail_port }}" />
                                    <div id="mail_port"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail Username</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="mail_username" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{ $app_info->mail_username }}" />
                                    <div id="mail_username"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail Address</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <input type="text" name="mail_address" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" value="{{ $app_info->mail_address }}" />
                                    <div id="mail_address"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Mail Status</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 fv-row">
                                    <select name="mail_status" class="form-control" id="mail_status">
                                        <option value="enabled" {{ $app_info->mail_status == 'enabled' ? 'selected' : '' }}>Enabled</option>
                                        <option value="disabled" {{ $app_info->mail_status == 'disabled' ? 'selected' : '' }}>Disabled</option>
                                    </select>
                                    <div id="mail_status"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button id="submitupdateSMTP" type="submit" class="btn btn-primary">
                <span class="indicator-label">Submit</span>
                <span class="indicator-progress" style="display: none;">
                    Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    </form>
</section>
