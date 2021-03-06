<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm p-2">
    <div class="container">

        <a class="navbar-brand text-primary font-weight-bold text-uppercase" href="{{ url('/') }}">
            Vehicle ID
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Menú <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @can('view-any', App\Models\Driver::class)
                                <a class="dropdown-item" href="{{ route('drivers.index') }}">Conductores</a>
                            @endcan
                            @can('view-any', App\Models\User::class)
                                <a class="dropdown-item" href="{{ route('users.index') }}">Usuarios</a>
                            @endcan
                            @can('view-any', App\Models\Vehicle::class)
                                <a class="dropdown-item" href="{{ route('vehicles.index') }}">Vehículos</a>
                            @endcan
                            @can('view-any', App\Models\Parking::class)
                                <a class="dropdown-item" href="{{ route('parkings.index') }}">Parqueaderos</a>
                            @endcan
                        </div>

                    </li>
                    @if (Auth::user()->can('view-any', Spatie\Permission\Models\Role::class) || Auth::user()->can('view-any', Spatie\Permission\Models\Permission::class))
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Control de Acceso <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @can('view-any', Spatie\Permission\Models\Role::class)
                                    <a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a>
                                @endcan

                                @can('view-any', Spatie\Permission\Models\Permission::class)
                                    <a class="dropdown-item" href="{{ route('permissions.index') }}">Permisos</a>
                                @endcan
                            </div>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
