<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" style="text-decoration: unset;" href="{{ route('home') }}">
            <span class="align-middle">{{ env('APP_NAME') }}</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Components
            </li>

            @can('home')
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('home') }}">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>
            @endcan

            @can('my-contracts')
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('my.contracts') }}">
                        <i class="align-middle" data-feather="clipboard"></i> <span
                            class="align-middle">My Contracts</span>
                    </a>
                </li>
            @endcan

            @can('case-management')
                <li class="sidebar-item">
                    <a href="#case-management" data-bs-toggle="collapse"
                       class="sidebar-link" role="button" aria-expanded="false"
                    >
                        <i class="fas fa-ribbon"></i>
                        Case Management
                        </span>
                    </a>
                    <ul id="case-management" class="sidebar-dropdown list-unstyled"
                        data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('cases') }}">
                                Cases
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('company') }}">
                                Company
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('worker') }}">
                                Worker
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('employer') }}">
                                Employer
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('contracts')
                <li class="sidebar-item">
                    <a href="#contracts" data-bs-toggle="collapse"
                       class="sidebar-link show collapsed" aria-expanded="false"
                    >
                        <i class="align-middle" data-feather="folder"></i> <span class="align-middle">Contracts</span>
                    </a>
                    <ul id="contracts" class="sidebar-dropdown list-unstyled collapse"
                        data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('contracts.pending') }}">
                                Pending
                                <span
                                    class="top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ \App\Models\Contract::fetchPendingCount() }}
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('contracts.approved') }}">Approved</a></li>
                    </ul>
                </li>
            @endcan

            @can('manage-users')
                <li class="sidebar-item">
                    <a href="#manage-users" data-bs-toggle="collapse"
                       class="sidebar-link show collapsed" aria-expanded="false"
                    >
                        <i class="align-middle" data-feather="users"></i> <span class="align-middle">Manage Users</span>
                    </a>
                    <ul id="manage-users" class="sidebar-dropdown list-unstyled collapse"
                        data-bs-parent="#sidebar">
                        @can('roles')
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('roles') }}">Roles</a></li>
                        @endcan
                        @can('users')
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('users') }}">Users</a></li>
                        @endcan
                    </ul>
                </li>
            @endcan
        </ul>

    </div>
</nav>
