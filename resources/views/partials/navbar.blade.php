<nav class="navbar navbar-expand-lg navbar-light bg-light justify-center">
  <div class="container-fluid">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="red" class="bi bi-youtube" viewBox="0 0 16 16">
    <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z"/>
    </svg>
    <a class="navbar-brand pl-5" href="{{ url('/') }}">{{ config('app.name') }}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item {{request()->is('/') ? 'active':''}} me-5" style="list-style: none">
                <a class="nav-link active" aria-current="page" href="{{ route('main') }}">
                    <i class="bi bi-house"></i>الصفحة الرئيسية</a>
            </li>
            @auth
                
            <li class="nav-item {{request()->is('history') ? 'active':''}} me-5" style="list-style: none">
                <a class="nav-link active" aria-current="page" href="{{ route('history') }}">
                    <i class="bi bi-clock-history"></i>
                 سجل المشاهدة</a>
            </li>
            <li class="nav-item  me-5" style="list-style: none">
                <a class="nav-link active" aria-current="page" href="{{ route('videos.create') }}">
                    <i class="bi bi-upload"></i>
                 رفع فيديو</a>
            </li>
            <li class="nav-item {{request()->is('videos') ? 'active':''}} me-5" style="list-style: none">
                <a class="nav-link active" aria-current="page" href="{{ route('videos.index') }}">
                    <i class="bi bi-person-video2"></i>
                    فيديوهاتي </a>
            </li>
            @endauth

            <li class="nav-item {{request()->is('channel*') ? 'active':''}} me-5" style="list-style: none">
                <a class="nav-link active" aria-current="page" href="{{ route('channel.index') }}">
                    <i class="bi bi-tv"></i>
                القنوات</a>
            </li>

            
        </ul>

       
            <ul class="navbar-nav mx-auto">
                {{-- <div class="topbar" style="z-index:1">
                    @auth
                                    <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow alert-dropdown mx-1" style="list-style: none">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw fa-lg"></i>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901"/>
                                </svg>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter notif-count" data-count="{{App\Models\Alert::where('user_id',Auth::user()->id)->first()->alert}}">{{App\Models\Alert::where('user_id',Auth::user()->id)->first()->alert}}</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right text-right mt-2 mr-auto"
                                aria-labelledby="alertsDropdown">
                                <div class="alert-body">
                                    
                                </div>
                                <a class="dropdown-item text-center small text-gray-500" href="{{ route('all.Notification')}}">عرض جميع الإشعارات</a>
                            </div>
                        </li>
                    @endauth

                </div> --}}
                    @guest
                    <li class="nav-item" style="list-style: none">
                        <a href="{{route('login')}}" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0z"/>
                            <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
                            </svg>
                            {{__('تسجيل دخول')}}</a>
                    </li>
                    @if(Route::has('register'))
                    <li class="nav-item" style="list-style: none">
                        <a href="{{route('register')}}" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
                            </svg>
                            {{__('إنشاء حساب')}}</a>

                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown justify-content-left" style="list-style: none">
                        <a href="#" id="navbarDropdown" class="nav-link" data-bs-toggle="dropdown" >
                            <img  class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url}}" alt="{{Auth::user()->name}}">
                        </a>
                    <div class="dropdown-menu dropdown-menu-left px-2 text-right mt-2">
                        {{-- @can('update-books') --}}
                        {{-- @admin
                        <a href="{{ route('admin.index')}}" class="dropdown-item">لوحة الإدارة</a>
                        @endadmin  --}}
                        {{-- @endcan --}}
                        <hr>
                            <div class="pt-4 pb-1 border-t border-gray-200">
                                

                                <div class="mt-3 space-y-1">
                                    <div>

                                    <x-responsive-nav-link href="#" :active="request()->routeIs('profile.show')">
                                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                    </x-responsive-nav-link>
                                    </div>
                                    <hr>
                                    <!-- Account Management -->
                                    <div>
                                    <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                                        {{ __('الملف الشخصي') }}
                                    </x-responsive-nav-link>
                                    {{-- <a href="{{ route('profile.show')}}" class="dropdown-item">الملف الشخصي</a> --}}
                                    </div>
                                    <hr>
                                    @can('update-videos')
                                    <div>
                                        <a href="{{ route('admin.index')}}">لوحة الإدارة</a>
                                    </div>
                                    <hr>
                                        
                                    @endcan


                                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                        <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                                            {{ __('API Tokens') }}
                                        </x-responsive-nav-link>
                                    @endif

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}" id="logout-form" class="d-none">
                                        @csrf
                                    </form>

                                    <a href="{{ route('logout') }}" 
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Log Out') }}
                                    </a>

                                    {{-- <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <x-dropdown-link href="{{ route('logout') }}"
                                                @click.prevent="$root.submit();">
                                            {{ __('تسجيل الخروج') }}
                                        </x-dropdown-link>
                                    </form> --}}

                                    <!-- Team Management -->
                                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                        <div class="border-t border-gray-200"></div>

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Manage Team') }}
                                        </div>

                                        <!-- Team Settings -->
                                        <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                                            {{ __('Team Settings') }}
                                        </x-responsive-nav-link>

                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                                {{ __('Create New Team') }}
                                            </x-responsive-nav-link>
                                        @endcan

                                        <!-- Team Switcher -->
                                        @if (Auth::user()->allTeams()->count() > 1)
                                            <div class="border-t border-gray-200"></div>

                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Switch Teams') }}
                                            </div>

                                            @foreach (Auth::user()->allTeams() as $team)
                                                <x-switchable-team :team="$team" component="responsive-nav-link" />
                                            @endforeach
                                        @endif
                                    @endif
                            </div>
                        </div>
                    </div>
                </li>
            @endguest
        </ul>

    </div>
  </div>
</nav>