<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('common.head')
<body>
    <div id="app">
        @include('common.navbar')
    </div>
    <main class="py-4">
        @yield('content')
    </main>
    <aside>
        @yield('aside')
    </aside>
</body>
</html>
