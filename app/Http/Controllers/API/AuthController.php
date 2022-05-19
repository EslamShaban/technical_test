<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepository;
use App\Http\Resources\UserResource;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\ForgetPasswordRequest;
use App\Http\Requests\API\UpdateProfileRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject as JWTSubject;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerificationCode;

class AuthController extends Controller
{

    private $UserRepository;
    
    public function __construct(UserRepository $User)
    {
        
        $this->UserRepository = $User;

    }

    public function register(RegisterRequest $request)
    {
        
        try {

            DB::beginTransaction();

            $request->merge([
                'password'      => bcrypt($request->password),
            ]);
            
            $user =  $this->UserRepository->create($request->all());

            if($request->has('image') && $request->image != null){

                $this->UserRepository->UploadFile(['file'=>$request->image, 'path'=>'assets/uploads/users'], $user->id);
            }

            $token             = JWTAuth ::fromUser( $user );

            $data = [

                'user'  => [new UserResource($user)],
                'token' => $token

            ];
            
            DB::commit();

            return response()->withData(__('api.resgister_successfuly'), $data);


        } catch (\Throwable $th) {
           
            DB::rollBack();
    
            return response()->withError($th->getMessage(), $th->getCode());
        }
        
    }

    public function login(LoginRequest $request)
    {

        $credentail = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $user = $this->UserRepository->findBy('email', $request->email);

        if($user){      
                    
            if(!$token = JWTAuth ::attempt( $credentail ) ){
                return response()->withError(__('api.wrong_password'), 5003);
            }

        }else{

            return response()->withError(__('api.wrong_email'), 5004);
        }

        
        $data = [

            'user'  => [new UserResource($user)],
            'token' => $token
            
        ];

            
        return response()->withData(__('api.login_successfuly'), $data);

        
    }

    public function forget_password(ForgetPasswordRequest $request)
    {
                
        $user = $this->UserRepository->findBy('email', $request->email);

        if($user){

            try{

                $code = generate_code();
                            

                $this->UserRepository->update(['code'=>$code], $user->id);

                //send mail

                Mail::to($user->email)->send(new SendVerificationCode(['first_name' => $user->first_name, 'code' => $code]));

                $data = [
                    'code' => $code
                ];

                return response()->withSuccess(__('api.code_send_successfully'), 200, $data);
            
            }  catch (\Throwable $th) {
               
                return response()->withError($th->getMessage(), $th->getCode());
        
            }

        }else{

            return response()->withError(__('api.user_not_exist'), 5002);

        }

    }


    public function update_profile(UpdateProfileRequest $request)
    {
        
        $user   = JWTAuth ::parseToken() -> toUser();
     
        $user   = $this->UserRepository->find($user->id);

        if(!$user){
       
            return response()->withError(__('api.wrong_user'), 5000);
        }

        try {

            DB::beginTransaction();

            $this->UserRepository->update($request->all(), $user->id);
                        
            if($request->has('image')){

                $this->UserRepository->deleteFile($user->id);
                $this->UserRepository->UploadFile(['file'=>$request->image, 'path'=>'assets/uploads/users'], $user->id);
            }

            $user       = $this->UserRepository->find($user->id);

            $token      = JWTAuth ::fromUser( $user );

            $data = [

                'user'  => [new UserResource($user)],
                'token' => $token

            ];
            
            DB::commit();

            return response()->withData(__('api.profile_updated_successfuly'), $data);


        } catch (\Throwable $th) {
           
            DB::rollBack();
    
            return response()->withError($th->getMessage(), $th->getCode());
        }
        
    }

        
    public function logout()
    {        
        auth('api')->logout();
                    
        return response()->withSuccess(__('api.logout_successfully'), 200);

    }
}
