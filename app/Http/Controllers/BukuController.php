<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class BukuController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts from Models
        $buku = Buku::with('kategoris')
        ->join('kategoris', 'bukus.id_kategori', '=', 'kategoris.id')
        ->select('bukus.*', 'kategoris.nama as kategori')
        ->orderBy('kategoris.nama')
        ->paginate(10);
        $data = [
            'title' => "Buku",
            'users' => $buku
        ];
        //return view with data
        return view('pages/buku', compact('buku'), $data);
    }

    public function filterData(Request $request)
{
    $kategorinama = $request->get('kategori');

    $buku = Buku::with('kategoris')
        ->join('kategoris', 'bukus.id_kategori', '=', 'kategoris.id')
        ->select('bukus.*', 'kategoris.nama as kategori')
        ->where('kategoris.nama', $kategorinama)
        ->orderBy('kategoris.nama')
        ->paginate(10);

    return response()->json(['data' => $buku->items(), 'pagination' => $buku->links()->render()]);
}


public function alldata(Request $request)
{
    $buku = Buku::with('kategoris')
        ->join('kategoris', 'bukus.id_kategori', '=', 'kategoris.id')
        ->select('bukus.*', 'kategoris.nama as kategori')
        ->orderBy('kategoris.nama')
        ->paginate(10);

    return response()->json([
        'data' => $buku,
        'pagination' => $buku->links()->toHtml(),
    ]);
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
            'nama'     => 'required',
            'isbn'   => 'required',
            'tahun'   => 'required',
            'jumlah'   => 'required',
            'gambar'   => 'required',
            'id_kategori'   => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Buku::create([
            'nama'     => $request->nama,
            'isbn'   => $request->isbn,
            'tahun'   => $request->tahun,
            'jumlah'   => $request->jumlah,
            'gambar'   => $request->gambar,
            'id_kategori'   => $request->id_kategori
        ]);

        $post->load('kategoris');

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
    public function show(Buku $buku)
    {
        //return response
        $buku->load('kategoris');

        return response()->json([
            'success' => true,
            'message' => 'Detail Buku',
            'data'    => $buku
        ]);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Buku $buku)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama'     => 'required',
            'isbn'   => 'required',
            'tahun'   => 'required',
            'jumlah'   => 'required',
            'gambar'   => 'required',
            'id_kategori'   => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $buku->update([
            'nama'     => $request->nama,
            'isbn'   => $request->isbn,
            'jumlah'   => $request->jumlah,
            'tahun'   => $request->tahun,
            'gambar'   => $request->gambar,
            'id_kategoti'   => $request->id_kategoti
        ]);

        $buku->load('kategoris');

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diudapte!',
            'data'    => $buku
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
        Buku::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Buku Berhasil Dihapus!.',
        ]);
    }
}