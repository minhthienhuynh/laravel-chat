@section('title', 'Log in')

@push('scripts')
    <!-- theme-style init -->
    @vite('resources/assets/js/pages/theme-style.init.js')

    <!-- Scripts -->
    @vite('resources/js/app.js')
@endpush

<x-chat-layout>
    @include('chat.auth.status-toast')

    <div class="auth-bg">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-xl-3 col-lg-4">
                    <div class="p-4 pb-0 p-lg-5 pb-lg-0 auth-logo-section">
                        <div class="text-white-50">
                            <h3><a href="{{ route('chat') }}" class="text-white"><i class="bx bxs-message-alt-detail align-middle text-white h3 mb-1 me-2"></i> Doot</a></h3>
                                <p class="font-size-16">Responsive Bootstrap 5 Chat App</p>
                        </div>
                        <div class="mt-auto">
                            <img src="{{ Vite::asset('resources/assets/images/auth-img.png') }}" alt="" class="auth-img">
                        </div>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-xl-9 col-lg-8">
                    <div class="authentication-page-content">
                        <div class="d-flex flex-column h-100 px-4 pt-4">
                            <div class="row justify-content-center my-auto">
                                <div class="col-sm-8 col-lg-6 col-xl-5 col-xxl-4">

                                    <div class="py-md-5 py-4">

                                        <div class="text-center mb-5">
                                            <h3>Welcome Back!</h3>
                                            <p class="text-muted">Sign in to continue to Doot.</p>
                                        </div>
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" placeholder="Enter email"
                                                       name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                                            </div>

                                            <div class="mb-3">
                                                @if (Route::has('password.request'))
                                                    <div class="float-end">
                                                        <a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a>
                                                    </div>
                                                @endif
                                                <label for="password" class="form-label">Password</label>
                                                <div class="position-relative auth-pass-inputgroup mb-3"
                                                     x-data="{ show: false }">
                                                    <input type="password" class="form-control pe-5" placeholder="Enter Password" id="password"
                                                           name="password" required autocomplete="current-password"
                                                           :type="show ? 'text' : 'password'">
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"
                                                            @click="show = ! show"><i class="ri-eye-fill align-middle"></i></button>
                                                </div>
                                            </div>

                                            <div class="form-check form-check-info font-size-16">
                                                <input class="form-check-input" type="checkbox" id="remember_me"
                                                       name="remember">
                                                <label class="form-check-label font-size-14" for="remember_me">
                                                    Remember me
                                                </label>
                                            </div>

                                            <div class="text-center mt-4">
                                                <button class="btn btn-primary w-100" type="submit">{{ __('Log In') }}</button>
                                            </div>
                                            {{--
                                            <div class="mt-4 text-center">
                                                <div class="signin-other-title">
                                                    <h5 class="font-size-14 mb-4 title">Sign in with</h5>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div>
                                                            <button type="button" class="btn btn-light w-100" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Facebook"><i class="mdi mdi-facebook text-indigo"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div>
                                                            <button type="button" class="btn btn-light w-100" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Google"><i class="mdi mdi-google text-danger"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            --}}
                                        </form><!-- end form -->

                                        <div class="mt-5 text-center text-muted">
                                            <p>Don't have an account? <a href="{{ route('register') }}" class="fw-medium text-decoration-underline"> Register</a></p>
                                        </div>
                                    </div>
                                </div><!-- end col -->
                            </div><!-- end row -->

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="text-center text-muted p-4">
                                        <p class="mb-0">&copy; <script>document.write(new Date().getFullYear())</script> Doot. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                                    </div>
                                </div><!-- end col -->
                            </div><!-- end row -->

                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end auth bg -->
</x-chat-layout>
