<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('login') }}">
        @csrf
                <div class="form-group">
                    <input type="email" id='email' name='email' class="form-control" placeholder="Enter your username" :value="old('email')">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div><!-- form-group -->
                <div class="form-group">
                    <input type="password" id="password" name='password' class="form-control" placeholder="Enter your password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    @if (Route::has('password.request'))
                        <a class="tx-info tx-12 d-block mg-t-10" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div><!-- form-group -->
               
                <button type="submit" class="btn btn-info btn-block" style='background:#37a000;'>
                    {{ __('Log in') }}
                </button>

                <label for="remember_me" class="inline-flex items-center" style='margin-top: 15px;'>
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                <div class="mg-t-60 tx-center">Not yet a member? <a href="" class="tx-info">Sign Up</a></div>

    </form>
</x-guest-layout>
