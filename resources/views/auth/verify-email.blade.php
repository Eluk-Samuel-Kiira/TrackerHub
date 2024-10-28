<x-guest-layout>
    @section('title', __('Verify Email'))
    @section('content')
    <div class="text-center mb-11">
        <div id="status"></div>
        <h1 class="text-gray-900 fw-bolder mb-3">{{__('Let\'s Verify Your Email ?')}}</h1>
        <div class="text-gray-500 fw-semibold fs-6">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>
    </div>

    <form class="form w-100" novalidate="novalidate" id="resend_link_form">
        @csrf
        <div class="d-grid mb-10">
            <button type="submit" class="btn btn-primary" id="submit-button">
                <span class="indicator-label">{{ __('Resend Verification Email') }}</span>
                <span class="indicator-progress" style="display: none;">{{__('Please wait... ')}}
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <div class="d-grid mb-10">
            <button type="submit" class="btn btn-secondary" id="submit-button">
                <span class="indicator-label">{{ __('Log Out') }}</span>
            </button>
        </div>
    </form>

    <script>
        // Laravel routes and form handling to be pass to js

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
                        // console.log(noErrors);
                        if (noErrors) {
                            
                        } else {
                            // Swal.fire({
                            //     icon: 'error',
                            //     title: 'Oops!',
                            //     text: 'Something Went Wrong',
                            //     confirmButtonText: 'Ok, got it!',
                            //     backdrop: true,
                            // });
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
        handleFormSubmit('resend_link_form', '/email/verification-notification', 'POST');
    </script>


    @endsection





    {{--
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif


    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
    --}}
</x-guest-layout>
