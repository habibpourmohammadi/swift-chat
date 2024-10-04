<div class="bg-gray-50 h-screen flex justify-center items-center">
    <form wire:submit='login'
        class="lg:w-2/5 md:w-2/3 w-full mx-5 lg:mx-auto border-2 border-gray-200 shadow-md px-10 py-6 rounded-lg">
        <div class="text-center text-xl">
            <h1>
                ورود به
                <span class="text-green-500">
                    سوئیفت
                </span>
                چت
            </h1>
        </div>
        <div class="border my-6 border-gray-200"></div>
        <x-auth.form.input wire:model="username" label="نام کاربری" id="username"
            placeholder="نام کاربری خود را وارد کنید ..." />
        <x-auth.form.input wire:model="password" type="password" label="رمز عبور" id="password"
            placeholder="رمز عبور خود را وارد کنید ..." />


        <x-auth.form.button label="ورود" />

        <div class="mt-2 text-center">
            <p class="text-xs">
                حساب کاربری ندارید؟
                <a href="{{ route('auth.register.page') }}" wire:navigate class="text-blue-600 hover:underline">
                    ایجاد حساب کاربری
                </a>
            </p>
        </div>
    </form>
</div>
