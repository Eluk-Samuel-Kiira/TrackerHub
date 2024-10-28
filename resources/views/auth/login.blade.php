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
            <button type="submit" class="btn btn-primary" id="submit-button">
                <span class="indicator-label">{{__('Sign In')}}</span>
                <span class="indicator-progress" style="display: none;">{{__('Please wait... ')}}
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>
    
        <script>
            const handleFormSubmit = (formId, routeName, method) => {
                document.getElementById(formId).addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = Object.fromEntries(new FormData(this));
                    // Append routeName, method, and formId to formData
                    formData.routeName = routeName;
                    formData.formId = `#${formId}`;
                    formData._method = method;

                    // console.log(formData)
                    
                    const submitButton = document.getElementById('submit-button');
                    submitButton.setAttribute('disabled', 'true'); 
                    submitButton.querySelector('.indicator-label').style.display = 'none'; 
                    submitButton.querySelector('.indicator-progress').style.display = 'inline'; 
                    setTimeout(() => {

                        LiveBlade.submitFormItems(formData).then(noErrors => {
                            console.log(noErrors);
                            if (noErrors) {
                                 // Show a success message using SweetAlert2
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'You have successfully logged in!',
                                    confirmButtonText: 'Ok, got it!',
                                    backdrop: true,
                                }).then(() => {
                                    window.location.href = '/dashboard'; // Redirect on button click
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops!',
                                    text: 'These credentials do not match our records.',
                                    confirmButtonText: 'Ok, got it!',
                                    backdrop: true,
                                });
                            }
                        }).catch(error => {
                            console.error('An unexpected error occurred:', error);
                        });

                        submitButton.removeAttribute('disabled'); 
                        submitButton.querySelector('.indicator-label').style.display = 'inline'; // Show the label
                        submitButton.querySelector('.indicator-progress').style.display = 'none'; // Hide the spinner
                    }, 2000);
                });
            };
            handleFormSubmit('kt_sign_in_form', '/login', 'POST');
        </script>
    @endsection


    {{--

        
    <!-- <div class="swal2-container swal2-center swal2-backdrop-show" style="overflow-y: auto;"><div aria-labelledby="swal2-title" aria-describedby="swal2-html-container" class="swal2-popup swal2-modal swal2-icon-success swal2-show" tabindex="-1" role="dialog" aria-live="assertive" aria-modal="true" style="display: grid;"><button type="button" class="swal2-close" style="display: none;" aria-label="Close this dialog">×</button><ul class="swal2-progress-steps" style="display: none;"></ul><div class="swal2-icon swal2-success swal2-icon-show" style="display: flex;"><div class="swal2-success-circular-line-left" style="background-color: rgb(21, 23, 28);"></div>
    <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>
    <div class="swal2-success-ring"></div> <div class="swal2-success-fix" style="background-color: rgb(21, 23, 28);"></div>
    <div class="swal2-success-circular-line-right" style="background-color: rgb(21, 23, 28);"></div>
    </div><img class="swal2-image" style="display: none;"><h2 class="swal2-title" id="swal2-title" style="display: none;"></h2><div class="swal2-html-container" id="swal2-html-container" style="display: block;">You have successfully logged in!</div><input class="swal2-input" style="display: none;"><input type="file" class="swal2-file" style="display: none;"><div class="swal2-range" style="display: none;"><input type="range"><output></output></div><select class="swal2-select" style="display: none;"></select><div class="swal2-radio" style="display: none;"></div><label for="swal2-checkbox" class="swal2-checkbox" style="display: none;"><input type="checkbox"><span class="swal2-label"></span></label><textarea class="swal2-textarea" style="display: none;"></textarea><div class="swal2-validation-message" id="swal2-validation-message" style="display: none;"></div><div class="swal2-actions" style="display: flex;"><div class="swal2-loader"></div><button type="button" class="swal2-confirm btn btn-primary" style="display: inline-block;" aria-label="">Ok, got it!</button><button type="button" class="swal2-deny" style="display: none;" aria-label="">No</button><button type="button" class="swal2-cancel" style="display: none;" aria-label="">Cancel</button></div><div class="swal2-footer" style="display: none;"></div><div class="swal2-timer-progress-bar-container"><div class="swal2-timer-progress-bar" style="display: none;"></div></div></div></div> -->
    
    <!-- <div class="swal2-container swal2-center swal2-backdrop-show" style="overflow-y: auto;"><div aria-labelledby="swal2-title" aria-describedby="swal2-html-container" class="swal2-popup swal2-modal swal2-icon-error swal2-show" tabindex="-1" role="dialog" aria-live="assertive" aria-modal="true" style="display: grid;"><button type="button" class="swal2-close" style="display: none;" aria-label="Close this dialog">×</button><ul class="swal2-progress-steps" style="display: none;"></ul><div class="swal2-icon swal2-error swal2-icon-show" style="display: flex;"><span class="swal2-x-mark">
    <span class="swal2-x-mark-line-left"></span>
    <span class="swal2-x-mark-line-right"></span>
    </span>
    </div><img class="swal2-image" style="display: none;"><h2 class="swal2-title" id="swal2-title" style="display: none;"></h2><div class="swal2-html-container" id="swal2-html-container" style="display: block;">Sorry, looks like there are some errors detected, please try again.</div><input class="swal2-input" style="display: none;"><input type="file" class="swal2-file" style="display: none;"><div class="swal2-range" style="display: none;"><input type="range"><output></output></div><select class="swal2-select" style="display: none;"></select><div class="swal2-radio" style="display: none;"></div><label for="swal2-checkbox" class="swal2-checkbox" style="display: none;"><input type="checkbox"><span class="swal2-label"></span></label><textarea class="swal2-textarea" style="display: none;"></textarea><div class="swal2-validation-message" id="swal2-validation-message" style="display: none;"></div><div class="swal2-actions" style="display: flex;"><div class="swal2-loader"></div><button type="button" class="swal2-confirm btn btn-primary" style="display: inline-block;" aria-label="">Ok, got it!</button><button type="button" class="swal2-deny" style="display: none;" aria-label="">No</button><button type="button" class="swal2-cancel" style="display: none;" aria-label="">Cancel</button></div><div class="swal2-footer" style="display: none;"></div><div class="swal2-timer-progress-bar-container"><div class="swal2-timer-progress-bar" style="display: none;"></div></div></div></div> -->

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
