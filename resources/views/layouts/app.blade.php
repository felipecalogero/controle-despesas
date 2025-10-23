<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @include('layouts.partials.head')
</head>
<body class="bg-gray-50 text-gray-800 antialiased min-h-screen">

<!-- Layout Principal -->
<div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('layouts.partials.sidebar')

    <!-- Conteúdo Principal -->
    <main class="flex-1 overflow-hidden lg:ml-0">
        <!-- Header -->
        @include('layouts.partials.header')

        <!-- Conteúdo da Página -->
        <div class="p-4 sm:p-6 lg:p-8 overflow-y-auto h-full animate-fade-in">
            @yield('content')
        </div>
    </main>
</div>

<!-- ==================== MODAIS ==================== -->
@include('layouts.partials.modals.nova-despesa')
@include('layouts.partials.modals.confirmar-exclusao')

<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
