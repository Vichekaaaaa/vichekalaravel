<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background: linear-gradient(180deg, #1a1f2e 0%, #2a2f4e 100%);
            padding-top: 20px;
            color: white;
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.3);
        }
        .sidebar.collapsed {
            transform: translateX(-250px);
        }
        .sidebar .nav-item .nav-link {
            cursor: pointer;
            color: white !important;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 10px;
        }
        .sidebar .nav-item .nav-link i {
            margin-right: 10px;
            display: inline-block;
            font-size: 1.2rem;
        }
        .sidebar .nav-item .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .sidebar .nav-item .nav-link.active {
            background-color: #007bff;
            color: white !important;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
        }
        .sidebar .nav-item.admin-panel {
            background-color: rgba(255, 255, 255, 0.05);
            padding: 15px;
            margin: 0 10px 15px;
            border-radius: 8px;
        }
        .sidebar .nav-item.admin-panel span {
            font-size: 1.5rem;
            font-weight: 600;
            line-height: 1;
        }
        .sidebar .sub-menu {
            margin-left: 20px;
            display: none;
            overflow: hidden;
        }
        .sidebar .sub-menu.show {
            display: block;
            animation: slideFadeIn 0.3s ease-in-out;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            padding-bottom: 60px;
            transition: margin-left 0.3s ease-in-out;
            animation: fadeIn 0.7s ease-in;
        }
        .content.collapsed {
            margin-left: 0;
        }
        .header {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 999;
            background: linear-gradient(90deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 15px;
            transition: left 0.3s ease-in-out;
            animation: slideInDown 0.5s ease-in;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        .header.collapsed {
            left: 0;
        }
        .header h1 {
            font-size: 1.75rem;
            font-weight: 500;
            margin: 0;
        }
        .content-with-header {
            margin-top: 70px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 250px;
            right: 0;
            background: linear-gradient(180deg, #1a1f2e 0%, #2a2f4e 100%);
            color: white;
            padding: 10px;
            text-align: center;
            transition: left 0.3s ease-in-out;
            animation: slideInUp 0.5s ease-in;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
        }
        .footer.collapsed {
            left: 0;
        }
        .toggle-btn {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1100;
            background-color: #007bff;
            border: none;
            color: white;
            padding: 8px 12px;
            cursor: pointer;
            display: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .toggle-btn:hover {
            background-color: #0056b3;
        }
        .nav-link.collapsed-icon::after {
            content: '\25BC';
            float: right;
            margin-left: 10px;
            transition: transform 0.3s ease;
        }
        .nav-link.collapsed-icon[aria-expanded="true"]::after {
            content: '\25B2';
            transform: rotate(180deg);
        }
        .alert {
            animation: fadeInDown 0.5s ease-in;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }
            .sidebar.collapsed {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
            }
            .header {
                left: 0;
            }
            .footer {
                left: 0;
            }
            .toggle-btn {
                display: block;
                animation: pulse 1s infinite;
            }
        }
        @media (min-width: 769px) {
            .sidebar {
                transform: translateX(0);
            }
            .sidebar.collapsed {
                transform: translateX(-250px);
            }
            .content {
                margin-left: 250px;
            }
            .header {
                left: 250px;
            }
            .footer {
                left: 250px;
            }
        }
    </style>
</head>
<body>
    <!-- Toggle Button for Sidebar -->
    <button class="toggle-btn animate__animated" onclick="toggleSidebar()">☰</button>

    <!-- Header -->
    <header class="header animate__animated">
        <h1>Management System</h1>
    </header>

    <!-- Sidebar -->
    <div class="sidebar animate__animated animate__slideInLeft" id="sidebar">
        <div class="nav-item admin-panel">
            <span class="text-white d-flex align-items-center">
                <i class="bi bi-shield-lock" style="display: inline-block; font-size: 1.25rem; margin-right: 10px;"></i> 
                Admin Panel
            </span>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item animate__animated animate__fadeInLeft" style="animation-delay: 0.1s;">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2-fill" style="display: inline-block; font-size: 1.2rem;"></i> Dashboard</a>
            </li>
            <li class="nav-item animate__animated animate__fadeInLeft" style="animation-delay: 0.2s;">
                <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/"><i class="bi bi-house-fill" style="display: inline-block; font-size: 1.2rem;"></i> Manage Home</a>
            </li>
            <li class="nav-item animate__animated animate__fadeInLeft" style="animation-delay: 0.3s;">
                <a class="nav-link {{ request()->routeIs('logo.index') ? 'active' : '' }}" href="{{ route('logo.index') }}"><i class="bi bi-image" style="display: inline-block; font-size: 1.2rem;"></i> Manage Logo</a>
            </li>
            <li class="nav-item animate__animated animate__fadeInLeft" style="animation-delay: 0.4s;">
                <a class="nav-link {{ request()->routeIs('contact-methods.index') ? 'active' : '' }}" href="{{ route('contact-methods.index') }}"><i class="bi bi-person-lines-fill" style="display: inline-block; font-size: 1.2rem;"></i> Manage Contact Methods</a>
            </li>
            <li class="nav-item animate__animated animate__fadeInLeft" style="animation-delay: 0.5s;">
                <a class="nav-link {{ request()->routeIs('projects.index') ? 'active' : '' }}" href="{{ route('projects.index') }}"><i class="bi bi-briefcase" style="display: inline-block; font-size: 1.2rem;"></i> Manage Projects</a>
            </li>
            <li class="nav-item animate__animated animate__fadeInLeft" style="animation-delay: 0.6s;">
                <a class="nav-link collapsed-icon {{ request()->routeIs('tutorials.*', 'categories.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#tutorialsMenu" role="button" aria-expanded="false" aria-controls="tutorialsMenu">
                    <i class="bi bi-book" style="display: inline-block; font-size: 1.2rem;"></i> Manage Tutorials
                </a>
                <ul class="sub-menu collapse" id="tutorialsMenu">
                    <li class="nav-item animate__animated animate__fadeIn" style="animation-delay: 0.1s;">
                        <a class="nav-link {{ request()->routeIs('tutorials.index') ? 'active' : '' }}" href="{{ route('tutorials.index') }}"><i class="bi bi-journals" style="display: inline-block; font-size: 1.2rem;"></i> Tutorials</a>
                    </li>
                    <li class="nav-item animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
                        <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}" href="{{ route('categories.index') }}"><i class="bi bi-list" style="display: inline-block; font-size: 1.2rem;"></i> Categories</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item animate__animated animate__fadeInLeft" style="animation-delay: 0.7s;">
                <a class="nav-link {{ request()->routeIs('support-us.*') ? 'active' : '' }}" href="{{ route('support-us.index') }}"><i class="bi bi-heart-fill" style="display: inline-block; font-size: 1.2rem;"></i> Manage Support Us</a>
            </li>
            <li class="nav-item animate__animated animate__fadeInLeft" style="animation-delay: 0.8s;">
                <a class="nav-link {{ request()->routeIs('about.index') ? 'active' : '' }}" href="{{ route('about.index') }}"><i class="bi bi-person-circle" style="display: inline-block; font-size: 1.2rem;"></i> Manage About</a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content content-with-header" id="content">
        @if (session('success'))
            <div class="alert alert-success animate__animated animate__fadeInDown">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger animate__animated animate__fadeInDown">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer animate__animated" id="footer">
        <p>© {{ date('Y') }} Management System. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const header = document.querySelector('.header');
            const footer = document.querySelector('.footer');
            const toggleBtn = document.querySelector('.toggle-btn');

            sidebar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
            header.classList.toggle('collapsed');
            footer.classList.toggle('collapsed');

            if (!sidebar.classList.contains('collapsed')) {
                sidebar.classList.remove('animate__slideOutLeft');
                sidebar.classList.add('animate__slideInLeft');
            } else {
                sidebar.classList.remove('animate__slideInLeft');
                sidebar.classList.add('animate__slideOutLeft');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const tutorialsMenu = document.getElementById('tutorialsMenu');
            if (tutorialsMenu.classList.contains('show')) {
                tutorialsMenu.querySelectorAll('.nav-item').forEach((item, index) => {
                    item.style.animationDelay = `${0.1 + index * 0.1}s`;
                });
            }

            if (window.innerWidth <= 768) {
                document.getElementById('sidebar').classList.add('collapsed');
            }

            const collapseElement = document.getElementById('tutorialsMenu');
            collapseElement.addEventListener('show.bs.collapse', () => {
                collapseElement.querySelectorAll('.nav-item').forEach((item, index) => {
                    item.classList.remove('animate__fadeIn');
                    item.classList.add('animate__fadeIn');
                    item.style.animationDelay = `${0.1 + index * 0.1}s`;
                });
            });
            collapseElement.addEventListener('hide.bs.collapse', () => {
                collapseElement.querySelectorAll('.nav-item').forEach((item) => {
                    item.classList.remove('animate__fadeIn');
                });
            });
        });

        window.addEventListener('resize', () => {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 768 && sidebar.classList.contains('collapsed')) {
                toggleSidebar();
            } else if (window.innerWidth <= 768 && !sidebar.classList.contains('collapsed')) {
                toggleSidebar();
            }
        });
    </script>
</body>
</html>