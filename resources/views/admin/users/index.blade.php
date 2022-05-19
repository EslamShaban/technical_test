@extends('layouts.admin.app')

@section('content')

<div class="app-title">
  <div>
    <h1><i class="fas fa-users"></i> {{$title}} </h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item"><a href="#">{{$title}}</a></li>
  </ul>
</div>
<div class="row">
                    
    <div class="col-md-12" >
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addUserModal" style="color:#FFF;float: {{ app()->getLocale() == 'ar' ? 'left' : 'right'}}; margin-bottom:20px">
          {{ __('admin.add_user') }}
        </button>

    </div>

    
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="table-responsive" id="buttons">
            <table class="table table-hover table-bordered" id="sampleTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{ __('admin.image') }}</th>
                  <th>{{ __('admin.name') }}</th>
                  <th>{{ __('admin.email') }}</th>
                  <th>{{ __('admin.action')}}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $index=>$user)

                  <tr>
                    <td>{{$index + 1 }}</td>
                    <td><img src="{{ asset($user->file->full_path ?? 'assets/images/default.png')}}" style="width: 50px;height:50px;border-radius:50%"></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>  
                    <a href="{{route('admin.users.edit', $user->id)}}" class="btn btn-info"><i class="fa fa-edit"></i> </a>
                    <a href="#" class="btn btn-danger deleteNotify" id="deleteNotify" onclick="deleteItem('#delete_item_{{$user->id}}')"><i class="fa fa-trash"></i> </a>
                    <form action="{{route('admin.users.destroy', $user->id)}}" method="POST" id="delete_item_{{$user->id}}">
                      @csrf
                      <input type="hidden" name="_method" value="delete"/>
                    </form>
                    </td>

                  </tr>

                @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
        


  <!-- Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form method="POST" action="{{ route('admin.users.store')}}" enctype="multipart/form-data" id="add_user">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="name">{{ __('admin.name')}}</label>
              <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
            </div> 
            <div class="form-group">
              <label for="file">{{ __('admin.image')}}</label>
              <div class="uploadOuter">
                <span class="dragBox" >
                  <i class="fal fa-cloud-upload-alt fa-2x"></i>
                  
                  <input type="file" name="file" onChange="dragNdrop(event)"  ondragover="drag()" ondrop="drop()" id="uploadFile"  />
                </span>
              </div>
              <div id="preview"></div>
            </div> 
            <div class="form-group">
              <label for="email">{{ __('admin.email')}}</label>
              <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}">
            </div> 
            <div class="form-group">
              <label for="phone">{{ __('admin.phone')}}</label>
              <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone')}}">
              <div class="alert alert-danger" style="display: none" id="phone-req"></div>

            </div> 
            <div class="form-group">
              <label for="password">{{ __('admin.password')}}</label>
              <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}">
            </div> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
            <button type="submit" class="btn btn-primary">حفظ</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection