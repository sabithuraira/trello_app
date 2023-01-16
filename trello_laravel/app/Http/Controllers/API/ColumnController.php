<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrelloColumn;
use Validator;
use Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ColumnController extends Controller{
    public function index(Request $request){
        $datas = [];

        $condition = [];

        if(isset($request->date) && strlen($request->date)>0) $condition[] = ['created_at', $request->date];
        if(isset($request->status) && strlen($request->status)>0) $condition[] = ['is_active', $request->status];

        if(count($condition)>0){
            $datas = TrelloColumn::where($condition)->orderBy('id', 'DESC')->get();
        }
        else{
            $datas = TrelloColumn::all();
        }

        return response()->json($datas);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required|string'
        ]);
        
        if($validator->fails()){
            return response()->json(['status' => 'error', 'data' => $validator->errors()]);
        }

        $data = TrelloColumn::create([
            'title' =>  $request->title,
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
            $result = TrelloColumn::find($decryptId);
        }
        catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            $status = "error";
            $result = null;
        }

        return response()->json(['status'=>$status, 'datas'=>$result]);
    }
   
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'title' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json(['status' => 'error', 'data' => $validator->errors()]);
        }

        try{
            $decryptId = Crypt::decryptString($id);
            $model = TrelloColumn::find($decryptId);
            $model->title=  $request->title;
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
            $model = TrelloColumn::find($decryptId);
            $model->delete();

            return response()->json(['status' => 'success', 'data' => "Data success deleted" ]);
        }
        catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            return response()->json(['status' => 'error', 'data' => null ]);
        }
    }
}
