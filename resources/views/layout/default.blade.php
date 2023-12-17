<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
@include('components.head')

<body>

    <div class="container">
        @include('components.navigation')

        <main class="mt-5 mb-5">
            @include('components.errors')
            @include('components.status')
            @yield('content')
        </main>

        @include('components.footer')
    </div>

</body>

</html>
