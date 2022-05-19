    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{ asset(auth()->user()->file->full_path ?? 'assets/images/default.png')}}" style="width:50px;height:50px">
        <div>
          <p class="app-sidebar__user-name">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name}}</p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item {{active_menu('dashboard')['1']}}" href="{{ route('admin.index')}}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">{{ __('admin.dashboard') }}</span></a></li>
                      
          <li class="treeview">
            <a class="app-menu__item {{active_menu('users')['1']}}" href="{{ route('admin.users.index') }}">
              <i class="app-menu__icon fas fa-users"></i>
              <span class="app-menu__label">{{__('admin.users')}}</span>
            </a>
          </li>

      </ul>
    </aside>