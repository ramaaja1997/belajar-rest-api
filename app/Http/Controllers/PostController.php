<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use App\Transformers\PostTransformer;
use Auth;

class PostController extends Controller
{
    public function add(Request $request, Post $post)
    {
        // dd($request->input('nama'));
        $this->validate($request, [
            'nama'       => 'required|min:10',
            'gender'     => 'required|min:4',
            'alamat'     => 'required|min:10',
            'harga'      => 'required|min:5',
            'deskripsi'  => 'required|min:10',
        ]);

        $post = $post->create([
            'user_id'   => Auth::user()->id,
            'nama'      => $request->nama,
            'gender'    => $request->gender,
            'alamat'    => $request->alamat,
            'harga'     => $request->harga,
            'deskripsi' => $request->deskripsi,
        ]);

        $response = fractal()
            ->item($post)
            ->transformWith(new PostTransformer)
            ->toArray();

        return response()->json($response, 201);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->content = $request->get('content', $post->content);
        $post->save();

        return fractal()
            ->item($post)
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function delete(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json([
            'message' => 'Post deleted',
        ]);
    }

    public function getData(Request $request){
        $list = [];

    //     if($request->input('gender') !=null){
    //         $list = Post::where('gender','=',$request->input('gender'))->get();
    //     }
        
    //    else if($request->input('lokasi') !=null){
    //         $list = Post::where('lokasi','like','%'.$request->input('lokasi').'%')->get();
    //     }

        if($request->input('gender') !=null && $request->input('alamat') !=null){
            $list = Post::where('gender','like','%'.$request->input('gender').'%')
            ->where('alamat','like','%'.$request->input('alamat').'%')->get();
        }  
        return response()->json($list);
    }


}
