<?php

namespace App\Http\Controllers;

use App\Models\Kategoribuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriBukuController extends Controller
{
     /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts from Models
        $kategori = Kategoribuku::latest()->paginate(10);
        $data = [
            'title' => "Kategori Buku",
            'users' => $kategori
        ];
        //return view with data
        return view('pages/kategori', compact('kategori'), $data);
    }

    public function carikategori()
    {
        $kategori = Kategoribuku::orderBy('id', 'asc')->get();
        return response()->json(['data' => $kategori]);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama'     => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Kategoribuku::create([
            'nama'     => $request->nama
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $post
        ]);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show(Kategoribuku $kategori)
    {
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Kategori Buku',
            'data'    => $kategori
        ]);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Kategoribuku $kategori)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama'     => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $kategori->update([
            'nama'     => $request->nama
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diudapte!',
            'data'    => $kategori
        ]);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //delete post by ID
        Kategoribuku::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Kategori Buku Berhasil Dihapus!.',
        ]);
    }
}