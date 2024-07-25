<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

        return response()->json(['data' => $buku->items(), ]);
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
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nama'     => 'required',
            'isbn'     => 'required',
            'tahun'    => 'required',
            'jumlah'   => 'required',
            'gambar'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_kategori' => 'required'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle file upload
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $gambarPath = $file->store('public/assets/img'); // Save file and get path
            $gambarPath = str_replace('public/', '', $gambarPath); // Remove 'public/' prefix
        }

        // Create post
        $post = Buku::create([
            'nama'        => $request->nama,
            'isbn'        => $request->isbn,
            'tahun'       => $request->tahun,
            'jumlah'      => $request->jumlah,
            'gambar'      => $gambarPath,
            'id_kategori' => $request->id_kategori
        ]);

        $post->load('kategoris');

        // Return response
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
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nama'       => 'required',
            'isbn'       => 'required',
            'tahun'      => 'required',
            'jumlah'     => 'required',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_kategori' => 'required'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle file upload
        $gambarPath = $buku->gambar; // Keep current image path by default
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($gambarPath && Storage::exists('public/' . $gambarPath)) {
                Storage::delete('public/' . $gambarPath);
            }

            // Store new image
            $file = $request->file('gambar');
            $gambarPath = $file->store('public/assets/img');
            $gambarPath = str_replace('public/', '', $gambarPath); // Remove 'public/' prefix
        }
        // Update the post
        $buku->update([
            'nama'       => $request->nama,
            'isbn'       => $request->isbn,
            'jumlah'     => $request->jumlah,
            'tahun'      => $request->tahun,
            'gambar'     => $gambarPath,
            'id_kategori' => $request->id_kategori
        ]);

        $buku->load('kategoris');

        // Return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diupdate!',
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
        // Find the book by ID
        $buku = Buku::find($id);

        // Check if the book exists
        if ($buku) {
            // Delete the image file from storage
            if ($buku->gambar) {
                $imagePath = storage_path('app/public/' . $buku->gambar);

                // Check if file exists before trying to delete
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Delete the book record
            $buku->delete();

            // Return response
            return response()->json([
                'success' => true,
                'message' => 'Data Buku Berhasil Dihapus!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Buku Tidak Ditemukan!',
            ], 404);
        }
    }
}