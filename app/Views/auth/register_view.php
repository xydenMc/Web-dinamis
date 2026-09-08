<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= esc($title ?? 'Daftar Akun Baru - Griya Pot Bunga') ?></title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet" />

    <!-- Tailwind CSS v3 with Plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        terracotta: {
                            50: '#fdf6f3',
                            100: '#f9ece5',
                            200: '#f2d7ca',
                            300: '#e7bba6',
                            400: '#d99778',
                            500: '#c85a32',
                            /* Brand primary */
                            600: '#b84924',
                            700: '#9b391c',
                            800: '#7e301b',
                            900: '#672a19',
                            950: '#38130a',
                        },
                        warmclay: '#e8dbd1',
                        botanical: '#2e5a44'
                    },
                    boxShadow: {
                        'glass': '0 30px 60px -15px rgba(110, 50, 25, 0.12), 0 10px 25px -5px rgba(0, 0, 0, 0.05), inset 0 1px 1px 0 rgba(255, 255, 255, 0.8)',
                        'glass-inset': 'inset 0 1px 3px 0 rgba(0, 0, 0, 0.04), inset 0 0 0 1px rgba(255, 255, 255, 0.6)',
                        'terracotta-glow': '0 12px 28px -6px rgba(200, 90, 50, 0.38), 0 4px 12px -2px rgba(200, 90, 50, 0.22)',
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS for Liquid Glass Styles -->
    <style data-purpose="liquid-glass-effects">
        .liquid-glass-card {
            background: rgba(255, 255, 255, 0.60);
            backdrop-filter: blur(28px) saturate(190%);
            -webkit-backdrop-filter: blur(28px) saturate(190%);
            border: 1px solid rgba(255, 255, 255, 0.75);
        }

        .liquid-glass-input {
            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(220, 210, 202, 0.65);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .liquid-glass-input:focus {
            background: rgba(255, 255, 255, 0.90);
            border-color: #c85a32;
            box-shadow: 0 0 0 3.5px rgba(200, 90, 50, 0.18), inset 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .liquid-glass-btn {
            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.85);
            transition: all 0.2s ease;
        }

        .liquid-glass-btn:hover {
            background: rgba(255, 255, 255, 0.88);
            transform: translateY(-1px);
        }
    </style>
</head>

<body class="min-h-screen bg-[#faf6f0] text-stone-800 font-sans antialiased selection:bg-terracotta-200 selection:text-terracotta-900 relative overflow-x-hidden flex flex-col justify-between">

    <!-- Ambient Background Light Orbs -->
    <div aria-hidden="true" class="fixed inset-0 pointer-events-none -z-10 overflow-hidden">
        <div class="absolute -top-[18%] -left-[10%] w-[580px] h-[580px] rounded-full bg-gradient-to-br from-[#edd5c4]/60 to-[#f6ebe1]/40 blur-3xl opacity-75"></div>
        <div class="absolute top-[35%] -right-[12%] w-[620px] h-[620px] rounded-full bg-gradient-to-bl from-[#dfcfc2]/50 via-[#f1dfd4]/40 to-transparent blur-3xl opacity-80"></div>
        <div class="absolute -bottom-[15%] left-[25%] w-[520px] h-[520px] rounded-full bg-gradient-to-tr from-[#ead7c7]/50 via-[#f8eee5]/50 to-transparent blur-3xl opacity-70"></div>
    </div>

    <main class="flex-1 flex items-center justify-center px-4 py-10 sm:py-14">
        <div class="w-full max-w-[500px] liquid-glass-card rounded-[2.25rem] shadow-glass p-7 sm:p-10 relative transition-all duration-300">

            <!-- Brand Header -->
            <header class="flex flex-col items-center text-center mb-7">
                <div class="w-20 h-20 mb-3.5 rounded-2xl bg-white/70 p-2 border border-white/80 shadow-sm flex items-center justify-center transition-transform hover:scale-105 duration-300">
                    <img alt="Logo Griya Pot Bunga" class="w-full h-full object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDpwvO9iQZ9lDuh8yr22477P8XcdNBR4_m47lhkSeptg4KRN1mKNgHUC_C-Bz_34DomPfduGCmd0dBQDdBwb6HwRI634h8GcBl0MOAjtwlq3cPBfwREhRDd-GQ5FEATZmEjJpkd-bGJX4j_R9lpdrVgHqRAECM9rEQ_3rztgRbmHcnjL3cwdaRkP6Hbuq_l8m0_jQSJiMii3Cg5FUnvJNIht8zg3HAffzEkU_1738FKJw5_qWc3_DHqLQ" onerror="this.onerror=null; this.parentElement.innerHTML='<span class=\'text-4xl\'>🏺</span>';" />
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50/80 border border-emerald-200/60 text-emerald-800 text-[11px] font-semibold tracking-wide uppercase mb-3">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15-4-4 1.41-1.41L11 14.17l6.59-6.59L19 9l-8 8z"></path>
                    </svg>
                    <span>Artisanal Pottery &amp; Botanicals</span>
                </div>
                <h1 class="text-2xl sm:text-[1.75rem] font-extrabold tracking-tight text-stone-900 leading-snug">
                    Daftar Akun Baru
                </h1>
                <p class="text-xs sm:text-sm text-stone-500 mt-1 max-w-xs leading-relaxed">
                    Bergabung bersama komunitas pecinta tanaman hias &amp; gerabah artisan Griya Pot Bunga
                </p>
            </header>

            <!-- Notification Alerts (CodeIgniter Flashdata) -->
            <?php if (session()->get('error')) : ?>
                <div class="mb-4 p-3.5 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-700 text-xs font-medium">
                    <?= esc(session()->get('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->get('errors')) : ?>
                <div class="mb-4 p-3.5 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-700 text-xs font-medium space-y-1">
                    <?php foreach (session()->get('errors') as $error) : ?>
                        <div><?= esc($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (session()->get('success')) : ?>
                <div class="mb-4 p-3.5 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-800 text-xs font-medium">
                    <?= esc(session()->get('success')) ?>
                </div>
            <?php endif; ?>

            <!-- Form Register -->
            <form action="<?= base_url('/register/process') ?>" method="POST" class="space-y-4" id="register-form">
                <?= csrf_field() ?>

                <!-- Field 1: Username -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-stone-700 tracking-wide" for="username">
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-terracotta-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            Username
                        </span>
                    </label>
                    <div class="relative">
                        <input class="liquid-glass-input w-full px-4 py-2.5 rounded-xl text-stone-900 text-sm placeholder:text-stone-400 focus:outline-none" id="username" name="username" value="<?= old('username') ?>" placeholder="Contoh: budisentosa" required minlength="3" maxlength="50" type="text" />
                    </div>
                    <?php if (session('errors.username')) : ?>
                        <div class="text-red-600 text-xs font-medium pl-1"><?= esc(session('errors.username')) ?></div>
                    <?php endif; ?>
                </div>

                <!-- Field 2: Email -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-stone-700 tracking-wide" for="email">
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-terracotta-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            Email
                        </span>
                    </label>
                    <div class="relative">
                        <input class="liquid-glass-input w-full px-4 py-2.5 rounded-xl text-stone-900 text-sm placeholder:text-stone-400 focus:outline-none" id="email" name="email" value="<?= old('email') ?>" placeholder="nama@email.com" required type="email" />
                    </div>
                    <?php if (session('errors.email')) : ?>
                        <div class="text-red-600 text-xs font-medium pl-1"><?= esc(session('errors.email')) ?></div>
                    <?php endif; ?>
                </div>

                <!-- Field 3: Password -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-stone-700 tracking-wide" for="password">
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-terracotta-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            Kata Sandi
                        </span>
                    </label>
                    <div class="relative flex items-center">
                        <input class="liquid-glass-input w-full pl-4 pr-11 py-2.5 rounded-xl text-stone-900 text-sm placeholder:text-stone-400 focus:outline-none" id="password" name="password" placeholder="Minimal 6 karakter" required minlength="6" type="password" />
                        <button aria-label="Tampilkan atau sembunyikan kata sandi" class="absolute right-3.5 text-stone-400 hover:text-stone-700 focus:outline-none" id="toggle-password" type="button">
                            <svg class="w-4 h-4" fill="none" id="eye-icon-password" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>
                    <?php if (session('errors.password')) : ?>
                        <div class="text-red-600 text-xs font-medium pl-1"><?= esc(session('errors.password')) ?></div>
                    <?php endif; ?>
                </div>

                <!-- Field 4: Confirm Password -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-stone-700 tracking-wide" for="confirm_password">
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-terracotta-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            Konfirmasi Kata Sandi
                        </span>
                    </label>
                    <div class="relative flex items-center">
                        <input class="liquid-glass-input w-full pl-4 pr-11 py-2.5 rounded-xl text-stone-900 text-sm placeholder:text-stone-400 focus:outline-none" id="confirm_password" name="confirm_password" placeholder="Ketik ulang kata sandi" required type="password" />
                        <button aria-label="Tampilkan atau sembunyikan konfirmasi kata sandi" class="absolute right-3.5 text-stone-400 hover:text-stone-700 focus:outline-none" id="toggle-confirm-password" type="button">
                            <svg class="w-4 h-4" fill="none" id="eye-icon-confirm" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>
                    <?php if (session('errors.confirm_password')) : ?>
                        <div class="text-red-600 text-xs font-medium pl-1"><?= esc(session('errors.confirm_password')) ?></div>
                    <?php endif; ?>
                </div>

                <!-- Checkbox Terms -->
                <div class="pt-1 flex items-start space-x-2.5">
                    <input class="h-4 w-4 mt-0.5 rounded border-stone-300 text-terracotta-600 focus:ring-terracotta-500/40 cursor-pointer bg-white/70" id="terms" name="terms" required type="checkbox" />
                    <label class="text-xs text-stone-600 leading-tight select-none" for="terms">
                        Saya menyetujui <a class="font-medium text-terracotta-600 hover:underline" href="#">Syarat &amp; Ketentuan</a> serta <a class="font-medium text-terracotta-600 hover:underline" href="#">Kebijakan Privasi</a> Griya Pot Bunga.
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button class="w-full py-3 px-6 rounded-2xl bg-gradient-to-r from-[#c85a32] via-[#bd4e27] to-[#a23e1c] text-white font-semibold text-sm tracking-wide shadow-terracotta-glow hover:brightness-105 active:scale-[0.99] transition duration-200 flex items-center justify-center gap-2 group cursor-pointer" type="submit">
                        <span>Register Sekarang</span>
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Social Registration -->
            <div class="mt-6">
                <div class="relative flex items-center justify-center my-4">
                    <div class="border-t border-stone-300/60 w-full"></div>
                    <span class="bg-[#f6eee5]/90 px-3 text-[11px] font-semibold uppercase tracking-wider text-stone-600 rounded-full border border-stone-200/50 absolute">
                        Atau daftar dengan
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-3 mt-5">
                    <button class="liquid-glass-btn flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-stone-700 text-xs font-semibold shadow-sm cursor-pointer" type="button">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24">
                            <path d="M12 5c1.6 0 3 .6 4.1 1.7l3.1-3.1C17.3 1.8 14.8 1 12 1 7.5 1 3.7 3.6 1.9 7.3l3.7 2.9C6.5 7.4 9 5 12 5z" fill="#EA4335"></path>
                            <path d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.8z" fill="#4285F4"></path>
                            <path d="M5.6 14.8c-.2-.7-.4-1.5-.4-2.8s.2-2.1.4-2.8L1.9 6.3C.7 8.7 0 10.3 0 12s.7 3.3 1.9 5.7l3.7-2.9z" fill="#FBBC05"></path>
                            <path d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3 0-5.5-2-6.4-4.8L1.9 16.4C3.7 20.1 7.5 23 12 23z" fill="#34A853"></path>
                        </svg>
                        <span>Google</span>
                    </button>
                    <button class="liquid-glass-btn flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-stone-700 text-xs font-semibold shadow-sm cursor-pointer" type="button">
                        <svg class="w-4 h-4 shrink-0 fill-current text-stone-900" viewBox="0 0 24 24">
                            <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.37c.62-.75 1.04-1.8 0.93-2.85-.9.04-2 .6-2.65 1.35-.58.66-1.09 1.73-.95 2.76 1.01.08 2.05-.51 2.67-1.26z"></path>
                        </svg>
                        <span>Apple</span>
                    </button>
                </div>
            </div>

            <!-- Login Link -->
            <footer class="mt-7 text-center">
                <p class="text-xs text-stone-600">
                    Sudah punya akun?
                    <a class="font-bold text-terracotta-600 hover:text-terracotta-700 transition hover:underline" href="<?= base_url('/login') ?>">
                        Masuk sekarang
                    </a>
                </p>
            </footer>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-5 text-center text-xs text-stone-500 tracking-wide border-t border-stone-200/40 bg-stone-100/30 backdrop-blur-md">
        <div class="max-w-md mx-auto px-4 flex items-center justify-center gap-1.5">
            <span>© <?= date('Y') ?> Griya Pot Bunga. Dibuat dengan</span>
            <span aria-label="cinta" class="text-red-500 animate-pulse">❤️</span>
            <span>untuk pencinta tanaman hias.</span>
        </div>
    </footer>

    <!-- Interactive Password Visibility Toggle -->
    <script data-purpose="password-visibility-toggle">
        function setupPasswordToggle(toggleBtnId, inputId, eyeIconId) {
            const toggleBtn = document.getElementById(toggleBtnId);
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(eyeIconId);

            if (!toggleBtn || !input || !eyeIcon) return;

            toggleBtn.addEventListener('click', () => {
                const isPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPassword ? 'text' : 'password');

                if (isPassword) {
                    eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
          `;
                    toggleBtn.classList.add('text-terracotta-600');
                    toggleBtn.classList.remove('text-stone-400');
                } else {
                    eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
          `;
                    toggleBtn.classList.remove('text-terracotta-600');
                    toggleBtn.classList.add('text-stone-400');
                }
            });
        }

        setupPasswordToggle('toggle-password', 'password', 'eye-icon-password');
        setupPasswordToggle('toggle-confirm-password', 'confirm_password', 'eye-icon-confirm');
    </script>
</body>

</html>