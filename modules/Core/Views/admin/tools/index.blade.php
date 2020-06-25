@extends ('admin.layouts.app')
@section ('content')
    <?php
    $user = \Illuminate\Support\Facades\Auth::user();
    $hasAvailableTools = false;
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="d-flex justify-content-between mb20">
                    <h1 class="title-bar">{{__('Tools')}}</h1>
                </div>
                <div class="panel">
                    <div class="panel-body pd15">
                        <div class="row area-setting-row">
                            @if($user->hasPermissionTo('language_manage'))
                                @php $hasAvailableTools = true; @endphp
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="{{url('admin/module/language')}}">
                                            <span class="setting-item-media">
                                                <i class="icon ion-ios-globe"></i>
                                            </span>
                                            <span class="setting-item-info">
                                                <span class="setting-item-title">{{__("Languages")}}</span>
                                                <span class="setting-item-desc">{{__("Manage languages of your website")}}</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if($user->hasPermissionTo('language_translation'))
                                @php $hasAvailableTools = true; @endphp
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="{{url('admin/module/language/translations')}}">
                                            <span class="setting-item-media">
                                                <i class="icon ion-ios-globe"></i>
                                            </span>
                                            <span class="setting-item-info">
                                                <span class="setting-item-title">{{__("Translations")}}</span>
                                                <span class="setting-item-desc">{{__("Translation manager of your website")}}</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if($user->hasPermissionTo('system_log_view'))
                                @php $hasAvailableTools = true; @endphp
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="{{url('admin/logs')}}">
                                                <span class="setting-item-media">
                                                    <i class="icon ion-ios-nuclear"></i>
                                                </span>
                                            <span class="setting-item-info">
                                                <span class="setting-item-title">{{__("System Log Viewer")}}</span>
                                                <span class="setting-item-desc">{{__("Views and manage system log of your website")}}</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if($user->hasPermissionTo('system_log_view'))
                                @php $hasAvailableTools = true; @endphp
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="{{route('core.admin.updater.index')}}">
                                        <span class="setting-item-media">
                                            <i class="icon ion-ios-nuclear"></i>
                                        </span>
                                            <span class="setting-item-info">
                                            <span class="setting-item-title">{{__("Updater")}}</span>
                                            <span class="setting-item-desc">{{__("Updater Booking Core")}}</span>
                                        </span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if($user->hasPermissionTo('plugin_manage'))
                                @php $hasAvailableTools = true; @endphp
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="{{route('core.admin.plugins.index')}}">
                                        <span class="setting-item-media">
                                            <i class="icon ion-md-color-wand"></i>
                                        </span>
                                            <span class="setting-item-info">
                                            <span class="setting-item-title">{{__("Plugins")}}</span>
                                            <span class="setting-item-desc">{{__("Plugins for Booking Core")}}</span>
                                        </span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(!$hasAvailableTools)
                                <div class="col-md-12">
                                    {{__("No tools available")}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-5">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="d-flex justify-content-between mb20">
                    <h1 class="title-bar">Commander</h1>
                </div>
                <div class="panel">
                    <div class="panel-body pd15">
                        <div class="row area-setting-row">
                            @if($user->hasPermissionTo('system_log_view'))
                                @php $hasAvailableTools = true; @endphp
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" target="_blank" href="{{ route('commander.command' , ['cache:clear']) }}">
                                                <span class="setting-item-media">
                                                    <i class="icon ion-ios-nuclear"></i>
                                                </span>
                                            <span class="setting-item-info">
                                                <span class="setting-item-title">Cache Clear</span>
                                                <span class="setting-item-desc">Clear Application Cache</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" target="_blank" href="{{ route('commander.command' , ['config:clear']) }}">
                                                <span class="setting-item-media">
                                                    <i class="icon ion-ios-nuclear"></i>
                                                </span>
                                            <span class="setting-item-info">
                                                <span class="setting-item-title">Clear Config Cache</span>
                                                <span class="setting-item-desc">Clear Cached Configurations</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" target="_blank" href="{{ route('commander.command' , ['route:clear']) }}">
                                                <span class="setting-item-media">
                                                    <i class="icon ion-ios-nuclear"></i>
                                                </span>
                                            <span class="setting-item-info">
                                                <span class="setting-item-title">Clear Route Clear</span>
                                                <span class="setting-item-desc">Clear Router Cache</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" target="_blank" href="{{ route('commander.command' , ['view:clear']) }}">
                                                <span class="setting-item-media">
                                                    <i class="icon ion-ios-nuclear"></i>
                                                </span>
                                            <span class="setting-item-info">
                                                <span class="setting-item-title">Clear View Clear</span>
                                                <span class="setting-item-desc">Clear Blade View Cache</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" target="_blank" href="{{ route('commander.command' , ['clear-compiled']) }}">
                                                <span class="setting-item-media">
                                                    <i class="icon ion-ios-nuclear"></i>
                                                </span>
                                            <span class="setting-item-info">
                                                <span class="setting-item-title">Clear Compiled</span>
                                                <span class="setting-item-desc">Clear Compiled Class Files</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection