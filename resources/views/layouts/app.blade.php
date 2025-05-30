<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Ticket Support')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
        }
        .sidebar a {
            display: block;
            padding: 12px 16px;
            color: #000;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #e2e6ea;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
        .pagination svg {
        width: 1rem !important;
        height: 1rem !important;
    }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center mt-3">Ticket Support</h4>
        <ul class="nav flex-column p-0 m-0">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link px-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('tickets.index') }}" class="nav-link px-3 {{ request()->routeIs('tickets.index') ? 'active' : '' }}">Tickets</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link px-3">Ticket Log</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link px-3">Users</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link px-3">Categories</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link px-3">Labels</a>
            </li>
            @auth
            <li class="nav-item mt-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link px-3 text-start text-danger" style="border: none; padding: 0;">Logout</button>
                </form>
            </li>
            @endauth
        </ul>
    </div>

    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>
