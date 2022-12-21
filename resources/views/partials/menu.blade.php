<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="{{route('main')}}">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route('admin.home') }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('upload_form_access')


            <li
                class="c-sidebar-nav-dropdown {{ request()->is('admin/upload-forms*') ? 'c-show' : '' }} {{ request()->is('admin/upload-forms*') ? 'c-show' : '' }} {{ request()->is('admin/upload-forms*') ? 'c-show' : '' }} {{ request()->is('admin/peptid-categories*') ? 'c-show' : '' }} {{ request()->is('admin/protein-types*') ? 'c-show' : '' }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cloud-upload-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.uploadForm.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route('admin.upload-forms.index') }}"
                            class="c-sidebar-nav-link {{ request()->is('admin/upload-forms') || request()->is('admin/upload-forms/*') ? 'c-active' : '' }}">
                            <i class="fa-fw fas fa-file-import c-sidebar-nav-icon">

                            </i>
                            {{ trans('cruds.uploadForm.title') }}
                        </a>
                    </li>
                    @can('peptide_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.peptides.uploadTsv') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/peptides/uploadTsv') }}">
                                <i class="fa-fw fas fa-ellipsis-h c-sidebar-nav-icon">

                                </i>
                                {{ trans('global.upload') }} Tsv {{ trans('cruds.peptide.title_singular') }} File
                            </a>
                        </li>
                    @endcan
                    @can('protein_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.proteins.uploadTsv') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/proteins/uploadTsv') }}">
                                <i class="fa-fw fas fa-signature c-sidebar-nav-icon">

                                </i>
                                {{ trans('global.upload') }} Tsv {{ trans('cruds.protein.title_singular') }} File
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('user_management_access')
            <li
                class="c-sidebar-nav-dropdown {{ request()->is('admin/permissions*') ? 'c-show' : '' }} {{ request()->is('admin/roles*') ? 'c-show' : '' }} {{ request()->is('admin/users*') ? 'c-show' : '' }} {{ request()->is('admin/audit-logs*') ? 'c-show' : '' }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.permissions.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.roles.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.users.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.audit-logs.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/audit-logs') || request()->is('admin/audit-logs/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('general_tab_access')
            <li
                class="c-sidebar-nav-dropdown {{ request()->is('admin/projects*') ? 'c-show' : '' }} {{ request()->is('admin/samples*') ? 'c-show' : '' }} {{ request()->is('admin/channels*') ? 'c-show' : '' }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-home c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.generalTab.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('project_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.projects.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/projects') || request()->is('admin/projects/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-project-diagram c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.project.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('sample_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.samples.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/samples') || request()->is('admin/samples/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-flask c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.sample.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('channel_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.channels.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/channels') || request()->is('admin/channels/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-asterisk c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.channel.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('psm_tab_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is('admin/psms*') ? 'c-show' : '' }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-flask c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.psmTab.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('psm_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.psms.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/psms') || request()->is('admin/psms/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-vials c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.psm.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('experiment_tab_access')
            <li
                class="c-sidebar-nav-dropdown {{ request()->is('admin/experiments*') ? 'c-show' : '' }} {{ request()->is('admin/biological-sets*') ? 'c-show' : '' }} {{ request()->is('admin/fractions*') ? 'c-show' : '' }} {{ request()->is('admin/strips*') ? 'c-show' : '' }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-flask c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.experimentTab.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('experiment_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.experiments.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/experiments') || request()->is('admin/experiments/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-flask c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.experiment.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('biological_set_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.biological-sets.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/biological-sets') || request()->is('admin/biological-sets/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-ellipsis-h c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.biologicalSet.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('fraction_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.fractions.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/fractions') || request()->is('admin/fractions/*') ? 'c-active' : '' }}">
                                <i class="fa-fw far fa-dot-circle c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.fraction.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('strip_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.strips.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/strips') || request()->is('admin/strips/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fab fa-strip-s c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.strip.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('option_access')
            <li
                class="c-sidebar-nav-dropdown {{ request()->is('admin/fragment-methods*') ? 'c-show' : '' }} {{ request()->is('admin/tissues*') ? 'c-show' : '' }} {{ request()->is('admin/sample-conditions*') ? 'c-show' : '' }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.option.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('fragment_method_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.fragment-methods.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/fragment-methods') || request()->is('admin/fragment-methods/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-chess-board c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.fragmentMethod.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('tissue_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.tissues.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/tissues') || request()->is('admin/tissues/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-chess-board c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.tissue.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('sample_condition_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.sample-conditions.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/sample-conditions') || request()->is('admin/sample-conditions/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-check-double c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.sampleCondition.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('peptide_protein_tab_access')
            <li
                class="c-sidebar-nav-dropdown {{ request()->is('admin/peptides*') ? 'c-show' : '' }} {{ request()->is('admin/proteins*') ? 'c-show' : '' }} {{ request()->is('admin/peptide-with-modifications*') ? 'c-show' : '' }} {{ request()->is('admin/peptid-categories*') ? 'c-show' : '' }} {{ request()->is('admin/protein-types*') ? 'c-show' : '' }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw far fa-caret-square-right c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.peptideProteinTab.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('peptide_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.peptides.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/peptides') || request()->is('admin/peptides/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-ellipsis-h c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.peptide.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('protein_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.proteins.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/proteins') || request()->is('admin/proteins/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-signature c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.protein.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('peptide_with_modification_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.peptide-with-modifications.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/peptide-with-modifications') || request()->is('admin/peptide-with-modifications/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-plus c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.peptideWithModification.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('peptid_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.peptid-categories.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/peptid-categories') || request()->is('admin/peptid-categories/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.peptidCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('protein_type_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.protein-types.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/protein-types') || request()->is('admin/protein-types/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-list c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.proteinType.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('other_requirement_tab_access')
            <li
                class="c-sidebar-nav-dropdown {{ request()->is('admin/dna-regions*') ? 'c-show' : '' }} {{ request()->is('admin/transcripts*') ? 'c-show' : '' }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.otherRequirementTab.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('dna_region_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.dna-regions.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/dna-regions') || request()->is('admin/dna-regions/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-dna c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.dnaRegion.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('transcript_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.transcripts.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/transcripts') || request()->is('admin/transcripts/*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-braille c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.transcript.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('species_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.speciess.index') }}"
                    class="c-sidebar-nav-link {{ request()->is('admin/speciess') || request()->is('admin/speciess/*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.species.title') }}
                </a>
            </li>
        @endcan
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}"
                href="/clear-data" target="_blank">
                <i class="fa-fw fas fa-trash c-sidebar-nav-icon">
                </i>
                Clear data
            </a>
        </li>
        @if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}"
                        href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link"
                onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>
