<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrelloCard;
use Validator;
use Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function index(Request $request, $id){
        $decryptId = Crypt::decryptString($id);
        $datas = [];

        $condition = [];

        $condition[] = ['column_id', $decryptId];

        if(isset($request->date) && strlen($request->date)>0) $condition[] = ['created_at', $request->date];
        if(isset($request->status) && strlen($request->status)>0) $condition[] = ['is_active', $request->status];

        $datas = TrelloCard::where($condition)->orderBy('id', 'DESC')->get();

        return response()->json($datas);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required|string', 
            'column_id' => 'required', 
        ]);
        
        if($validator->fails()){
            return response()->json(['status' => 'error', 'data' => $validator->errors()]);
        }

        $data = TrelloCard::create([
            'title' =>  $request->title,
            'description' =>  $request->description,
            'column_id' =>  $request->column_id,
            'position' =>  $request->position,
            'is_active' => 1,
            'created_by'        => auth()->user()->id,
            'updated_by'        => auth()->user()->id
         ]);

        return response()->json(['status' => 'success', 'data' => $data ]);
    }

    public function show($id){
        $status = "success";

        try{
            $decryptId = Crypt::decryptString($id);
            $result = TrelloCard::find($decryptId);
        }
        catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            $status = "error";
            $result = null;
        }

        return response()->json(['status'=>$status, 'datas'=>$result]);
    }
   
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'title' => 'required|string',
            'column_id' => 'required', 
        ]);

        if($validator->fails()){
            return response()->json(['status' => 'error', 'data' => $validator->errors()]);
        }

        try{
            $decryptId = Crypt::decryptString($id);
            $model = TrelloCard::find($decryptId);
            $model->title =  $request->title;
            $model->description =  $request->description;
            $model->column_id =  $request->column_id;
            $model->position =  $request->position;
            $model->updated_by = auth()->user()->id;
            $model->save();

            return response()->json(['status' => 'success', 'data' => $model ]);
        }
        catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            return response()->json(['status' => 'error', 'data' => null ]);
        }
    }

    public function destroy($id){
        try{
            $decryptId = Crypt::decryptString($id);
            $model = TrelloCard::find($decryptId);
            $model->delete();

            return response()->json(['status' => 'success', 'data' => "Data success deleted" ]);
        }
        catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            return response()->json(['status' => 'error', 'data' => null ]);
        }
    }
}
