<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function getMainUsers(){
        return DB::table('users')->whereNull('deleted_at')->get();
    }

    public function createMainUsers(Request $request){
        if($request->main_users_type == 'System Admin'){
            $new_id = '';
            $last_id = DB::table('users')->where('user_type','!=','Staff')->whereNull('deleted_at')->orderBy('id','DESC')->limit(1)->value('crew_id');
            preg_match('/\d+$/', $last_id, $matches);
            if (isset($matches[0])) {
                $number = $matches[0];
                $new_id = 'SA-'.($number+1);
            }
            else{
                $new_id = 'SA-1';
            }
            
            return DB::table('users')->insert([
                'crew_id' => $new_id,
                'username' => $request->main_users_username,
                'name' => $request->main_users_name,
                'email' => $request->main_users_email,
                'password' => Hash::make($request->main_users_password),
                'user_type' => $request->main_users_type,
                'created_at' => Carbon::now()
            ]);
        }
        else if($request->main_users_type == 'Staff'){
            $new_id = '';
            $last_id = DB::table('users')->where('user_type','!=','System Admin')->whereNull('deleted_at')->orderBy('id','DESC')->limit(1)->value('crew_id');
            preg_match('/\d+$/', $last_id, $matches);
            if (isset($matches[0])) {
                $number = $matches[0];
                $new_id = 'S-'.($number+1);
            }
            else{
                $new_id = 'S-1';
            }
            
            return DB::table('users')->insert([
                'crew_id' => $new_id,
                'username' => $request->main_users_username,
                'name' => $request->main_users_name,
                'email' => $request->main_users_email,
                'password' => Hash::make($request->main_users_password),
                'user_type' => $request->main_users_type,
                'created_at' => Carbon::now()
            ]);
        }
    }

    public function saveMainUsers(Request $request){
        return DB::table('users')->where('id',$request->main_users_id)
        ->update([
            'username' => $request->main_users_username,
            'name' => $request->main_users_name,
            'email' => $request->main_users_email,
            'user_type' => $request->main_users_type,
        ]);
    }

    public function removeMainUsers(Request $request){
        return DB::table('users')->where('id',$request->main_users_id)
        ->update([
            'deleted_at' => Carbon::now()
        ]);
    }
}
