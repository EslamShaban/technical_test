@extends('layouts.admin.app')

@section('content')

    <div class="col-md-6 col-lg-2">
        <div class="widget-small primary coloured-icon" style="height:50px">
            <i class="icon far fa-users" style="width:50px;background-color:#11233b"></i>
          <div class="info" style="padding: 0 5px 0 20px">
            <h4><a href="{{route('admin.users.index')}}" style="color: #11233b;text-decoration:none">{{ __('admin.users')}}</a></h4>
            <p><b>{{\App\Models\User::count()}}</b></p>
          </div>
        </div>
    </div>
@endsection