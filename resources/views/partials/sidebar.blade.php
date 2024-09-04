<!-- resources/views/partials/sidebar.blade.php -->

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('dist/img/logo-round-small.png') }}" alt="{{ session('school')->name??'' }}" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ session('school')->name??'' }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ $roles = Auth::user()->getRoleNames() }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-house-chimney"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Masters Menu -->
                <li class="nav-item has-treeview {{ request()->is('schools*') || request()->is('course*') || request()->is('batch*') || request()->is('department*') || request()->is('roles-permissions*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('schools*') || request()->is('course*') || request()->is('batch*') || request()->is('department*') || request()->is('roles-permissions*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>Masters<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ request()->is('schools*') || request()->is('course*') || request()->is('batch*') || request()->is('department*') || request()->is('roles-permissions*') ? 'display: block;' : 'display: none;' }}">
                        <li class="nav-item">
                            <a href="{{ route('schools.index') }}" class="nav-link {{ request()->is('schools*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage School</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('course.list') }}" class="nav-link {{ request()->is('course*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Course Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('batch.list') }}" class="nav-link {{ request()->is('batch*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Batch Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('department.list') }}" class="nav-link {{ request()->is('department*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Department Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles-permissions.index') }}" class="nav-link {{ request()->is('roles-permissions*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Employees Menu -->
                <li class="nav-item has-treeview {{ request()->is('register*') || request()->is('user*') || request()->is('expenses*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('register*') || request()->is('user*') || request()->is('expenses*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Employees<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ request()->is('register*') || request()->is('user*') || request()->is('expenses*') ? 'display: block;' : 'display: none;' }}">
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link {{ request()->is('register*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Employee</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link {{ request()->is('user*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Employee</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('expenses.index') }}" class="nav-link {{ request()->is('expenses*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expense</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Students Menu -->
                <li class="nav-item has-treeview {{ request()->is('students*') || request()->is('student/expenses*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('students*') || request()->is('student/expenses*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-children"></i>
                        <p>Students<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ request()->is('students*') || request()->is('student/expenses*') ? 'display: block;' : 'display: none;' }}">
                        <li class="nav-item">
                            <a href="{{ route('students.index') }}" class="nav-link {{ request()->is('students*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Students</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student.expenses') }}" class="nav-link {{ request()->is('student/expenses*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expenses & Fees</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Vehicles Menu -->
                <li class="nav-item has-treeview {{ request()->is('vehicles*') || request()->is('vehicle/expense*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('vehicles*') || request()->is('vehicle/expense*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-car"></i>
                        <p>Vehicles<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ request()->is('vehicles*') || request()->is('vehicle/expense*') ? 'display: block;' : 'display: none;' }}">
                        <li class="nav-item">
                            <a href="{{ route('vehicles.index') }}" class="nav-link {{ request()->is('vehicles*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Vehicle</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('vehicle.expense.index') }}" class="nav-link {{ request()->is('vehicle/expense*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Vehicle Expense</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Accounts Menu -->
                <li class="nav-item has-treeview {{ request()->is('payments/cashInHand/settle') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('payments/cashInHand/settle') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-excel"></i>
                        <p>Accounts<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ request()->is('payments/cashInHand/settle') ? 'display: block;' : 'display: none;' }}">
                        <li class="nav-item">
                            <a href="{{ route('payments.cashInHand.settle') }}" class="nav-link {{ request()->is('payments/cashInHand/settle') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Make Payment</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Reports Menu -->
                <li class="nav-item has-treeview {{ request()->is('reports/students*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('reports/students*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>Reports<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ request()->is('reports/students*') ? 'display: block;' : 'display: none;' }}">
                        <li class="nav-item">
                            <a href="{{ route('reports.students.index') }}" class="nav-link {{ request()->is('reports/students*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Students Fees</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Settings Menu -->
                <li class="nav-item has-treeview {{ request()->is('settings*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('settings*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Settings<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ request()->is('settings*') ? 'display: block;' : 'display: none;' }}">
                        {{-- <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('settings/roles*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('settings/permissions*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Permissions</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ route('settings.expense.master') }}" class="nav-link {{ request()->is('settings/expense/master') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Students Expense</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- JavaScript for expanding/collapsing menu items -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('.nav-link');

    links.forEach(link => {
        link.addEventListener('click', function(e) {
            // Toggle current menu
            const parent = this.parentElement;
            const submenu = parent.querySelector('.nav-treeview');

            if (submenu) {
                e.preventDefault(); // Prevent default link action

                if (submenu.style.display === 'block') {
                    submenu.style.display = 'none';
                    this.classList.remove('active');
                } else {
                    // Close all open submenus
                    document.querySelectorAll('.nav-treeview').forEach(el => {
                        el.style.display = 'none';
                    });

                    // Remove active class from all links
                    document.querySelectorAll('.nav-link').forEach(el => {
                        el.classList.remove('active');
                    });

                    submenu.style.display = 'block';
                    this.classList.add('active');
                }
            }
        });
    });
});
</script>
