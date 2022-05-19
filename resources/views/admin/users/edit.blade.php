@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-8">
      <div class="tile">
        <div class="row">
          <div class="col-lg-12">
            <form method="POST" action="{{ route('admin.users.update', $user->id)}}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="_method" value="PUT"/>  

              <div class="form-group">
                <label for="name">{{ __('admin.name')}}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
              </div> 
              <div class="form-group">
                <label for="file">{{ __('admin.image')}}</label>
                <div class="uploadOuter">
                  <span class="dragBox" >
                    <i class="fal fa-cloud-upload-alt fa-2x"></i>
                    
                    <input type="file" name="file" onChange="dragNdrop(event)"  ondragover="drag()" ondrop="drop()" id="uploadFile"  />
                  </span>
                </div>
                <div id="preview">
                  <img src="{{asset($user->image_path)}}" class="imgPreview img-thumbnail">
                </div>
              </div> 
              <div class="form-group">
                <label for="email">{{ __('admin.email')}}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
              </div> 
                <div class="form-group">
                <label for="phone">{{ __('admin.phone')}}</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
              </div> 
              <div class="form-group">
                <label for="password">{{ __('admin.password')}}</label>
                <input type="password" class="form-control" id="password" name="password" value="">
              </div>    
             
          </div>

        </div>
        <div class="tile-footer">
          <button class="btn btn-info" type="submit">{{ __('admin.edit') }}</button>
        </div>
      </div>
    </form>
    </div>
  </div>
@endsection