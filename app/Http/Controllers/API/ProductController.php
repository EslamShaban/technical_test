<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepository;
use App\Repositories\ProductRepository;
use App\Http\Resources\ProductResource;
use App\Http\Requests\API\CreateProductRequest;
use App\Http\Requests\API\UpdateProductRequest;
use App\Http\Requests\API\SendProductInfoRequest;
use App\Http\Requests\API\UpdateProfileRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject as JWTSubject;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendproductInfo;
class ProductController extends Controller
{
    private $userRepository,$productRepository;
    
    public function __construct(UserRepository $user,ProductRepository $product)
    {
        
        $this->userRepository = $user;
        $this->productRepository = $product;

    }
    public function add_product(CreateProductRequest $request)
    {
        $user = JWTAuth ::parseToken() -> toUser();

        $user = $this->userRepository->find($user->id);

        if(!$user)
            return response()->withError(__('api.user_not_exist'), 5000);
                
        try {

            DB::beginTransaction();

            $request->merge([
                'user_id'      => $user->id,
            ]);
            
            
            $product =  $this->productRepository->create($request->all());

            if($request->has('images') && $request->images != null){

                foreach($request->images as $image){
                
                    $this->productRepository->UploadFile(['file'=>$image, 'path'=>'assets/uploads/products'], $product->id);

                }

            }

                    
            $data = [

                'product'  => [new ProductResource($product)],
                
            ];

            DB::commit();

            return response()->withData(__('api.product_added_successfully'), $data);


        } catch (\Throwable $th) {
           
            DB::rollBack();
    
            return response()->withError($th->getMessage(), $th->getCode());
        }
    }

    public function update_product($id, UpdateProductRequest $request)
    {
                
        $user = JWTAuth ::parseToken() -> toUser();

        $user = $this->userRepository->find($user->id);

        if(!$user)
            return response()->withError(__('api.user_not_exist'), 5000);
                
        try {

            DB::beginTransaction();
            
            $product = $this->productRepository->findBy('id', $id);

            if(!$product)
                return response()->withError(__('api.product_not_exist'), 5000);

            $this->productRepository->update($request->all(), $id);


            if($request->has('images') && $request->images != null){

                $this->productRepository->deleteFile($product->id);

                foreach($request->images as $image){
                
                    $this->productRepository->UploadFile(['file'=>$image, 'path'=>'assets/uploads/products'], $product->id);

                }

            }

                    
            $data = [

                'product'  => [new ProductResource($this->productRepository->find($id))],
                
            ];

            DB::commit();

            return response()->withData(__('api.product_updated_successfully'), $data);


        } catch (\Throwable $th) {
           
            DB::rollBack();
    
            return response()->withError($th->getMessage(), $th->getCode());
        }
    }

        
    public function delete_product($id)
    {
                
        $user = JWTAuth ::parseToken() -> toUser();

        $user = $this->userRepository->find($user->id);

        if(!$user)
            return response()->withError(__('api.user_not_exist'), 5000);
                
        try {

            DB::beginTransaction();
            
            $product = $this->productRepository->find($id);

            if(!$product)
                return response()->withError(__('api.product_not_exist'), 5000);

            
            $this->productRepository->deleteFile($product->id);
            $product->delete();

            DB::commit();

            return response()->withSuccess(__('api.product_deleted_successfully'), 200);


        } catch (\Throwable $th) {
           
            DB::rollBack();
    
            return response()->withError($th->getMessage(), $th->getCode());
        }
    }

    public function my_products()
    {
        $user = JWTAuth ::parseToken() -> toUser();

        $user = $this->userRepository->find($user->id);

        if(!$user)
            return response()->withError(__('api.user_not_exist'), 5000);

        $data = [

            'my_products'  => [ProductResource::collection($user->products)],
            
        ];


        return response()->withData(__('api.my_products'), $data);
                
    }

    public function all_products()
    {

        $products = $this->productRepository->all();

        $data = [

            'all_products'  => [ProductResource::collection($products)],
            
        ];


        return response()->withData(__('api.all_products'), $data);
                
    }
    
    public function send_product_info(SendProductInfoRequest $request)
    {
       
        $product = $this->productRepository->findBy('id',$request->product_id);

        if(! $product){
            return response()->withError(__('api.product_not_exist'), 5000);
        }

        foreach($request->user_ids as $user_id){

            $user = \App\Models\User::find($user_id);

            if($user){

                //send mail

                Mail::to($user->email)->send(new SendproductInfo($product));

            }

        }

        return response()->withSuccess(__('api.product_send_successfully'), 200);

    }


}
