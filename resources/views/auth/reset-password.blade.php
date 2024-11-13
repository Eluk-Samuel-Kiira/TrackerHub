<x-guest-layout>
    @section('title', __('Reset Password'))
    @section('content')
    <div class="text-center mb-11">
        <h1 class="text-gray-900 fw-bolder mb-3">{{__('Reset Password')}}</h1>
        <div class="text-gray-500 fw-semibold fs-6">{{__('Lost Your Password? Never Worry, Just Enter New Password')}}</div>
    </div>

    <form class="form w-100" novalidate="novalidate" id="reset_password_form">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="fv-row mb-8">
            <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
            <div id="email"></div>
        </div>
        <div class="fv-row mb-3">
            <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
            <div id="password"></div>
        </div>
        <div class="fv-row mb-3">
            <input type="password" placeholder="Confirm Password" name="password_confirmation" autocomplete="off" class="form-control bg-transparent" />
            <div id="password_confirmation"></div>
        </div>
        <div class="d-grid mb-10">
            <button type="submit" class="btn btn-primary" id="submitButton">
                <span class="indicator-label">{{__('Reset Password')}}</span>
                <span class="indicator-progress" style="display: none;">{{__('Please wait... ')}}
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>
    <script>
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
                                text: 'You have successfully reset your password!',
                                confirmButtonText: 'Ok, got it!',
                                backdrop: true
                            }
                            : {
                                icon: 'error',
                                title: 'Oops!',
                                text: 'Something Has Gone Wrong.',
                                confirmButtonText: 'Ok, got it!',
                                backdrop: true
                            };
                        
                        Swal.fire(alertOptions).then(() => {
                            if (noErrors) {
                                window.location.href = '/login'; // Redirect on success
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
        handleFormSubmit('reset_password_form', 'submitButton', '{{ route('password.store') }}');
    </script>

    @endsection
    {{--
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
    --}}
</x-guest-layout>
