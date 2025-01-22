<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISBN Application Form</title>
    <!-- Start CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/no-tailwind.css') }}" />

    <!-- <style>
        body ::selection {
            background-color: goldenrod; /* This is bg-blue-900 in Tailwind */
            color: white; /* This is text-white in Tailwind */
        }
    </style> -->

    <!-- end Start CSS -->

    <!-- Start JS -->
    <script src="{{ asset('assets/js/flowbite2.3.js') }}"></script>
    <script src="{{ asset('assets/js/tailwind34.js') }}"></script>
    <script src="{{ asset('assets/js/darkModeHead.js') }}"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Moul&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Siemreap&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: "class", // Enables dark mode based on class
            theme: {
                extend: {
                    colors: {
                        clifford: "#da373d",
                        // primary: "#00aff0",
                        // primaryHover: "#0a9fd5",
                        primary: "{{ $websiteInfo->primary }}",
                        primaryHover: "{{ $websiteInfo->primary_hover }}",
                        bannerColor: "{{ $websiteInfo->banner_color }}",
                        warning: "#fab105",
                        warningHover: "#ffb915",
                    },
                },
                fontFamily: {
                    moul: [
                        "Moul", "Siemreap", "Arial", "Inter", "ui-sans-serif", "system-ui", "-apple-system",
                        "system-ui", "Segoe UI", "Helvetica Neue",
                    ],
                    siemreap: [
                        "Siemreap", "Arial", "Inter", "ui-sans-serif", "system-ui", "-apple-system", "system-ui",
                        "Segoe UI", "Helvetica Neue",
                    ],
                    poppins: [
                        "Poppins", "Roboto", "Arial", "Inter", "ui-sans-serif", "system-ui", "-apple-system",
                        "system-ui", "Segoe UI", "Helvetica Neue",
                    ],

                },
            },
        };
    </script>
    <script defer src="{{ asset('assets/js/darkMode.js') }}"></script>
    <!-- End JS -->

</head>

<body class="">
    {{-- End Language --}}
    <div class="">
        @yield('content')
    </div>
    {{-- <div class="fixed bottom-0 left-0 ">
        <button type="button" data-dropdown-toggle="language-dropdown"
            class="inline-flex justify-center p-2 m-1 text-white rounded cursor-pointer dark:hover:text-white dark:text-gray-400 hover:text-purple-950 hover:bg-gray-200 bg-purple-950 dark:hover:bg-gray-600">
            <span class="mr-2 ">
                {{ app()->getLocale() == 'kh' ? 'ខ្មែរ' : 'English' }}
            </span>
            @if (app()->getLocale() == 'kh')
                <img src="{{ asset('assets/icons/khmer.png') }}" alt="icon"
                    class="object-contain w-6 h-6 border rounded-full">
            @else
                <img src="{{ asset('assets/icons/english.png') }}" alt="icon"
                    class="object-contain w-6 h-6 border rounded-full">
            @endif

        </button>
        <!-- Dropdown -->
        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow w-36 dark:bg-gray-700"
            id="language-dropdown">
            <ul class="py-1" role="none">
                <li>
                    <a href="{{ url('switch-language/kh') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:text-white dark:text-gray-300 dark:hover:bg-gray-600"
                        role="menuitem">
                        <div class="inline-flex items-center">
                            <img src="{{ asset('assets/icons/khmer.png') }}" alt="icon"
                                class="object-contain w-6 h-6 mr-2 border rounded-full">
                            ខ្មែរ
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('switch-language/en') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:text-white dark:text-gray-300 dark:hover:bg-gray-600"
                        role="menuitem">
                        <div class="inline-flex items-center">
                            <img src="{{ asset('assets/icons/english.png') }}" alt="icon"
                                class="object-contain w-6 h-6 mr-2 border rounded-full">
                            English
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div> --}}

</body>

</html>
