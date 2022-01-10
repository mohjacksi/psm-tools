<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }} {{ request()->is("admin/audit-logs*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('audit_log_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.audit-logs.index") }}" class="nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.auditLog.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('psm_tab_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/projects*") ? "menu-open" : "" }} {{ request()->is("admin/people*") ? "menu-open" : "" }} {{ request()->is("admin/samples*") ? "menu-open" : "" }} {{ request()->is("admin/dna-regions*") ? "menu-open" : "" }} {{ request()->is("admin/transcripts*") ? "menu-open" : "" }} {{ request()->is("admin/proteins*") ? "menu-open" : "" }} {{ request()->is("admin/peptides*") ? "menu-open" : "" }} {{ request()->is("admin/psms*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-table">

                            </i>
                            <p>
                                {{ trans('cruds.psmTab.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('project_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.projects.index") }}" class="nav-link {{ request()->is("admin/projects") || request()->is("admin/projects/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-project-diagram">

                                        </i>
                                        <p>
                                            {{ trans('cruds.project.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('person_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.people.index") }}" class="nav-link {{ request()->is("admin/people") || request()->is("admin/people/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user-circle">

                                        </i>
                                        <p>
                                            {{ trans('cruds.person.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('sample_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.samples.index") }}" class="nav-link {{ request()->is("admin/samples") || request()->is("admin/samples/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-vial">

                                        </i>
                                        <p>
                                            {{ trans('cruds.sample.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('dna_region_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.dna-regions.index") }}" class="nav-link {{ request()->is("admin/dna-regions") || request()->is("admin/dna-regions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-dna">

                                        </i>
                                        <p>
                                            {{ trans('cruds.dnaRegion.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('transcript_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.transcripts.index") }}" class="nav-link {{ request()->is("admin/transcripts") || request()->is("admin/transcripts/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-braille">

                                        </i>
                                        <p>
                                            {{ trans('cruds.transcript.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('protein_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.proteins.index") }}" class="nav-link {{ request()->is("admin/proteins") || request()->is("admin/proteins/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-signature">

                                        </i>
                                        <p>
                                            {{ trans('cruds.protein.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('peptide_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.peptides.index") }}" class="nav-link {{ request()->is("admin/peptides") || request()->is("admin/peptides/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-ellipsis-h">

                                        </i>
                                        <p>
                                            {{ trans('cruds.peptide.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('psm_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.psms.index") }}" class="nav-link {{ request()->is("admin/psms") || request()->is("admin/psms/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-vials">

                                        </i>
                                        <p>
                                            {{ trans('cruds.psm.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_password') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>