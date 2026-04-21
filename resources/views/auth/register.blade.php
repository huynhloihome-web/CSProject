<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-extrabold text-slate-800">Đăng ký tài khoản</h1>
        <p class="mt-2 text-sm text-slate-500">
            Tạo tài khoản Coop Shop để mua sắm nhanh hơn.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="'Họ và tên'" />
            <x-text-input id="name"
                          class="mt-1 block w-full"
                          type="text"
                          name="name"
                          :value="old('name')"
                          required
                          autofocus
                          autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email"
                          class="mt-1 block w-full"
                          type="email"
                          name="email"
                          :value="old('email')"
                          required
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
                          autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="'Xác nhận mật khẩu'" />

            <x-text-input id="password_confirmation"
                          class="mt-1 block w-full"
                          type="password"
                          name="password_confirmation"
                          required
                          autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-6 flex items-center justify-between gap-4">
            <a class="text-sm font-medium text-green-600 underline hover:text-green-700"
               href="{{ route('login') }}">
                Đã có tài khoản?
            </a>

            <x-primary-button class="bg-green-600 hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:ring-green-500">
                Đăng ký
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>