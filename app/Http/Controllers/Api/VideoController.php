<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video; // Importojmë modelin Video
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // Opsionale: Per type hinting me te qarte

class VideoController extends Controller
{
    /**
     * Merr të gjitha videot.
     */
    public function index(): JsonResponse
    {
        // Merr të gjitha videot nga databaza, të renditura sipas datës së krijimit (më i fundit i pari)
        $videos = Video::orderBy('created_at', 'desc')->get();
        return response()->json($videos); // Kthen videot si JSON
    }

    /**
     * Ruaj një video të re.
     */
    public function store(Request $request): JsonResponse
    {
        // Validimi i të dhënave hyrëse
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|string|max:255', // Kujdes: Këtu do të duhet logjika e upload-it real më vonë
            'thumbnail_url' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255',
        ]);

        // Krijon një video të re në bazën e të dhënave
        $video = Video::create($request->all());
        return response()->json($video, 201); // Kthen videon e krijuar me status 201 (Created)
    }

    /**
     * Shfaq një video specifike.
     */
    public function show(string $id): JsonResponse
    {
        // Gjen videon sipas ID-së ose dështon me 404
        $video = Video::findOrFail($id);
        return response()->json($video); // Kthen videon si JSON
    }

    /**
     * Përditëso një video ekzistuese.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        // Gjen videon sipas ID-së
        $video = Video::findOrFail($id);

        // Validimi i të dhënave
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|string|max:255',
            'thumbnail_url' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255',
        ]);

        // Përditëson videon me të dhënat e reja
        $video->update($request->all());
        return response()->json($video); // Kthen videon e përditësuar
    }

    /**
     * Fshin një video.
     */
    public function destroy(string $id): JsonResponse
    {
        // Gjen videon sipas ID-së
        $video = Video::findOrFail($id);
        $video->delete(); // Fshin videon
        return response()->json(null, 204); // Kthen status 204 (No Content)
    }

    /**
     * Shton ose heq një pëlqim nga një video.
     * Për momentin thjesht rrit/zvogëlon numrin e likes.
     * Në një zbatim real, do të kërkonte autentifikimin e përdoruesit dhe një tabelë pivot.
     */
    public function toggleLike(Request $request, string $id): JsonResponse
    {
        $video = Video::findOrFail($id);

        // Kontrollon nëse kërkesa përmban 'action' si 'unlike'
        if ($request->has('action') && $request->input('action') === 'unlike') {
            $video->likes = max(0, $video->likes - 1); // Zvogëlon likes, por jo nën zero
        } else {
            $video->likes++; // Rrit likes
        }
        $video->save(); // Ruaj ndryshimet në bazën e të dhënave

        return response()->json(['likes' => $video->likes]); // Kthen numrin e ri të pëlqimeve
    }
}