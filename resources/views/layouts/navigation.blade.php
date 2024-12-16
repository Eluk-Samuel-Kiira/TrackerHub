
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
        <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px">
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item here {{ is_tab_show(['dashboard','projects.index',]) }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-building-dash fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">{{__('Dashboards')}}</span>
                        <span class="menu-arrow"></span>
                    </span>

                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ is_route_active('dashboard') }}" href="{{ route('dashboard') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{ __('Dashboard') }}</span>
                            </a>
                        </div>

                    </div>

                </div>

                {{--Project Mgt --}}
                <div data-kt-menu-trigger="click" class="menu-item here {{ is_tab_show(['projects*','project_categories*','clients*']) }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-binoculars-fill fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">{{__('Projects Module')}}</span>
                        <span class="menu-arrow"></span>
                    </span>

                    @can('view project')
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ is_route_active('projects*') }}" href="{{ route('projects.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{__('Projects Index')}}</span>
                                </a>
                            </div>
                        </div>
                    @endcan

                    @can('view category')
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ is_route_active('project_categories.index') }}" href="{{ route('project_categories.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{__('Categories')}}</span>
                                </a>
                            </div>
                        </div>
                    @endcan

                    @can('view client')
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ is_route_active('clients.index') }}" href="{{ route('clients.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{__('Clients')}}</span>
                                </a>
                            </div>
                        </div>
                    @endcan

                </div>

                {{--Requistion Mgt --}}
                <div data-kt-menu-trigger="click" class="menu-item here {{ is_tab_show(['requistion*','expense*']) }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-cash-coin fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">{{__('Funds Requistion')}}</span>
                        <span class="menu-arrow"></span>
                    </span>

                    @can('view requisitions')
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ is_route_active('requistion.index') }}" href="{{ route('requistion.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{__('Requistion Index')}}</span>
                                </a>
                            </div>
                        </div>
                    @endcan

                    @can('view expenses')
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ is_route_active('expense.index') }}" href="{{ route('expense.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{__('Accounting Sheet')}}</span>
                                </a>
                            </div>
                        </div>
                    @endcan

                </div>


                {{--Human resource --}}
                <div data-kt-menu-trigger="click" class="menu-item here {{ is_tab_show(['employee*','role*','permission.index']) }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-people-fill fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">{{__('User Management')}}</span>
                        <span class="menu-arrow"></span>
                    </span>

                    @can('view user')
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ is_route_active('employee.index') }}" href="{{ route('employee.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{__('User List')}}</span>
                                </a>
                            </div>
                        </div>
                    @endcan

                    @can('admin only')
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ is_route_active('role.index') }}" href="{{ route('role.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{__('Roles')}}</span>
                                </a>
                            </div>
                        </div>

                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ is_route_active('permission.index') }}" href="{{ route('permission.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{__('Permissions')}}</span>
                                </a>
                            </div>
                        </div>
                    @endcan

                </div>

                
                {{--Reports --}}
                <div data-kt-menu-trigger="click" class="menu-item here {{ is_tab_show(['setting*','currencies*','departments*','document*','reports*']) }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-bar-chart-steps fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">{{__('Reports Module')}}</span>
                        <span class="menu-arrow"></span>
                    </span>

                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ is_route_active('report.index') }}" href="{{ route('report.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{__('General Reports')}}</span>
                            </a>
                        </div>
                    </div>
                

                </div>
                
                {{--System setting --}}
                <div data-kt-menu-trigger="click" class="menu-item here {{ is_tab_show(['setting*','currencies*','departments*','document*']) }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-gear-wide-connected fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">{{__('App Settings')}}</span>
                        <span class="menu-arrow"></span>
                    </span>

                    @can('admin only')
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ is_route_active('setting.index') }}" href="{{ route('setting.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{__('Basic Settings')}}</span>
                                </a>
                            </div>
                        </div>

                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ is_route_active('currencies.index') }}" href="{{ route('currencies.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{__('Currencies')}}</span>
                                </a>
                            </div>
                        </div>
                    @endcan

                    @can('view department')
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ is_route_active('departments.index') }}" href="{{ route('departments.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{__('Departments')}}</span>
                                </a>
                            </div>
                        </div>
                    @endcan

                    @can('view documents')
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ is_route_active('document.index') }}" href="{{ route('document.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{__('Document Types')}}</span>
                                </a>
                            </div>
                        </div>
                    @endcan


                </div>


            </div>
        </div>
    </div>
</div>
