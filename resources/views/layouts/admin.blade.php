<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        #app-sidebar {
            width: 250px;
            min-width: 250px;
            transition: all 0.3s;
        }

        #app-sidebar.collapsed {
            width: 60px;
            min-width: 60px;
        }

        #app-sidebar .sidebar-header h5,
        #app-sidebar .nav-link span,
        #app-sidebar .pl-3 {
            transition: all 0.3s;
        }

        #app-sidebar.collapsed .sidebar-header h5,
        #app-sidebar.collapsed .nav-link span,
        #app-sidebar.collapsed .pl-3 {
            opacity: 0;
            width: 0;
            visibility: hidden;
            overflow: hidden;
        }

        #app-sidebar.collapsed .nav-link {
            justify-content: center;
        }

        #app-sidebar.collapsed .nav-link span {
            display: none;
        }

        #main-content {
            transition: all 0.3s;
        }

        #main-content.expanded {
            margin-left: 60px; /* Match the collapsed sidebar width */
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    <div id="app-wrapper" class="d-flex">
        {{-- Sidebar (Livewire) --}}
        <livewire:sidebar />

        {{-- Main content area --}}
        <div id="main-content" class="flex-grow-1">
            {{-- Navbar partial (using Bootstrap navbar) --}}
            @include('layouts.partials.navbar')

            <div class="container-fluid p-4">
                {{ $slot }}
            </div>

            {{-- Footer partial --}}
            @include('layouts.partials.footer')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        $(document).ready(function() {
            // Sidebar toggle functionality
            $('#sidebarToggle').click(function(e) {
                e.preventDefault();
                $('#app-sidebar').toggleClass('collapsed');
                $('#main-content').toggleClass('expanded');
            });
        });
    </script>

    @livewireScripts
</body>
</html>