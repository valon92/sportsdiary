<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News; // Importojmë modelin News
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // Opsionale: Per type hinting me te qarte

class NewsController extends Controller
{
    /**
     * Merr të gjitha lajmet.
     */
    public function index(): JsonResponse
    {
        // Merr të gjitha lajmet nga databaza, të renditura sipas datës së krijimit (më i fundit i pari)
        $news = News::orderBy('created_at', 'desc')->get();
        return response()->json($news); // Kthen lajmet si JSON
    }

    /**
     * Ruaj një lajm të ri.
     */
    public function store(Request $request): JsonResponse
    {
        // Validimi i të dhënave hyrëse
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        // Krijon një lajm të ri në bazën e të dhënave
        $news = News::create($request->all());
        return response()->json($news, 201); // Kthen lajmin e krijuar me status 201 (Created)
    }

    /**
     * Shfaq një lajm specifik.
     */
    public function show(string $id): JsonResponse
    {
        // Gjen lajmin sipas ID-së ose dështon me 404
        $news = News::findOrFail($id);
        return response()->json($news); // Kthen lajmin si JSON
    }

    /**
     * Përditëso një lajm ekzistues.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        // Gjen lajmin sipas ID-së
        $news = News::findOrFail($id);

        // Validimi i të dhënave
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        // Përditëson lajmin me të dhënat e reja
        $news->update($request->all());
        return response()->json($news); // Kthen lajmin e përditësuar
    }

    /**
     * Fshin një lajm.
     */
    public function destroy(string $id): JsonResponse
    {
        // Gjen lajmin sipas ID-së
        $news = News::findOrFail($id);
        $news->delete(); // Fshin lajmin
        return response()->json(null, 204); // Kthen status 204 (No Content)
    }
}