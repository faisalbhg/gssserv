<section>
    <div class="page-header section-height-75">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                    <div class="card card-plain mt-6">
                        <div class="card-header pb-0 text-left bg-transparent">
                            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3" href="{{ route('dashboard') }}">
                                <img src="{{asset('img/logos/gss-logo.svg')}}" width="200">
                            </a>
                            <h3 class="font-weight-bolder text-primary text-gradient mt-6">{{ __('Welcome back') }}</h3>
                            
                            <p class="mb-0 mt-2">{{__('Sign in with the credentials:') }}</p>
                            
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="login" action="#" method="POST" role="form text-left" autocomplete="off">
                                <div class="mb-3">
                                    <label for="email">{{ __('Email') }}</label>
                                    <div class="@error('email')border border-danger rounded-3 @enderror">
                                        <div wire:ignore>
                                        <input wire:model.defer="email" id="email" type="text" class="form-control"
                                            placeholder="Email" aria-label="Email" aria-describedby="email-addon" autocomplete="false">
                                        </div>
                                    </div>
                                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password">{{ __('Password') }}</label>
                                    <div class="@error('password')border border-danger rounded-3 @enderror">
                                        <input wire:model.defer="password" id="password" type="password" class="form-control"
                                            placeholder="Password" aria-label="Password"
                                            aria-describedby="password-addon" autocomplete="new-password">
                                    </div>
                                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-check form-switch">
                                    <input wire:model="remember_me" class="form-check-input" type="checkbox"
                                        id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">{{ __('Remember me') }}</label>
                                </div>
                                <div class="text-center">
                                    <button type="submit"
                                        class="btn bg-gradient-primary w-100 mt-4 mb-0">{{ __('Sign in') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center pt-0 px-lg-2 px-1 mt-2 mb-2">
                            <small class="text-muted">{{ __('Forgot you password? Reset you password') }} <a
                                    href="{{ route('forgot-password') }}"
                                    class="text-primary text-gradient font-weight-bold">{{ __('here') }}</a></small>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                        <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                            style="background-image:url('{{ asset("img/curved-images/curved11.jpg")}}')"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[type="email"]').forEach(function(input) {
            input.setAttribute('autocomplete', 'off');
        });
    });
</script>