<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/utama/g21-icon.ico') }}" />
    <title>Dashboard | L21</title>
    <link rel="stylesheet" href="/assets/style.css" />
    <link rel="stylesheet" href="/assets/design.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            adjustElementSize();
        });
    </script>

    <link href="/assets/select-assets/select2.min.css" rel="stylesheet" />
    <script src="/assets/select-assets/select2.min.js"></script>

    <style>
       /* Kotak input Select2 */
        .select2-container .select2-selection--single {
            background: rgba(var(--rgba-black), 0.3) !important; 
            color: rgba(var(--rgba-white)) !important;
            border: transparent !important;
            border-radius: 8px !important;
            height: 20px !important;
            display: flex !important;
            align-items: center !important;
            padding: 0px 0px !important;
        }

        /* Teks dalam Select2 */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: rgba(var(--rgba-white)) !important;
            padding-left: 12px !important;
            line-height: 42px !important;
        }

        /* Panah dropdown */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
            right: 10px !important;
        }

        /* Dropdown hasil */
        .select2-container--default .select2-results > .select2-results__options {
            background: rgba(var(--rgba-black), 0.3) !important;
            border: var(--border-primary) !important;
            border-top: none !important;
            border-radius: 0 0 8px 8px !important;
            font-size: 12px !important;
        }

        /* Item yang sedang dipilih di dropdown */
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            color: rgba(var(--rgba-white)) !important;
        }

        /* Item yang sudah terpilih */
        .select2-container--default .select2-results__option[aria-selected=true] {
            color: rgba(var(--rgba-white)) !important;
            font-size: 12px !important;
        }

        .select2-search__field {
            background-color: rgba(var(--rgba-black), 0.3) !important; 
            border: var(--border-primary) !important;
            border-radius: 4px !important;
            color: rgba(var(--rgba-white)) !important;
            font-size: 12px !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: var(--border-primary) !important;
        }
    </style>
</head>


<body>
    <div class="sec_container_utama">
        <div class="sec_sidebar" id="sec_sidebar">
            @include('layouts.side_nav')
        </div>
        <div class="sec_groupmain">
            <div class="sec_top_navbar">
                @include('layouts.top_nav')
            </div>
            <div class="sec_main_konten">
                <div class="title_main_content">
                    <h3>Welcome!</h3>
                </div> 
                <div class="content_body">
                    <div class="aplay_code">
                        @yield('container')
                    </div>
                    <div class="footer" id="footer">
                        <span>© Copyright 2025 Mini Game All Rights Reserved.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
    <script src="/assets/script.js"></script>
    <script src="/assets/design.js"></script>
    <script src="/assets/component.js"></script>

</body>

</html>
