@section('title', 'Reset Password')

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
                                            <h3>Reset Password</h3>
                                            <p class="text-muted">Reset Password with Doot.</p>
                                        </div>
                                        <div class="alert alert-info text-center my-4" role="alert">
                                            Enter your Email and instructions will be sent to you!
                                        </div>
                                        <form method="POST" action="{{ route('password.email') }}">
                                            @csrf

                                            <div class="mb-4">
                                                <label class="form-label">{{ __('Email') }}</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter email"
                                                       name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="text-center mt-4">
                                                <button class="btn btn-primary w-100" type="submit">Reset</button>
                                            </div>
                                        </form><!-- end form -->

                                        <div class="mt-5 text-center text-muted">
                                            <p>Remember It? <a href="{{ route('login') }}" class="fw-medium text-decoration-underline"> Login</a></p>
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
