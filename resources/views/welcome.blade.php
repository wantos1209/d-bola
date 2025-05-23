<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* ! tailwindcss v3.4.1 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}:host,html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Figtree, ui-sans-serif, system-ui, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;font-feature-settings:normal;font-variation-settings:normal;-webkit-tap-highlight-color:transparent}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-feature-settings:normal;font-variation-settings:normal;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-feature-settings:inherit;font-variation-settings:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}dialog{padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]{display:none}*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }.absolute{position:absolute}.relative{position:relative}.-left-20{left:-5rem}.top-0{top:0px}.-bottom-16{bottom:-4rem}.-left-16{left:-4rem}.-mx-3{margin-left:-0.75rem;margin-right:-0.75rem}.mt-4{margin-top:1rem}.mt-6{margin-top:1.5rem}.flex{display:flex}.grid{display:grid}.hidden{display:none}.aspect-video{aspect-ratio:16 / 9}.size-12{width:3rem;height:3rem}.size-5{width:1.25rem;height:1.25rem}.size-6{width:1.5rem;height:1.5rem}.h-12{height:3rem}.h-40{height:10rem}.h-full{height:100%}.min-h-screen{min-height:100vh}.w-full{width:100%}.w-\[calc\(100\%\+8rem\)\]{width:calc(100% + 8rem)}.w-auto{width:auto}.max-w-\[877px\]{max-width:877px}.max-w-2xl{max-width:42rem}.flex-1{flex:1 1 0%}.shrink-0{flex-shrink:0}.grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}.flex-col{flex-direction:column}.items-start{align-items:flex-start}.items-center{align-items:center}.items-stretch{align-items:stretch}.justify-end{justify-content:flex-end}.justify-center{justify-content:center}.gap-2{gap:0.5rem}.gap-4{gap:1rem}.gap-6{gap:1.5rem}.self-center{align-self:center}.overflow-hidden{overflow:hidden}.rounded-\[10px\]{border-radius:10px}.rounded-full{border-radius:9999px}.rounded-lg{border-radius:0.5rem}.rounded-md{border-radius:0.375rem}.rounded-sm{border-radius:0.125rem}.bg-\[\#FF2D20\]\/10{background-color:rgb(255 45 32 / 0.1)}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gradient-to-b{background-image:linear-gradient(to bottom, var(--tw-gradient-stops))}.from-transparent{--tw-gradient-from:transparent var(--tw-gradient-from-position);--tw-gradient-to:rgb(0 0 0 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.via-white{--tw-gradient-to:rgb(255 255 255 / 0)  var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), #fff var(--tw-gradient-via-position), var(--tw-gradient-to)}.to-white{--tw-gradient-to:#fff var(--tw-gradient-to-position)}.stroke-\[\#FF2D20\]{stroke:#FF2D20}.object-cover{object-fit:cover}.object-top{object-position:top}.p-6{padding:1.5rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.py-10{padding-top:2.5rem;padding-bottom:2.5rem}.px-3{padding-left:0.75rem;padding-right:0.75rem}.py-16{padding-top:4rem;padding-bottom:4rem}.py-2{padding-top:0.5rem;padding-bottom:0.5rem}.pt-3{padding-top:0.75rem}.text-center{text-align:center}.font-sans{font-family:Figtree, ui-sans-serif, system-ui, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji}.text-sm{font-size:0.875rem;line-height:1.25rem}.text-sm\/relaxed{font-size:0.875rem;line-height:1.625}.text-xl{font-size:1.25rem;line-height:1.75rem}.font-semibold{font-weight:600}.text-black{--tw-text-opacity:1;color:rgb(0 0 0 / var(--tw-text-opacity))}.text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.underline{-webkit-text-decoration-line:underline;text-decoration-line:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.shadow-\[0px_14px_34px_0px_rgba\(0\2c 0\2c 0\2c 0\.08\)\]{--tw-shadow:0px 14px 34px 0px rgba(0,0,0,0.08);--tw-shadow-colored:0px 14px 34px 0px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.ring-1{--tw-ring-offset-shadow:var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow:var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)}.ring-transparent{--tw-ring-color:transparent}.ring-white\/\[0\.05\]{--tw-ring-color:rgb(255 255 255 / 0.05)}.drop-shadow-\[0px_4px_34px_rgba\(0\2c 0\2c 0\2c 0\.06\)\]{--tw-drop-shadow:drop-shadow(0px 4px 34px rgba(0,0,0,0.06));filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)}.drop-shadow-\[0px_4px_34px_rgba\(0\2c 0\2c 0\2c 0\.25\)\]{--tw-drop-shadow:drop-shadow(0px 4px 34px rgba(0,0,0,0.25));filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)}.transition{transition-property:color, background-color, border-color, fill, stroke, opacity, box-shadow, transform, filter, -webkit-text-decoration-color, -webkit-backdrop-filter;transition-property:color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;transition-property:color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-text-decoration-color, -webkit-backdrop-filter;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.duration-300{transition-duration:300ms}.selection\:bg-\[\#FF2D20\] *::selection{--tw-bg-opacity:1;background-color:rgb(255 45 32 / var(--tw-bg-opacity))}.selection\:text-white *::selection{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.selection\:bg-\[\#FF2D20\]::selection{--tw-bg-opacity:1;background-color:rgb(255 45 32 / var(--tw-bg-opacity))}.selection\:text-white::selection{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.hover\:text-black:hover{--tw-text-opacity:1;color:rgb(0 0 0 / var(--tw-text-opacity))}.hover\:text-black\/70:hover{color:rgb(0 0 0 / 0.7)}.hover\:ring-black\/20:hover{--tw-ring-color:rgb(0 0 0 / 0.2)}.focus\:outline-none:focus{outline:2px solid transparent;outline-offset:2px}.focus-visible\:ring-1:focus-visible{--tw-ring-offset-shadow:var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow:var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)}.focus-visible\:ring-\[\#FF2D20\]:focus-visible{--tw-ring-opacity:1;--tw-ring-color:rgb(255 45 32 / var(--tw-ring-opacity))}@media (min-width: 640px){.sm\:size-16{width:4rem;height:4rem}.sm\:size-6{width:1.5rem;height:1.5rem}.sm\:pt-5{padding-top:1.25rem}}@media (min-width: 768px){.md\:row-span-3{grid-row:span 3 / span 3}}@media (min-width: 1024px){.lg\:col-start-2{grid-column-start:2}.lg\:h-16{height:4rem}.lg\:max-w-7xl{max-width:80rem}.lg\:grid-cols-3{grid-template-columns:repeat(3, minmax(0, 1fr))}.lg\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}.lg\:flex-col{flex-direction:column}.lg\:items-end{align-items:flex-end}.lg\:justify-center{justify-content:center}.lg\:gap-8{gap:2rem}.lg\:p-10{padding:2.5rem}.lg\:pb-10{padding-bottom:2.5rem}.lg\:pt-0{padding-top:0px}.lg\:text-\[\#FF2D20\]{--tw-text-opacity:1;color:rgb(255 45 32 / var(--tw-text-opacity))}}@media (prefers-color-scheme: dark){.dark\:block{display:block}.dark\:hidden{display:none}.dark\:bg-black{--tw-bg-opacity:1;background-color:rgb(0 0 0 / var(--tw-bg-opacity))}.dark\:bg-zinc-900{--tw-bg-opacity:1;background-color:rgb(24 24 27 / var(--tw-bg-opacity))}.dark\:via-zinc-900{--tw-gradient-to:rgb(24 24 27 / 0)  var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from), #18181b var(--tw-gradient-via-position), var(--tw-gradient-to)}.dark\:to-zinc-900{--tw-gradient-to:#18181b var(--tw-gradient-to-position)}.dark\:text-white\/50{color:rgb(255 255 255 / 0.5)}.dark\:text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-white\/70{color:rgb(255 255 255 / 0.7)}.dark\:ring-zinc-800{--tw-ring-opacity:1;--tw-ring-color:rgb(39 39 42 / var(--tw-ring-opacity))}.dark\:hover\:text-white:hover{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:hover\:text-white\/70:hover{color:rgb(255 255 255 / 0.7)}.dark\:hover\:text-white\/80:hover{color:rgb(255 255 255 / 0.8)}.dark\:hover\:ring-zinc-700:hover{--tw-ring-opacity:1;--tw-ring-color:rgb(63 63 70 / var(--tw-ring-opacity))}.dark\:focus-visible\:ring-\[\#FF2D20\]:focus-visible{--tw-ring-opacity:1;--tw-ring-color:rgb(255 45 32 / var(--tw-ring-opacity))}.dark\:focus-visible\:ring-white:focus-visible{--tw-ring-opacity:1;--tw-ring-color:rgb(255 255 255 / var(--tw-ring-opacity))}}
            </style>
        @endif
        <style>
            .btn-submit {
                margin-top: 20px;
                border: 1px solid #000;
                border-radius: 8px;
                padding: 10px;
            }

            #resultDisplay, #countdownDisplay, #periodnoDisplay, #balanceDisplay, #messageDisplay {
                margin: 20px;
                padding: 10px;
                font-size: 20px;
            }

            .div-balance {
                display: flex;
            }

            .refreshButton {
                color: #fff;
                border: 1px solid #000;
                height: 10%;
                margin: auto;
                padding: 3px;
                border-radius: 8px;
                background: #8f2020;
            }
        </style>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="login" style="border: 1px solid #000; border-radius: 6px; padding: 20px">
            <div class="containterlogin">
                <div class="loginpart">
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="formlogin">
                            <div class="" style="display: flex; gap: 10px">
                                <p>CompanyKey : </p>
                                <input type="text" name="CompanyKey" placeholder="Company Key" style="border: 1px solid #000; border-radius: 6px; padding-left: 5px">
                            </div>
                            
                            <div class="" style="display: flex; gap: 10px; margin-top: 10px">
                                <p>Username :</p>
                                <input type="text" name="Username" placeholder="Username" style="border: 1px solid #000; border-radius: 6px; padding-left: 5px">
                            </div>
                            <button type="submit" class="refreshButton">Login</button>
                        </div>
                    </form>

                    <div class="" style="display: flex; gap: 10px; margin-top: 10px">
                        <p>Token Login :</p>
                        <div id="tokenLogin"> - </div>

                        <p style="display: block">Token Company :</p>
                        <div id="companyKey"> - </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="countdownDisplay">Waktu: 0</div>
        <div id="periodnoDisplay">Periodno: -</div>
        <div id="resultDisplay">Result: -</div>
        <button id="fetchButton" class="btn-submit">Submit Bet</button>
        <div class="div-balance">
            <div id="balanceDisplay">Balance: 0</div>
            <button id="refreshButton" class="refreshButton" >Refresh</button>
            {{-- <button id="loginButton" class="refreshButton" >Login</button> --}}
        </div>
        
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script>
            window.addEventListener('DOMContentLoaded', function() {
                console.log('Halaman dimuat');
        
                // Fetch balance pertama kali saat halaman dimuat
                fetchBalance();
        
                // Tombol refresh untuk mendapatkan balance terbaru
                const refreshButton = document.getElementById('refreshButton');
                refreshButton.addEventListener('click', function() {
                    fetchBalance();
                });
        
                try {
                    if (window.Echo) {
                        console.log('sudah masuk');
                        
                        // Listen untuk channel 'channel-name' dan event '.periodstart'
                        window.Echo.channel('channel-name').listen('.periodstart', (event) => {
                            console.log('Event diterima:', event);
                            
                            // Ambil data dari event
                            if (event && event.data) {
                                let statusBetValue = event.data.statusBet;
                                let resultValue = event.data.result;
        
                                // Jika statusBet adalah 'Result bet', tampilkan result, jika tidak, tampilkan 'Running'
                                if (statusBetValue === 'Result bet') {
                                    displayResult(resultValue); // Tampilkan result yang dikirim
                                } else if (statusBetValue === 'Open bet') {
                                    displayResult('Running'); // Tampilkan 'Running' jika status adalah 'Open bet'
                                }
                                
                                // Perbarui periodno dan countdown
                                let periodnoValue = event.data.periodno;
                                let countdownValue = event.data.countDown;
        
                                // Cek jika countdown null atau undefined, set ke 0
                                if (countdownValue === null || countdownValue === undefined) {
                                    countdownValue = 0;
                                }
        
                                // Update tampilan countdown dan periodno
                                updateCountdown(countdownValue);
                                updatePeriodno(periodnoValue);
                            }
                        });
        
                        // Listen untuk channel balance dan event .balanceuser
                        window.Echo.channel('channel-balance-Player01').listen('.balanceuser', (event) => {
                            console.log('Balance:', event);
        
                            // Menampilkan balance dari event
                            if (event && event.data) {
                                const balance = event.data.balance;
                                displayBalance(balance); // Tampilkan balance dari event
                            }
                        });
                    } else {
                        throw new Error('window.Echo tidak tersedia. Pastikan Laravel Echo sudah diimpor dan diinisialisasi dengan benar.');
                    }
                } catch (error) {
                    console.error('Error terjadi:', error.message);
                    console.error('Detail error:', error);
                }
        
                // Menghubungkan tombol untuk memicu postApiRequest
                const fetchButton = document.getElementById('fetchButton');
                fetchButton.addEventListener('click', function() {
                    // Gantilah periodno sesuai dengan nilai periodno yang sedang berjalan
                    const periodno = document.getElementById('periodnoDisplay').textContent.split(': ')[1] || 'P2501002291'; // Ambil periodno saat ini atau default
                    postApiRequest(periodno); // Panggil postApiRequest saat tombol diklik
                });
            });
        
            // Fungsi untuk memperbarui countdown di tampilan
            function updateCountdown(countdownValue) {
                const countdownDisplay = document.getElementById('countdownDisplay');
                if (countdownDisplay) {
                    countdownDisplay.textContent = `Waktu: ${countdownValue}`;
                }
            }
        
            // Fungsi untuk memperbarui periodno di tampilan
            function updatePeriodno(periodnoValue) {
                const periodnoDisplay = document.getElementById('periodnoDisplay');
                if (periodnoDisplay) {
                    periodnoDisplay.textContent = `Periodno: ${periodnoValue}`;
                }
            }
        
            // Fungsi untuk menampilkan result
            function displayResult(resultValue) {
                const resultDisplay = document.getElementById('resultDisplay');
                if (resultDisplay) {
                    resultDisplay.textContent = `Result: ${resultValue}`;
                }
            }
        
            // Fungsi untuk mengirimkan API request
            function postApiRequest(periodno) {
                const url = 'http://127.0.0.1:8005/api/processApi';
                const token = localStorage.getItem('loginToken');
                alert(periodno);
                const bodyData = {
                    periodno: periodno,
                    username: 'Player01',
                    mc: 0,
                    head_mc: 100,
                    body_mc: 100,
                    leg_mc: 100,
                    bm: 100,
                    head_bm: 100,
                    body_bm: 100,
                    leg_bm: 100,
                    gameId: 1
                };
        
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify(bodyData)
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.status === 'Success') {
                        displayMessage('Bet success fully');
                    } else if (data.status === 'Failed') {
                        console.log('Message:', data.message);
                        displayMessage(data.message);
                    } else {
                        console.log('Unknown status:', data.status);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    displayMessage('An error occurred while making the API request.');
                });
            }
        
            // Fungsi untuk menampilkan pesan hasil API
            function displayMessage(message) {
                const messageDisplay = document.getElementById('messageDisplay');
                if (messageDisplay) {
                    messageDisplay.textContent = message;
                }
            }
        
            // Fungsi untuk menampilkan balance
            function displayBalance(balanceValue) {
                const balanceDisplay = document.getElementById('balanceDisplay');
                if (balanceDisplay) {
                    balanceDisplay.textContent = `Balance: ${balanceValue}`;
                }
            }
        
            // Fungsi untuk mem-fetch balance dari API
            function fetchBalance() {
                // const url = 'https://bostoni.pro/api/GetBalance';
                const url = 'http://127.0.0.1:8006/api/GetBalance';
                const bodyData = {
                    "CompanyKey" : localStorage.getItem('companyKey'),
                    "Username": "Player01"
                };
        
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(bodyData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.ErrorCode === 0) {
                        console.log('Balance fetched:', data.Balance);
                        displayBalance(data.Balance); // Menampilkan balance dari API
                    } else {
                        console.log('Error fetching balance:', data.ErrorMessage);
                        displayBalance('Error fetching balance');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    displayBalance('Error fetching balance');
                });
            }

            $(document).ready(function () {
                // Cek apakah token sudah ada di localStorage
                const savedToken = localStorage.getItem('loginToken');
                const companyKeyToken = localStorage.getItem('companyKey');
                if (savedToken) {
                    $('#tokenLogin').text(savedToken);
                    $('#companyKey').text(companyKeyToken);
                }

                $('form').on('submit', function (e) {
                    e.preventDefault(); // mencegah form reload halaman

                    let companyKey = $('input[name="CompanyKey"]').val();
                    let username = $('input[name="Username"]').val();

                    $.ajax({
                        url: 'http://127.0.0.1:8005/api/login',
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer B03sT342Sdcs00Cse2cCKDk004492c',
                            'Content-Type': 'application/json'
                        },
                        data: JSON.stringify({
                            companyKey: companyKey,
                            username: username
                        }),
                        success: function (response) {
                            if (response.status === 'Success') {
                                let token = response.data.token;
                                $('#tokenLogin').text(token);
                                $('#companyKey').text(companyKey);

                                // Simpan token ke localStorage
                                localStorage.setItem('loginToken', token);
                                localStorage.setItem('companyKey', companyKey);
                            } else {
                                alert('Login gagal: ' + response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Gagal login:', xhr.responseText);
                            alert('Terjadi kesalahan saat login');
                        }
                    });
                });
            });
            
        </script>
        
    </body>
</html>
