<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-extrabold text-slate-800">Đăng nhập</h1>
        <p class="mt-2 text-sm text-slate-500">
            Đăng nhập vào tài khoản Coop Shop để tiếp tục mua sắm.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email"
                          class="mt-1 block w-full"
                          type="email"
                          name="email"
                          :value="old('email')"
                          required
                          autofocus
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="'Mật khẩu'" />

            <x-text-input id="password"
                          class="mt-1 block w-full"
                          type="password"
                          name="password"
                          required
                          autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4 block">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me"
                       type="checkbox"
                       class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500"
                       name="remember">
                <span class="ms-2 text-sm text-slate-600">Ghi nhớ đăng nhập</span>
            </label>
        </div>

        <div class="mt-6 flex items-center justify-between gap-4">
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-green-600 underline hover:text-green-700"
                   href="{{ route('password.request') }}">
                    Quên mật khẩu?
                </a>
            @else
                <span></span>
            @endif

            <x-primary-button class="bg-green-600 hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:ring-green-500">
                Đăng nhập
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <div class="mt-6 text-center text-sm text-slate-600">
                Chưa có tài khoản?
                <a href="{{ route('register') }}" class="font-semibold text-green-600 hover:text-green-700">
                    Đăng ký ngay
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>