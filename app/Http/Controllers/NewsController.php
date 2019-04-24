<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
use App\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return response() -> json(Response::transform(News::get(), "ok" , true), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $rules = [
          'title' => 'required',
          'description' => 'required|min:10',
          'author' => 'required',
          'image' => 'required'
      ];

      $validator = Validator::make($request->all(), $rules);
      if($validator->fails()){
          return response() -> json(array(
              'message' => 'check your request again. desc must be 10 char or more and form must be filled', 'status' => false), 400);
      }else{
          $image = $request->file('image');
          $extension = $image->getClientOriginalExtension();
          Storage::disk('public')->put($image->getFilename().'.'.$extension,  File::get($image));
          $news = new News();
          $news->title = $request->title;
          $news->description = $request->description;
          $news->author = $request->author;
          $news->image = "uploads/".$image->getFilename().'.'.$extension;
          $news->save();

          return response()->json(
              Response::transform(
                  $news, 'successfully created', true
              ), 201);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $news = News::find($id);
      if(is_null($news)){
    return response() -> json(array('message'=>'record not found', 'status'=>false),200);
      }
      return response() -> json(Response::transform($news,"found", true), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
    }

    public function search(Request $request){
      $query = $request->search;
      $news = News::where('title','LIKE','%'.$query.'%')->get();
      if(sizeof($news) > 0){
          return response() -> json(Response::transform($news,"Has found", true), 200);
      }else{
          return response() -> json(array('message'=>'No record found', 'status' => false), 200);
      }
    }
}
