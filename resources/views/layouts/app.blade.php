<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Info Surplus Ikan') }}</title>

    {{-- ============================================================
         ASSET STISLA
         Download template Stisla dari https://github.com/stisla/stisla
         lalu extract folder "modules" nya ke public/assets/modules
         (isi: bootstrap, jquery, popper, fontawesome, dsb - tidak lewat npm/vite)
    ============================================================= --}}
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
    @vite(['resources/views/assets/sass/app.scss'])

    @stack('styles')
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            @include('partials.navbar')
            @include('partials.sidebar')

            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>@yield('title', 'Dashboard')</h1>
                        @hasSection('breadcrumb')
                            <div class="section-header-breadcrumb">@yield('breadcrumb')</div>
                        @endif
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Periksa kembali isian Anda:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @yield('content')
                </section>
            </div>

            <footer class="main-footer">
                <div class="footer-left">
                    &copy; {{ date('Y') }} {{ config('app.name', 'FTP') }} &mdash;
                    Sistem Visibilitas Surplus Komoditas Perikanan Antar Cabang
                </div>

                <div class="footer-right">
                    Developed by <strong>Ramous Peppy</strong>
                </div>
            </footer>
        </div>
    </div>

    @vite(['resources/views/assets/js/app.js'])
    @yield('scripts')
    @stack('scripts')
</body>

</html>
