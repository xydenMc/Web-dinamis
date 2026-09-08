<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= esc($title ?? 'Masuk - Griya Pot Bunga') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <style>
        @layer base {
            html,body{margin:0;padding:0;}
            body{overscroll-behavior:none;}
            main>:first-child{margin-top:0!important;}
            main>:last-child{margin-bottom:0!important;}
            ::-webkit-scrollbar{display:none;}
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary-container": "#c4e9cb",
                        "on-secondary-fixed": "#01210f",
                        "surface-variant": "#e5e2dd",
                        "on-primary-fixed-variant": "#822801",
                        "on-primary-container": "#fffbff",
                        "outline-variant": "#dec0b7",
                        "on-primary": "#ffffff",
                        "secondary-fixed-dim": "#abcfb2",
                        "surface-bright": "#fcf9f4",
                        "background": "#fcf9f4",
                        "tertiary-fixed": "#ffdcc3",
                        "secondary": "#45664e",
                        "surface-container-low": "#f6f3ee",
                        "on-primary-fixed": "#390c00",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "tertiary": "#825026",
                        "secondary-fixed": "#c7ecce",
                        "on-secondary-fixed-variant": "#2e4e37",
                        "on-error-container": "#93000a",
                        "surface": "#fcf9f4",
                        "on-secondary-container": "#496a52",
                        "error": "#ba1a1a",
                        "on-tertiary-container": "#fffbff",
                        "tertiary-fixed-dim": "#fbb985",
                        "primary": "#9f3c16",
                        "primary-fixed": "#ffdbcf",
                        "primary-fixed-dim": "#ffb599c",
                        "inverse-on-surface": "#f3f0eb",
                        "inverse-surface": "#31302d",
                        "surface-container": "#f0ede9",
                        "error-container": "#ffdad6",
                        "primary-container": "#bf542c",
                        "on-background": "#1c1c19",
                        "on-surface-variant": "#57423b",
                        "surface-container-highest": "#e5e2dd",
                        "on-tertiary-fixed-variant": "#693c13",
                        "tertiary-container": "#9e683c",
                        "on-surface": "#1c1c19",
                        "inverse-primary": "#ffb59c",
                        "surface-dim": "#dcdad5",
                        "on-error": "#ffffff",
                        "on-tertiary-fixed": "#2f1500",
                        "outline": "#8a726a",
                        "surface-container-high": "#ebe8e33",
                        "surface-tint": "#a23e18"
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                    spacing: {
                        "gutter-desktop": "2rem",
                        "space-xl": "2rem",
                        "space-2xl": "3rem",
                        "space-lg": "1.5rem",
                        "space-2xs": "0.25rem",
                        "space-md": "1rem",
                        "space-3xl": "4rem",
                        "gutter-mobile": "1rem",
                        "space-sm": "0.75rem",
                        "container-max": "1280px",
                        "space-xs": "0.5rem"
                    },
                    fontFamily: {
                        "label-md": ["Plus Jakarta Sans"],
                        "title-md": ["Plus Jakarta Sans"],
                        "display-lg": ["Plus Jakarta Sans"],
                        "body-md": ["Plus Jakarta Sans"],
                        "headline-xl": ["Plus Jakarta Sans"],
                        "title-lg": ["Plus Jakarta Sans"],
                        "body-lg": ["Plus Jakarta Sans"],
                        "display-lg-mobile": ["Plus Jakarta Sans"],
                        "headline-md": ["Plus Jakarta Sans"],
                        "label-sm": ["Plus Jakarta Sans"],
                        "headline-lg": ["Plus Jakarta Sans"]
                    },
                    fontSize: {
                        "label-md": ["13px", {lineHeight: "18px", letterSpacing: "0.01em", fontWeight: "500"}],
                        "title-md": ["16px", {lineHeight: "22px", fontWeight: "600"}],
                        "display-lg": ["48px", {lineHeight: "56px", letterSpacing: "-0.02em", fontWeight: "700"}],
                        "body-md": ["14px", {lineHeight: "22px", fontWeight: "400"}],
                        "headline-xl": ["36px", {lineHeight: "44px", letterSpacing: "-0.02em", fontWeight: "600"}],
                        "title-lg": ["18px", {lineHeight: "24px", fontWeight: "600"}],
                        "body-lg": ["16px", {lineHeight: "26px", fontWeight: "400"}],
                        "display-lg-mobile": ["32px", {lineHeight: "40px", letterSpacing: "-0.015em", fontWeight: "700"}],
                        "headline-md": ["22px", {lineHeight: "30px", letterSpacing: "-0.01em", fontWeight: "600"}],
                        "label-sm": ["11px", {lineHeight: "16px", letterSpacing: "0.04em", fontWeight: "600"}],
                        "headline-lg": ["28px", {lineHeight: "36px", letterSpacing: "-0.015em", fontWeight: "600"}]
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-background font-body-md text-on-surface min-h-screen relative flex items-center justify-center">
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-[10%] left-[20%] w-[500px] h-[500px] rounded-full bg-tertiary-fixed/30 blur-[140px]"></div>
        <div class="absolute bottom-[10%] right-[20%] w-[500px] h-[500px] rounded-full bg-secondary-fixed/30 blur-[140px]"></div>
    </div>

    <main class="relative z-10 w-full flex items-center justify-center p-space-md">
        <div class="flex flex-col w-full items-center justify-center relative py-space-xl">
            <!-- Ambient decorative orbs -->
            <div class="absolute -top-12 -left-16 w-80 h-80 rounded-full bg-primary-fixed/40 blur-[100px] pointer-events-none"></div>
            <div class="absolute -bottom-16 -right-12 w-88 h-88 rounded-full bg-secondary-fixed/50 blur-[110px] pointer-events-none"></div>

            <!-- Main Floating Liquid Glass Card -->
            <div class="relative w-full max-w-[480px] rounded-3xl bg-surface-container-lowest/65 backdrop-blur-[36px] shadow-2xl shadow-on-surface/10 p-space-xl md:p-space-2xl overflow-hidden transition-all duration-300 hover:shadow-primary/10">
                <!-- Specular Refraction Rim -->
                <div class="absolute inset-x-0 top-0 h-[1.5px] bg-gradient-to-r from-transparent via-surface-container-lowest/90 to-transparent"></div>
                <div class="absolute -right-20 -top-20 w-44 h-44 rounded-full bg-gradient-to-br from-surface-container-lowest/40 to-transparent blur-2xl pointer-events-none"></div>

                <!-- Header & Brand Mark -->
                <div class="flex flex-col items-center text-center mb-space-lg">
                    <div class="relative flex items-center justify-center w-16 h-16 rounded-2xl bg-surface-container-lowest/80 shadow-md shadow-primary/10 mb-space-sm overflow-hidden p-1.5 transition-transform duration-300 hover:scale-105">
                        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDpwvO9iQZ9lDuh8yr22477P8XcdNBR4_m47lhkSeptg4KRN1mKNgHUC_C-Bz_34DomPfduGCmd0dBQDdBwb6HwRI634h8GcBl0MOAjtwlq3cPBfwREhRDd-GQ5FEATZmEjJpkd-bGJX4j_R9lpdrVgHqRAECM9rEQ_3rztgRbmHcnjL3cwdaRkP6Hbuq_l8m0_jQSJiMii3Cg5FUnvJNIht8zg3HAffzEkU_1738FKJw5_qWc3_DHqLQ" alt="Griya Pot Bunga Logo" class="w-full h-full object-contain rounded-xl">
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-space-xs py-0.5 rounded-full bg-secondary-container/60 backdrop-blur-md mb-space-xs">
                        <span class="material-symbols-outlined text-secondary text-[14px]" style="font-variation-settings: 'FILL' 1;">eco</span>
                        <span class="font-label-sm text-label-sm text-on-secondary-fixed">Artisanal Pottery &amp; Botanicals</span>
                    </div>
                    <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Masuk ke Akun Anda</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">Selamat datang kembali di Griya Pot Bunga</p>
                </div>

                <!-- Flashdata Error -->
                <?php if (session()->get('error')): ?>
                    <div class="mb-4 p-3 rounded-full bg-red-100/60 text-red-700 font-label-sm text-label-sm text-center">
                        <?= esc(session()->get('error')) ?>
                    </div>
                <?php endif; ?>

                <!-- Card Note Akun Demo -->
                <div class="mb-space-md p-3.5 rounded-2xl bg-surface-container/80 border border-outline-variant/30 backdrop-blur-md shadow-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-primary text-[18px]">info</span>
                        <span class="font-title-md text-label-md text-on-surface font-semibold">Akun Demo (Klik untuk Auto-fill)</span>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <!-- Admin Pill -->
                        <button type="button" 
                                onclick="fillDemo('admin@gmail.com', 'admin123')" 
                                class="flex flex-col text-left p-2 rounded-xl bg-surface-container-lowest/60 hover:bg-primary/10 border border-transparent hover:border-primary/30 transition-all group">
                            <div class="flex items-center justify-between w-full">
                                <span class="font-label-sm text-xs font-bold text-primary group-hover:text-primary-container">1. Admin</span>
                                <span class="material-symbols-outlined text-xs text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity">content_paste</span>
                            </div>
                            <span class="font-body-md text-[11px] text-on-surface mt-0.5 truncate">admin@gmail.com</span>
                            <span class="font-body-md text-[11px] text-on-surface-variant">Pass: admin123</span>
                        </button>

                        <!-- Customer Pill -->
                        <button type="button" 
                                onclick="fillDemo('customer@gmail.com', 'customer123')" 
                                class="flex flex-col text-left p-2 rounded-xl bg-surface-container-lowest/60 hover:bg-secondary/10 border border-transparent hover:border-secondary/30 transition-all group">
                            <div class="flex items-center justify-between w-full">
                                <span class="font-label-sm text-xs font-bold text-secondary group-hover:text-on-secondary-container">2. Customer</span>
                                <span class="material-symbols-outlined text-xs text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity">content_paste</span>
                            </div>
                            <span class="font-body-md text-[11px] text-on-surface mt-0.5 truncate">customer@gmail.com</span>
                            <span class="font-body-md text-[11px] text-on-surface-variant">Pass: customer123</span>
                        </button>
                    </div>
                </div>

                <!-- Form Section -->
                <form class="flex flex-col gap-space-md" action="<?= base_url('/login/process') ?>" method="post" id="loginForm">
                    <?= csrf_field() ?>

                    <!-- Field: Username / Email -->
                    <div class="flex flex-col gap-space-2xs text-left">
                        <label class="font-label-md text-label-md text-on-surface-variant flex items-center gap-1.5" for="identity">
                            <span class="material-symbols-outlined text-[16px] text-primary">person</span>
                            Username atau Email
                        </label>
                        <div class="relative flex items-center">
                            <input class="w-full rounded-2xl bg-surface-container-lowest/50 backdrop-blur-md px-space-md py-3.5 font-body-md text-body-md text-on-surface placeholder:text-on-surface-variant/50 outline-none transition-all duration-200 focus:bg-surface-container-lowest/90 focus:shadow-md focus:shadow-primary/10 shadow-sm" id="identity" name="identity" value="<?= set_value('identity') ?>" placeholder="nama@email.com atau username" required type="text"/>
                        </div>
                    </div>

                    <!-- Field: Password -->
                    <div class="flex flex-col gap-space-2xs text-left">
                        <div class="flex items-center justify-between">
                            <label class="font-label-md text-label-md text-on-surface-variant flex items-center gap-1.5" for="password">
                                <span class="material-symbols-outlined text-[16px] text-primary">lock</span>
                                Kata Sandi
                            </label>
                        </div>
                        <div class="relative flex items-center">
                            <input class="w-full rounded-2xl bg-surface-container-lowest/50 backdrop-blur-md px-space-md py-3.5 pr-12 font-body-md text-body-md text-on-surface placeholder:text-on-surface-variant/50 outline-none transition-all duration-200 focus:bg-surface-container-lowest/90 focus:shadow-md focus:shadow-primary/10 shadow-sm" id="password" name="password" placeholder="••••••••" required type="password"/>
                            <button aria-label="Tampilkan atau sembunyikan password" class="absolute right-3 p-1.5 text-on-surface-variant hover:text-primary transition-colors flex items-center justify-center rounded-xl hover:bg-surface-container-high/40" type="button" id="togglePassword">
                                <span class="material-symbols-outlined text-[20px]" id="eyeIcon">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- Row: Remember me & Forgot Password -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                            <div class="relative flex items-center justify-center">
                                <input class="peer sr-only" id="rememberMe" name="remember" type="checkbox" value="1" <?= set_value('remember') ? 'checked' : '' ?>>
                                <div class="w-5 h-5 rounded-lg bg-surface-container-lowest/60 peer-checked:bg-primary transition-colors shadow-inner flex items-center justify-center">
                                    <span class="material-symbols-outlined text-on-primary text-[15px] opacity-0 peer-checked:opacity-100 transition-opacity font-bold">check</span>
                                </div>
                            </div>
                            <span class="font-label-md text-label-md text-on-surface">Ingat saya</span>
                        </label>
                        <a class="font-label-md text-label-md text-primary hover:text-primary-container transition-colors hover:underline" href="#lupa-password">
                            Lupa password?
                        </a>
                    </div>

                    <!-- Primary Action CTA -->
                    <button class="w-full relative mt-space-xs py-3.5 px-space-lg rounded-2xl bg-gradient-to-br from-primary-container via-primary to-tertiary font-title-md text-title-md text-on-primary shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2 overflow-hidden group" type="submit">
                        <div class="absolute inset-0 bg-surface-container-lowest/15 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <span class="relative z-10">Masuk Sekarang</span>
                        <span class="material-symbols-outlined relative z-10 text-[20px] transition-transform group-hover:translate-x-1">arrow_forward</span>
                    </button>
                </form>

                <!-- Visual Divider -->
                <div class="relative flex items-center my-space-lg">
                    <div class="flex-grow h-px bg-surface-variant/60"></div>
                    <span class="px-space-sm font-label-sm text-label-sm text-on-surface-variant/70 uppercase tracking-wider bg-transparent">atau masuk dengan</span>
                    <div class="flex-grow h-px bg-surface-variant/60"></div>
                </div>

                <!-- Quick Login Alternative Pills -->
                <div class="grid grid-cols-2 gap-space-sm mb-space-lg">
                    <button class="flex items-center justify-center gap-2 py-2.5 px-space-md rounded-2xl bg-surface-container-lowest/50 hover:bg-surface-container-lowest/80 shadow-sm transition-all duration-200 text-on-surface group" type="button" disabled>
                        <svg class="w-4 h-4 transition-transform group-hover:scale-110" viewBox="0 0 24 24">
                            <path d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17z" fill="#4285F4"></path>
                            <path d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z" fill="#34A853"></path>
                            <path d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z" fill="#FBBC05"></path>
                            <path d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z" fill="#EA4335"></path>
                        </svg>
                        <span class="font-label-md text-label-md">Google</span>
                    </button>
                    <button class="flex items-center justify-center gap-2 py-2.5 px-space-md rounded-2xl bg-surface-container-lowest/50 hover:bg-surface-container-lowest/80 shadow-sm transition-all duration-200 text-on-surface group" type="button" disabled>
                        <svg class="w-4 h-4 fill-current transition-transform group-hover:scale-110" viewBox="0 0 24 24">
                            <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.38c.62-.75 1.04-1.8 0.93-2.85-.9.04-1.98.6-2.61 1.34-.56.63-1.04 1.68-.91 2.69.99.08 2.01-.5 2.59-1.18z"></path>
                        </svg>
                        <span class="font-label-md text-label-md">Apple</span>
                    </button>
                </div>

                <!-- Registration Link -->
                <div class="mt-space-lg pt-space-md text-center">
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        Belum punya akun?
                        <a class="font-title-md text-title-md text-primary hover:text-primary-container font-semibold transition-colors hover:underline inline-flex items-center gap-0.5 ml-1" href="<?= base_url('/register') ?>">
                            Daftar sekarang
                        </a>
                    </p>
                </div>

                <!-- Flashdata Success -->
                <?php if (session()->get('success')): ?>
                    <div class="mb-4 p-3 rounded-full bg-green-100/60 text-green-700 font-label-sm text-label-sm text-center">
                        <?= esc(session()->get('success')) ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Footer Subtle Stamp -->
            <footer class="mt-space-lg text-center px-space-md">
                <p class="font-label-sm text-label-sm text-on-surface-variant/80 flex items-center justify-center gap-1.5 flex-wrap">
                    <span>© 2026 Griya Pot Bunga.</span>
                    <span class="inline-flex items-center text-primary">
                        <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">favorite</span>
                    </span>
                    <span>Dibuat untuk pencinta tanaman hias.</span>
                </p>
            </footer>
        </div>
    </main>

    <script>
        // Toggle Show/Hide Password
        (function() {
            const toggleBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (toggleBtn && passwordInput && eyeIcon) {
                toggleBtn.addEventListener('click', function() {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    eyeIcon.textContent = isPassword ? 'visibility_off' : 'visibility';
                });
            }
        })();

        // Function Auto-Fill Demo Credentials
        function fillDemo(identity, password) {
            const identityInput = document.getElementById('identity');
            const passwordInput = document.getElementById('password');

            if (identityInput && passwordInput) {
                identityInput.value = identity;
                passwordInput.value = password;
                
                // Memberikan efek visual fokus sebentar
                identityInput.focus();
                setTimeout(() => passwordInput.focus(), 150);
            }
        }
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .aspect-square {
            aspect-ratio: 1/1;
        }

        .aspect-video {
            aspect-ratio: 16/9;
        }

        .modal-overlay {
            background-color: rgba(58, 42, 32, 0.7);
            backdrop-filter: blur(4px);
            animation: fadeIn 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #f6f3ee;
            border: 2px solid #e5e2dd;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(58, 42, 32, 0.4);
            animation: slideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }
    </style>
</body>
</html>