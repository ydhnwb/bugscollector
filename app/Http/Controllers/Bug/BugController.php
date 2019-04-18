<?php

namespace App\Http\Controllers\Bug;

use Illuminate\Http\Request;
use App\Models\BugModel;
use App\Http\Controllers\Controller;
use App\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class BugController extends Controller{

    public function index(){
        return response() -> json(Response::transform(BugModel::get(), "ok" , true), 200);
    }


    public function create(){    }

    public function store(Request $request)    {
        $rules = [
            'name' => 'required',
            'description' => 'required|min:10',
            'photo' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response() -> json(array('message' => 'check your request again. desc must be 10 char or more and form must be filled', 'status' => false), 400);
        }else{
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension();
            Storage::disk('public')->put($photo->getFilename().'.'.$extension,  File::get($photo));
            $bug = new BugModel();
            $bug->name = $request->name;
            $bug->description = $request->description;
            $bug->photo = "uploads/".$photo->getFilename().'.'.$extension;
            $bug->save();

            return response()->json(
                Response::transform(
                    $bug, 'successfully created', true
                ), 201);
        }
    }

    public function show($id)    {
        $bug = BugModel::find($id);
        if(is_null($bug)){
			return response() -> json(array('message'=>'record not found', 'status'=>false),200);
        }
        return response() -> json(Response::transform($bug,"found", true), 200);
    }


    public function edit($id)    {
        //
    }


    public function update(Request $request, $id){
        $bug = BugModel::find($id);
        $data = BugModel::find($id);
        if(is_null($bug)){
            return response() -> json(array('message'=>'Cannot found record', 'status' => 200), 200);
        }else{
            if($request->name != null){$data->name = $request->name;}
            if($request->description != null){ $data->description = $request->description; }

            BugModel::where('id', $id) -> update(['name' => $data->name, 'description' => $data->description]);

            $photo = $request->file('photo');
            //$bug->name = $request->name;
            //$bug->description = $request->description;
            if($photo != null){
                $extension = $photo->getClientOriginalExtension();
                Storage::disk('public')->put($photo->getFilename().'.'.$extension,  File::get($photo));
                $data->photo = "uploads/".$photo->getFilename().'.'.$extension;
            }
            BugModel::where('id',$id) -> update(['photo' => $data->photo]);
            //$bug->save();
            return response()->json(Response::transform(BugModel::find($id), $bug->name.'Successfully updated', true), 200);
        }
    }


    public function destroy($id){
        $bug = BugModel::find($id);
        if(is_null($bug)){
            return response() -> json(array('message'=>'cannot delete because record not found', 'status'=>false),200);
        }
        BugModel::destroy($id);
        return response() -> json(array('message'=>'succesfully deleted', 'status' => false), 200);
    }
}
