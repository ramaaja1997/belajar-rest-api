<?php

namespace App\Transformers;

use App\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    public function transform(Post $post)
    {
        return [
            'id'        => $post->id,
            'nama'   	=> $post->nama,
            'gender'   	=> $post->gender,
            'alamat'   	=> $post->alamat,
            'harga'		=> $post->harga,
            'deskripsi'	=> $post->deskripsi,
            'published' => $post->created_at->diffForHumans(),
        ];
    }
}
