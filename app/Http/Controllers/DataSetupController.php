<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;

class DataSetupController extends Controller
{
    public function getMainDocuments(){
        return DB::table('main_documents_tbl')->whereNull('deleted_at')->get();
    }

    public function createMainDocu(Request $request){
        return DB::table('main_documents_tbl')
        ->insert([
            'code' => $request->main_docu_code,
            'docu_name' => $request->main_docu_name,
        ]);
    }

    public function saveMainDocu(Request $request){
        return DB::table('main_documents_tbl')->where('id',$request->main_docu_id)
        ->update([
            'code' => $request->main_docu_code,
            'docu_name' => $request->main_docu_name,
        ]);
    }

    public function removeMainDocu(Request $request){
        return DB::table('main_documents_tbl')->where('id',$request->main_docu_id)
        ->update([
            'deleted_at' => Carbon::now()
        ]);
    }

    public function getMainRanks(){
        return DB::table('crew_rank_tbl')->whereNull('deleted_at')->get();
    }

    public function createMainRanks(Request $request){
        return DB::table('crew_rank_tbl')
        ->insert([
            'code' => strtoupper($request->main_rank_code),
            'rank_name' => strtoupper($request->main_rank_name),
            'alias' => strtoupper($request->main_rank_alias),
        ]);
    }

    public function saveMainRanks(Request $request){
        return DB::table('crew_rank_tbl')->where('id',$request->main_rank_id)
        ->update([
            'code' => strtoupper($request->main_rank_code),
            'rank_name' => strtoupper($request->main_rank_name),
            'alias' => strtoupper($request->main_rank_alias),
        ]);
    }

    public function removeMainRanks(Request $request){
        return DB::table('crew_rank_tbl')->where('id',$request->main_rank_id)
        ->update([
            'deleted_at' => Carbon::now()
        ]);
    }
}
