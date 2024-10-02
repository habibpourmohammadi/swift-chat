<div class="bg-gray-50 h-screen flex justify-center items-center">
    <form wire:submit='register' class="lg:w-2/5 md:w-2/3 w-full mx-5 lg:mx-auto border-2 border-gray-200 shadow-md px-10 py-6 rounded-lg">
        <div class="text-center text-xl">
            <h1>
                ثبت نام در
                <span class="text-green-500">
                    سوئیفت
                </span>
                چت
            </h1>
        </div>
        <div class="border my-6 border-gray-200"></div>
        <div class="grid md:grid-cols-2 md:gap-6">
            <x-auth.form.input wire:model="first_name" label="نام" id="first_name" placeholder="نام خود را وارد کنید ..." />
            <x-auth.form.input wire:model="last_name" label="نام خانوادگی" id="last_name"
                placeholder="نام خانوادگی خود را وارد کنید ..." />
        </div>

        <x-auth.form.input wire:model.live.debounce.250ms="mobile" type="number" label="تلفن همراه" id="mobile"
        placeholder="تلفن همراه خود را وارد کنید ..." />

        <x-auth.form.input wire:model.live.debounce.250ms="username" label="نام کاربری" id="username"
            placeholder="نام کاربری خود را وارد کنید ..." />
        <x-auth.form.input wire:model="password" type="password" label="رمز عبور" id="password"
            placeholder="رمز عبور خود را وارد کنید ..." />

        <x-auth.form.button label="ثبت نام" />
    </form>
</div>
