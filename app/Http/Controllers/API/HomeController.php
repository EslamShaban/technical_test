<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\OfferRepository;
use App\Repositories\BranchRepository;
use App\Repositories\UserRepository;
use App\Http\Resources\ClinicResource;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
class HomeController extends Controller
{

        
    private $branchRepository;
    
    public function __construct(BranchRepository $branch)
    {
        
        $this->branchRepository = $branch;

    }
    
    public function home()
    {

        $branch = $this->branchRepository->first();

        $offers                 = Offer::HomePageOffers()->get();
        $special_offers         = Offer::SpecialOffers()->get();
        $clinics                = $branch->clinics;

        $data = [

            'offers'            => OfferResource::collection($offers),
            'special_offers'    => OfferResource::collection($special_offers),
            'clinics'           => ClinicResource::collection($clinics),

        ];
        

        return response()->withData(__('api.home_page'), $data);

    }


}
