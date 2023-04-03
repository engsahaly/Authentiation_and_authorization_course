@section('title', 'Front Forget Password Page')

<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets-front') }}/" data-template="vertical-menu-template-free">

@include('front.partials.authHead')

<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Forgot Password -->
                <div class="card">
                    <div class="card-body">
                        @include('front.partials.authLogo')

                        <h4 class="mb-2">Forgot Password? 🔒</h4>
                        <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
                        <form id="formAuthentication" class="mb-3" action="index.html" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" autofocus />
                            </div>
                            <button class="btn btn-primary d-grid w-100">Send Reset Link</button>
                        </form>
                        <div class="text-center">
                            <a href="auth-login-basic.html" class="d-flex align-items-center justify-content-center">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                Back to login
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password -->
            </div>
        </div>
    </div>
    <!-- / Content -->

    @include('front.partials.authScripts')
</body>

</html>
