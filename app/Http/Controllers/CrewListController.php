<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class CrewListController extends Controller
{
    public function getCrewList(Request $request){
        $filter = $request->filterRank;

        if($filter == 'All'){
            return DB::table('crew_profile_tbl')
            ->join('crew_rank_tbl', 'crew_profile_tbl.rank','=','crew_rank_tbl.code')
            ->select('crew_profile_tbl.*','crew_rank_tbl.alias')
            ->whereNull('crew_profile_tbl.deleted_at')
            ->get();
        }
        else{
            return DB::table('crew_profile_tbl')
            ->join('crew_rank_tbl', 'crew_profile_tbl.rank','=','crew_rank_tbl.code')
            ->where('crew_profile_tbl.rank',$filter)
            ->select('crew_profile_tbl.*','crew_rank_tbl.alias')
            ->whereNull('crew_profile_tbl.deleted_at')
            ->get();
        }
    }

    public function getCrewRanks(){
        return DB::table('crew_rank_tbl')->get();
    }

    public function submitCrewData(Request $request){
        
        $last_id = DB::table('crew_profile_tbl')->orderBy('id','DESC')->limit(1)->value('id');
        $new_id = $last_id+1;
       // return $last_id_converted;

        if($last_id = 0){
            $crew_id = "C-001";
        }
        elseif($new_id <= 9){
            $crew_id = "C-00".$new_id;
        }
        elseif($new_id <= 99){
            $crew_id = "C-0".$new_id;
        }
        else{
            $crew_id = "C-".$new_id;
        }

        return DB::table('crew_profile_tbl')->insert([
            'crew_id' => $crew_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'email' => $request->email,
            'address' => $request->address,
            'birthdate' => $request->birthdate,
            'age' => $request->age,
            'rank' => $request->rank,
            'height' => $request->height,
            'weight' => $request->weight,
        ]);
    }

    public function saveCrewData(Request $request){
        return DB::table('crew_profile_tbl')->where('crew_id',$request->crew_id)
        ->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'email' => $request->email,
            'address' => $request->address,
            'birthdate' => $request->birthdate,
            'age' => $request->age,
            'rank' => $request->rank,
            'height' => $request->height,
            'weight' => $request->weight,
        ]);
    }

    public function removeCrewData(Request $request){
        return DB::table('crew_profile_tbl')->where('id',$request->id)
        ->update([
            'deleted_at' => Carbon::now()
        ]);
    }
}
