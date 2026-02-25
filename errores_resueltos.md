<?php

namespace App\Http\Controllers;
use App\Models\Album;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Método 1
    EL ERROR AQUI ES EN EL PAGINATE, ESA MANERA DE PAGINAR NO EXISTE. CORREGIDO
    public function index()
    {
        $albums = Album::paginate(10);
        return view('albums.index', compact('albums'));
    }

    // Método 2
    ESTE METODO DEJA PASAR AL DUEÑO DEL ALBUM Y LOS USUARIOS QUE NO SONN ADMIN EN VEZ DE DEJAR PASAR AL DUEÑO Y A LOS ADMINS CORREGIDO
    public function update(Request $request, Album $album)
    {
        if (auth()->id() !== $album->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $album->update($request->validated());

        return redirect()->route('albums.show', $album)
            ->with('success', 'Álbum actualizado.');
    }

    // Método 3
    LA VARIABLE $reviews NO LLEGA A APLICARSE EN LA VISTA albums.show CORREGIDO
    public function show(Album $album)
    {
        $reviews = $album->reviews()->orderBy('created_at', 'desc')->get();
        return view('albums.show', compact('album', 'reviews'));
    }
}
