<x-guest-layout>
    <div class="flex flex-col gap-6">
        {{-- Identitas brand atas kartu --}}
        <div class="flex items-center gap-3 pb-5 border-b border-border-line/30">
            <img src="{{ asset('images/lambang-balikpapan.svg') }}" alt="Lambang Kota Balikpapan" class="h-11 w-11 object-contain">
            <div class="flex flex-col leading-tight">
                <span class="text-headline-sm font-bold text-dark tracking-tight">SIRAT</span>
                <span class="text-[11px] text-text-secondary">RT 02 Graha Indah</span>
            </div>
        </div>

        <div>
            <div class="inline-flex items-center gap-2 mb-2">
                <span class="text-mid font-label-section text-label-section uppercase">Masuk Akun</span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight leading-none mb-3">
                Selamat datang <br>
                <span class="font-serif italic text-mid font-normal">kembali</span>
            </h1>
            <p class="text-text-secondary text-body-md leading-relaxed">
                Gunakan email yang diberikan pengurus RT. Satu akun warga terhubung ke satu data anggota keluarga.
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4" id="form-masuk">
            @csrf

            <!-- Alamat email -->
            <div>
                <x-input-label for="email" :value="__('Alamat email')"/>
                <div class="relative mt-1.5">
                    <x-material-icon name="mail" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-text-secondary text-[18px]"/>
                    <x-text-input id="email" class="block w-full pl-10 pr-4 py-3 rounded-2xl border-border-line bg-surface-white text-sm"
                        type="email" name="email" :value="old('email')" required="required" autofocus="autofocus" autocomplete="username"
                        placeholder="nama@contoh.com"/>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            <!-- Kata sandi -->
            <div>
                <x-input-label for="password" :value="__('Kata sandi')"/>
                <div class="relative mt-1.5">
                    <x-material-icon name="lock" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-text-secondary text-[18px]"/>
                    <x-text-input id="password" class="block w-full pl-10 pr-4 py-3 rounded-2xl border-border-line bg-surface-white text-sm"
                        type="password" name="password" required="required" autocomplete="current-password"
                        placeholder="Minimal 8 karakter"/>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            <!-- Ingat saya + lupa sandi -->
            <div class="flex items-center justify-between gap-4">
                <label class="inline-flex items-center gap-2 text-xs text-text-secondary">
                    <input id="remember-me" type="checkbox" name="remember" class="rounded border-border-line text-dark focus:ring-lime">
                    Ingat saya di perangkat ini
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-dark hover:text-mid transition-colors">
                        Lupa kata sandi? <span class="inline-block">↗</span>
                    </a>
                @endif
            </div>

            <button type="submit"
                    class="relative w-full inline-flex items-center justify-center mt-2 px-14 py-3.5 rounded-full bg-lime text-dark text-headline-sm font-bold hover:bg-lime/90 transition-all active:scale-[0.98]">
                <span>Login</span>
                <span class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-dark text-lime flex items-center justify-center">↗</span>
            </button>
        </form>

        {{-- Info akses --}}
        <div class="bg-soft border border-border-line/40 rounded-2xl p-4 flex items-start gap-3">
            <x-material-icon name="info" class="text-mid text-base mt-0.5"/>
            <p class="text-xs text-text-secondary leading-relaxed">
                Belum punya akses? Hubungi pengurus RT untuk pendaftaran akun keluarga atau verifikasi NIK warga.
            </p>
        </div>

        <div class="pt-4 border-t border-border-line/30 flex items-center justify-between text-xs">
            <a href="{{ route('beranda') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-dark hover:text-mid transition-colors">← Kembali ke beranda</a>
            <span class="text-text-secondary/60">© {{ now()->year }} RT 02 Graha Indah</span>
        </div>
    </div>
</x-guest-layout>
