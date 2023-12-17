<!DOCTYPE html>
<!--
Template Name: Rubick - HTML Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html
    class="{{ $darkMode ? 'dark' : '' }}{{ $colorScheme != 'default' ? ' ' . $colorScheme : '' }}"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
>
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link
        href="{{ Vite::asset('resources/images/logo.svg') }}"
        rel="shortcut icon"
    >
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <meta
        name="description"
        content="WMS mempermudah manajemen gudang dengan pelacakan inventaris dan pengelolaan pesanan."
    >
    <meta
        name="keywords"
        content="Manajemen Gudang, Sistem Penyimpanan, Pelacakan Inventaris, Efisiensi Operasional, Pengelolaan Pesanan, Optimasi Gudang, Stok Real-time, Otomatisasi Gudang, Kepatuhan Inventaris, Pemantauan Persediaan, Pengembangan Efisiensi, Kontrol Distribusi"
    >
    <meta
        name="author"
        content="LEFT4CODE"
    >

    @yield('head')

    <!-- BEGIN: CSS Assets-->
    @vite('resources/css/app.css')
    @stack('styles')
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body>
    @yield('content')

    @vite('resources/js/app.js')

    <!-- BEGIN: Vendor JS Assets-->
    @stack('vendors')
    <!-- END: Vendor JS Assets-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- BEGIN: Pages, layouts, components JS Assets-->
    @stack('scripts')
    <script>
        // make live search and reload page using #search
        const search = document.querySelector('#search');
        if (search) {
            search.addEventListener('keyup', function (e) {
                if (e.key === 'Enter') {
                    window.location.href = window.location.origin + window.location.pathname + '?search=' + e.target.value;
                }
            });
        }
        // on change per page reload page append param ?per_page=10
        const perPage = document.querySelector('#per_page');
        if (perPage) {
            perPage.addEventListener('change', function (e) {
                window.location.href = window.location.origin + window.location.pathname + '?per_page=' + e.target.value;
            });
        }
    </script>

    <!-- END: Pages, layouts, components JS Assets-->
</body>

</html>
