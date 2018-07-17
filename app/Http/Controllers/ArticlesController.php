<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Validator;


class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();

        return response()->json($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'text' => 'required'
        ]);
            
        if($validator->fails()){
            $response = [
                'response' => $validator->messages(),
                'success' => false
            ];
            return response()->json($response);
        } else {
            // Mass Assignment
            $article = Article::create([
                'title' => $request->input('title'),
                'text' => $request->input('text'),
            ]);

            return response()->json($article);
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        if($article = Article::find($id)){
            return response()->json($article);
        } else {
            $response = [
                'response' => 'Article is not found.',
            ];
            return response()->json($response);
        }
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'text' => 'required'
        ]);
            
        if($validator->fails()){
            $response = [
                'response' => $validator->messages(),
                'success' => false
            ];
            return response()->json($response);
        } else {
            $article = Article::findOrFail($id);
            $article->title = $request->input('title');
            $article->text = $request->input('text');
            $article->save();
            return response()->json($article);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($article = Article::find($id)){
            $article->delete();
            return response()->json($article);
        } else {
            $response = [
                'response' => 'Article is not found.',
                'success' => false
            ];
            return response()->json($response);
        }
    }
}
