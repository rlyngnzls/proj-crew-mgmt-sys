<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function user(Request $request)
    {
        return $request->user();
    }

    public function getCrewList(Request $request){
        $crewList = DB::table('crew_profile_tbl')
        ->join('crew_rank_tbl', 'crew_profile_tbl.rank','=','crew_rank_tbl.code')
        ->select('crew_profile_tbl.*','crew_rank_tbl.alias')
        ->whereNull('crew_profile_tbl.deleted_at')
        ->get();

        return response()->json($crewList);
    }

    public function submitCrewData(Request $request){
        try {
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

                DB::table('crew_profile_tbl')->insert([
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

            return response()->json(['message' => 'Crew added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add crew.', 'error' => $e->getMessage()], 500); // 500 Internal Server Error
        }
    }

    public function saveCrewData(Request $request){
        try {
            DB::table('crew_profile_tbl')->where('crew_id',$request->crew_id)
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

            return response()->json(['message' => 'Crew updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update crew.', 'error' => $e->getMessage()], 500); // 500 Internal Server Error
        }
    }

    public function removeCrewData(Request $request){
        try {
            DB::table('crew_profile_tbl')->where('id',$request->id)
            ->update([
                'deleted_at' => Carbon::now()
            ]);

            return response()->json(['message' => 'Crew removed successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to remove crew.', 'error' => $e->getMessage()], 500); // 500 Internal Server Error
        }
        
    }

    public function getCrewDocuments(Request $request){
        $crewDocuList = DB::table('crew_documents_tbl')->where('crew_id',$request->crew_id)->whereNull('deleted_at')->get();

        return response()->json($crewDocuList);
    }

    public function submitCrewDocument(Request $request){
        try {
            DB::table('crew_documents_tbl')->insert([
                'crew_id' => $request->crew_id,
                'code' => $request->document_code,
                'document_no' => $request->document_no,
                'document_name' => $request->document_name,
                'file_name' => 'n/a',
                'issued_date' => $request->issued_date,
                'expiry_date' => $request->expiry_date,
                'person_in_charge' => Auth::user()->name,
            ]);
    
            return response()->json(['message' => 'Crew document added successfully!'], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add crew document.', 'error' => $e->getMessage()], 500); // 500 Internal Server Error
        }
    }

    public function removeCrewDocu(Request $request){
        try {
            $data = DB::table('crew_documents_tbl')->where('id',$request->id)->get();
            $subfolderPath = $data[0]->crew_id . "/" . $data[0]->code;
            $filePathToDelete = $subfolderPath . '/' . $data[0]->file_name;

            Storage::disk('public')->delete($filePathToDelete);

            DB::table('crew_documents_tbl')->where('id',$request->id)
            ->update([
                'deleted_at' => Carbon::now()
            ]);
            
            return response()->json(['message' => 'Crew document removed successfully!'], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to remove crew document.', 'error' => $e->getMessage()], 500); // 500 Internal Server Error
        }
    }

    public function saveCrewDocument(Request $request){
        try {
            DB::table('crew_documents_tbl')->where('id',$request->document_id)
            ->update([
                'code' => $request->document_code,
                'document_no' => $request->document_no,
                'document_name' => $request->document_name,
                'file_name' => 'N/a',
                'issued_date' => $request->issued_date,
                'expiry_date' => $request->expiry_date,
                'person_in_charge' => Auth::user()->name,
            ]);

            return response()->json(['message' => 'Crew document updated successfully!'], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update crew document.', 'error' => $e->getMessage()], 500); // 500 Internal Server Error
        }
    }

    public function getMainUsers(){
        $mainUsers = DB::table('users')->whereNull('deleted_at')->get();

        return response()->json($mainUsers);
    }

    public function createMainUsers(Request $request){
        try{
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
                
                DB::table('users')->insert([
                    'crew_id' => $new_id,
                    'username' => $request->main_users_username,
                    'name' => $request->main_users_name,
                    'email' => $request->main_users_email,
                    'password' => Hash::make($request->main_users_password),
                    'user_type' => $request->main_users_type,
                    'created_at' => Carbon::now()
                ]);

                return response()->json(['message' => 'New user added successfully!'], 201); // 201 Created
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
                
                DB::table('users')->insert([
                    'crew_id' => $new_id,
                    'username' => $request->main_users_username,
                    'name' => $request->main_users_name,
                    'email' => $request->main_users_email,
                    'password' => Hash::make($request->main_users_password),
                    'user_type' => $request->main_users_type,
                    'created_at' => Carbon::now()
                ]);

                return response()->json(['message' => 'New user added successfully!'], 201); // 201 Created
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add new user.', 'error' => $e->getMessage()], 500); // 500 Internal Server Error
        }
        
    }

    public function saveMainUsers(Request $request){
        try{
            DB::table('users')->where('id',$request->main_users_id)
            ->update([
                'username' => $request->main_users_username,
                'name' => $request->main_users_name,
                'email' => $request->main_users_email,
                'user_type' => $request->main_users_type,
            ]);

            return response()->json(['message' => 'User information updated successfully!'], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update user information.', 'error' => $e->getMessage()], 500); // 500 Internal Server Error
        }
        
    }

    public function removeMainUsers(Request $request){
        try{
            DB::table('users')->where('id',$request->main_users_id)
            ->update([
                'deleted_at' => Carbon::now()
            ]);

            return response()->json(['message' => 'User removed successfully!'], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to remove user.', 'error' => $e->getMessage()], 500); // 500 Internal Server Error
        }
    }

    public function getMainRanks(){
        $mainRanks =  DB::table('crew_rank_tbl')->whereNull('deleted_at')->get();

        return response()->json($mainRanks);
    }

    public function createMainRanks(Request $request){
        try{
            DB::table('crew_rank_tbl')
            ->insert([
                'code' => strtoupper($request->main_rank_code),
                'rank_name' => strtoupper($request->main_rank_name),
                'alias' => strtoupper($request->main_rank_alias),
            ]);

            return response()->json(['message' => 'Rank added successfully!'], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to remove rank.', 'error' => $e->getMessage()], 500); // 500 Internal Server Error
        }
        
    }

    public function saveMainRanks(Request $request){
        try{
            DB::table('crew_rank_tbl')->where('id',$request->main_rank_id)
            ->update([
                'code' => strtoupper($request->main_rank_code),
                'rank_name' => strtoupper($request->main_rank_name),
                'alias' => strtoupper($request->main_rank_alias),
            ]);

            return response()->json(['message' => 'Rank updated successfully!'], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update rank.', 'error' => $e->getMessage()], 500); // 500 Internal Server Error
        }
        
    }

    public function removeMainRanks(Request $request){
        try{
            DB::table('crew_rank_tbl')->where('id',$request->main_rank_id)
            ->update([
                'deleted_at' => Carbon::now()
            ]);

            return response()->json(['message' => 'Rank removed successfully!'], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to remove rank.', 'error' => $e->getMessage()], 500); // 500 Internal Server Error
        }
    }

    public function getMainDocuments(){
        $mainDocus = DB::table('main_documents_tbl')->whereNull('deleted_at')->get();

        return response()->json($mainDocus);
    }

    public function createMainDocu(Request $request){
        try{
            DB::table('main_documents_tbl')
            ->insert([
                'code' => $request->main_docu_code,
                'docu_name' => $request->main_docu_name,
            ]);

            return response()->json(['message' => 'Document added successfully!'], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add document.', 'error' => $e->getMessage()], 500); // 500 Internal Server Error
        }
    }

    public function saveMainDocu(Request $request){
        try{
            DB::table('main_documents_tbl')->where('id',$request->main_docu_id)
            ->update([
                'code' => $request->main_docu_code,
                'docu_name' => $request->main_docu_name,
            ]);

            return response()->json(['message' => 'Document updated successfully!'], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update document.', 'error' => $e->getMessage()], 500); // 500 Internal Server Error
        }
        
    }

    public function removeMainDocu(Request $request){
        try{
            DB::table('main_documents_tbl')->where('id',$request->main_docu_id)
            ->update([
                'deleted_at' => Carbon::now()
            ]);

            return response()->json(['message' => 'Document removed successfully!'], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to remove document.', 'error' => $e->getMessage()], 500); // 500 Internal Server Error
        }
        
    }
}
