<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{

    private $userRepository;
    
    public function __construct(UserRepository $user)
    {
        $this->userRepository = $user;
    }

    public function index()
    {
        $users = $this->userRepository->all();

        $title = __('admin.users');
        
        return view('admin.users.index', compact('users', 'title'));
    }

    public function create()
    {
        $title = __('admin.add_user');
        return view('admin.users.create', compact('title'));
    }


    public function store(UserRequest $request)
    {
        try {

            DB::beginTransaction();
            
            $data = $request->except('_token', '_method');

            $data['password'] = bcrypt($request->password);

            $user = $this->userRepository->create($data);
            
            if($request->has('file')){

                $this->userRepository->UploadFile(['file'=>$request->file, 'path'=>'assets/uploads/users'], $user->id);
            }
            
            DB::commit();

            notify()->success(__('admin.success'),__('admin.added_successfuly'));
            
            return response()->json(new UserResource($user));
    
        } catch (\Throwable $th) {
           
        DB::rollBack();

        throw $th;

        notify()->error(__('admin.error'), $admin_error);

        return redirect(aurl('users'));

    
     }
    
 }


    public function edit($id)
    {
        $user = $this->userRepository->find($id);
        $title = __('admin.edit_user');

        return view('admin.users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        try {

            DB::beginTransaction();

            $data = $request->except('_token', '_method');

            if(request()->has('password')){
                $data['password'] = bcrypt($request->password);
            }

            $this->userRepository->update($data, $user->id);

            if($request->has('file')){

                $this->userRepository->deleteFile($user->id);
                $this->userRepository->UploadFile(['file'=>$request->file, 'path'=>'assets/uploads/users'], $user->id);

            }

            DB::commit();

            notify()->success(__('admin.success'),__('admin.edit_successfuly'));
            return redirect(aurl('users'));

        } catch (\Throwable $th) {
           
            DB::rollBack();
    
            throw $th;
    
            notify()->error(__('admin.error'), $admin_error);
    
            return redirect(aurl('users'));
    
        }
    }


    public function destroy($id)
    {


        try {

            DB::beginTransaction();

            $this->userRepository->deleteFile($id);
            $this->userRepository->delete($id);
            
            DB::commit();
            
            notify()->success(__('admin.success'),__('admin.deleted_successfuly'));
            return redirect(aurl('users'));

        } catch (\Throwable $th) {
           
            DB::rollBack();
    
            throw $th;
    
            notify()->error(__('admin.error'), $admin_error);
    
            return redirect(aurl('users'));
    
        
        }
    }

}
