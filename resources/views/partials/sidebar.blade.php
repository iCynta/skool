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
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <!-- Additional sidebar items -->
                
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        ADMIN CORNER
                        <i class="fas fa-angle-left right"></i>
                        <!-- <span class="badge badge-info right">6</span> -->
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('schools.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Manage School</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('course.list')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Course Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('batch.list')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Batch Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('department.list')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Department Master</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('roles-permissions.index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Permissions</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        EMPLOYEE MASTER
                        <i class="fas fa-angle-left right"></i>
                        <!-- <span class="badge badge-info right">6</span> -->
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('register')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add Employee</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('user.index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List Employee</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('expenses.index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Expense</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        STUDENT MASTER
                        <i class="fas fa-angle-left right"></i>
                        <!-- <span class="badge badge-info right">6</span> -->
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- <li class="nav-item">
                            <a href="{{route('students.create')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>New Student</p>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="{{route('students.index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List Students</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('student.expenses')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Expenses & Fees</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        VEHICLE MASTER
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('vehicles.index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List vehicle</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('vehicle.expense.index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Vehicle Expense</p>
                            </a>
                        </li>                        
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        ACCOUNTS
                        <i class="fas fa-angle-left right"></i>
                        <!-- <span class="badge badge-info right">6</span> -->
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add Expense</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('payments.cashInHand.settle') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Make Payment</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        REPORTS
                        <i class="fas fa-angle-left right"></i>
                        <!-- <span class="badge badge-info right">6</span> -->
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('reports.students.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Students fees</p>
                            </a>
                        </li>
                  

                        
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        SETTINGS
                        <i class="fas fa-angle-left right"></i>
                        <!-- <span class="badge badge-info right">6</span> -->
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Manage Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Manage Permissions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('settings.expense.master')}}" class="nav-link">
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
