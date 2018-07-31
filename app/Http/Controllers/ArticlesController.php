<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Validator;
use App\Http\Resources\Article as ArticleResource;


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

        return ArticleResource::collection($articles);
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
            $response = $validator->messages();
            return response()->json($response);
        } else {
            // Mass Assignment
            $article = Article::create([
                'title' => $request->title,
                'text' => $request->text,
            ]);
            return new ArticleResource($article);
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
            return new ArticleResource($article);
        } else {
            $response = 'Article not found.';
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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'article_id' => 'required',
            'title' => 'required',
            'text' => 'required'
        ]);
            
        if($validator->fails()){
            $response = $validator->messages();
            return response()->json($response);
        } else {
            $article = Article::findOrFail($request->article_id);
            $article->title = $request->title;
            $article->text = $request->text;
            $article->save();
            return new ArticleResource($article);
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
            return new ArticleResource($article);
        } else {
            $response = 'Article is not found.';
            return response()->json($response);
        }
    }
}
