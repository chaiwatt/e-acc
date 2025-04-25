<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use DB;
use App\Models\Esurv\Trader;
use App\User;
class UsersController extends Controller
{

    
    public function index(Request $request)
    {
        $traders = Trader::select('trader_operater_name','trader_id', DB::raw('COUNT(trader_id) as trader_ids'))
                     ->where('trader_operater_name','!=' ,"")
                    ->whereNotNull('trader_id')
                    ->groupBy('trader_id')
                    ->havingRaw('COUNT(trader_id) >= 2')
                    ->orderByRaw('trader_id DESC')
                    ->get();

        $user   = User::select( 'tax_number', DB::raw('COUNT(tax_number) as tax_numbers'))
                    ->whereNotNull('tax_number')
                    ->groupBy('tax_number')
                    ->havingRaw('COUNT(tax_number) >= 2')
                    ->orderByRaw('tax_number DESC')
                    ->get();
 
        return view('api.users',['traders'=>$traders,'users'=> $user]);     
    }
}
