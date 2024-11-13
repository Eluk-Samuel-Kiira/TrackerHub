<x-guest-layout>
    @section('title', __('Login Page'))
    @section('content')

    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
        @csrf
        <div class="text-center mb-11">
            <h1 class="text-gray-900 fw-bolder mb-3">{{__('Sign In')}}</h1>
            <div class="text-gray-500 fw-semibold fs-6">{{__('Enter Your Email And Password')}}</div>
        </div>
        <div class="fv-row mb-8">
            <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
            <div id="email"></div>
        </div>
        <div class="fv-row mb-3">
            <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
            <div id="password"></div>
        </div>
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>
            <a href="{{route('password.request')}}" class="link-primary">{{__('Forgot Password ?')}}</a>
        </div>
        <div class="d-grid mb-10">
            <button id="submitButton" type="submit" class="btn btn-primary">
                <span class="indicator-label">{{__('Sign In')}}</span>
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
                                    text: 'You have successfully logged in!',
                                    confirmButtonText: 'Ok, got it!',
                                    backdrop: true
                                }
                                : {
                                    icon: 'error',
                                    title: 'Oops!',
                                    text: 'These credentials do not match our records.',
                                    confirmButtonText: 'Ok, got it!',
                                    backdrop: true
                                };
                            
                            Swal.fire(alertOptions).then(() => {
                                if (noErrors) {
                                    window.location.href = '/dashboard'; // Redirect on success
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
            handleFormSubmit('kt_sign_in_form', 'submitButton', '{{ route('login') }}');
        </script>
    @endsection


    {{--

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    --}}
</x-guest-layout>
