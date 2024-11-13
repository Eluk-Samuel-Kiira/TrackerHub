<x-guest-layout>
    @section('title', __('Confirm Password'))
    @section('content')
    <div class="text-center mb-11">
        <div id="status"></div>
        <h1 class="text-gray-900 fw-bolder mb-3">{{__('Confirm Password')}}</h1>
        <div class="text-gray-500 fw-semibold fs-6">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>
    </div>

    <form class="form w-100" novalidate="novalidate" id="confirm_password_form">
        @csrf
        <div class="fv-row mb-3">
            <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
            <div id="password"></div>
        </div>
        <div class="d-grid mb-10">
            <button type="submit" class="btn btn-primary" id="submitButton">
                <span class="indicator-label">{{__('Confirm')}}</span>
                <span class="indicator-progress" style="display: none;">{{__('Please wait... ')}}
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>

    
    <script>
        // Laravel routes and form handling to be pass to js

        const handleFormSubmit = (formId, submitButtonId, routeName, method = 'POST') => {
            document.getElementById(formId).addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = Object.fromEntries(new FormData(this));
                // Append routeName, method, and formId to formData
                formData.routeName = routeName;
                formData.formId = `#${formId}`;
                formData._method = method;

                // console.log(formData)
                const submitButton = document.getElementById(submitButtonId);
                LiveBlade.toggleButtonLoading(submitButton, true);

                LiveBlade.submitFormItems(formData)
                .then(noErrors => {
                    console.log(noErrors);
                    
                    const alertOptions = noErrors
                        ? {
                            icon: 'success',
                            title: 'Success!',
                            text: 'Password Confirmed successfully!',
                            confirmButtonText: 'Ok, got it!',
                            backdrop: true
                        }
                        : {
                            icon: 'error',
                            title: 'Oops!',
                            text: 'The provided password is incorrect...',
                            confirmButtonText: 'Ok, got it!',
                            backdrop: true
                        };
                    
                    Swal.fire(alertOptions).then(() => {
                        if (noErrors) {
                            window.location.href = '/dashboard'; 
                        }
                    });
                })
                .catch(error => {
                    console.error('An unexpected error occurred:', error);
                })
                .finally(() => {
                    LiveBlade.toggleButtonLoading(submitButton, false);
                });
                
            });
        };
        handleFormSubmit('confirm_password_form', 'submitButton', '/confirm-password');
    </script>


    @endsection


    {{--
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
    --}}
</x-guest-layout>
