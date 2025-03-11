<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CrewDocumentsController extends Controller
{
    public function getCrewDocuments(Request $request){
        return DB::table('crew_documents_tbl')->where('crew_id',$request->crew_id)->whereNull('deleted_at')->get();
    }

    public function getCrewDocumentsCode(){
        return DB::table('main_documents_tbl')->whereNull('deleted_at')->get();
    }

    public function submitCrewDocument(Request $request){
        $subfolderPath = $request->crew_id . "/" . $request->document_code;
        $file_name = $request->document_no . '.' . $request->document_file->getClientOriginalExtension();

        Storage::disk('public')->putFileAs(
            $subfolderPath, // Use the same subfolder path
            $request->document_file,
            $file_name
        );

        return DB::table('crew_documents_tbl')->insert([
            'crew_id' => $request->crew_id,
            'code' => $request->document_code,
            'document_no' => $request->document_no,
            'document_name' => $request->document_name,
            'file_name' => $file_name,
            'issued_date' => $request->issued_date,
            'expiry_date' => $request->expiry_date,
            'person_in_charge' => Auth::user()->name,
        ]);
    }

    public function removeCrewDocu(Request $request){
        $data = DB::table('crew_documents_tbl')->where('id',$request->id)->get();
        $subfolderPath = $data[0]->crew_id . "/" . $data[0]->code;
        $filePathToDelete = $subfolderPath . '/' . $data[0]->file_name;

        Storage::disk('public')->delete($filePathToDelete);

        return DB::table('crew_documents_tbl')->where('id',$request->id)
        ->update([
            'deleted_at' => Carbon::now()
        ]);
    }
}
