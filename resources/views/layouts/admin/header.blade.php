 
<!-- Navbar-->
  <header class="app-header"><a class="app-header__logo" href="index.html"> </a>
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav" style="background:#f8f9fa">

          <li class="dropdown" style="background-color:#f8f9fa">
            <a class="app-nav__item" href="#" data-toggle="dropdown">
              <i class="fas fa-globe fa-lg" style="color: #2381c6 "></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-{{app()->getLocale() == 'ar' ? 'left' : 'right' }}">
              @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                  <li>
                      <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" style="">
                          {{ $properties['native'] }}
                      </a>
                  </li>
              @endforeach
          </ul>
          </li>

          <!-- User Menu-->
          <li class="dropdown" style="background-color:#2381c6">
            <a class="app-nav__item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" data-toggle="dropdown" aria-label="Open Profile Menu">
              <i class="fas fa-sign-out-alt fa-lg"></i>
            </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
          </li>

        </ul>
      </header>