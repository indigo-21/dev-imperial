<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        @include('includes.head')
        @isset($importedLinks)
            {{ $importedLinks }}
        @endisset
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Imperial') }}</title>

        @yield('style')
    </head>
    <body class="font-sans antialiased" base_url="{{url("/")}}">
        <div class="wrapper">
            @include('includes.navigation')
            @include('includes.aside')

            @isset($content)
                  <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1 class="m-0">{{ $pageTitle ?? '' }}</h1>
                                </div><!-- /.col -->
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        @if (!request()->routeIs('dashboard'))
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                            <li class="breadcrumb-item active">{{ $pageTitle ?? '' }}</li>
                                        @endif
                                    </ol>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </div>
                    <!-- /.content-header -->
                    <section class="content">
                        <div class="container-fluid">
                            {{ $content }}
                        </div>
                    </section>
                 </div>
            @endisset

            <!-- Page Content -->
            {{-- <main>
                {{ $slot }}
            </main> --}}
       
            @include('includes.footer')
            @include('includes.script')
            <script src="{{ asset('assets/custom/js/global/variables.js') }}"></script>
            @yield('scripts')
            @if (session('success'))
                <script>
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: @json(session('success')),
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                </script>
            @endif
    </body>
</html>
