<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::all();
        return response()->json($videos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'video' => 'required|file|mimes:mp4,mov,avi|max:2048',
            'sequence' => 'required|integer',
        ]);

        // Store video in storage
        $videoPath = $request->file('video')->store('videos', 'public');

        $video = new Video();
        $video->course_id = $request->course_id;
        $video->title = $request->title;
        $video->video_url = $videoPath;
        $video->sequence = $request->sequence;
        $video->save();

        return response()->json($video, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $video = Video::findOrFail($id);
        return response()->json($video);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'course_id' => 'exists:courses,id',
            'title' => 'string|max:255',
            'video' => 'file|mimes:mp4,mov,avi|max:2048',
            'sequence' => 'integer',
        ]);

        $video = Video::findOrFail($id);

        // Update video data
        if ($request->has('course_id')) {
            $video->course_id = $request->course_id;
        }
        if ($request->has('title')) {
            $video->title = $request->title;
        }
        if ($request->hasFile('video')) {
            // Delete old video
            Storage::disk('public')->delete($video->video_url);
            // Store new video
            $videoPath = $request->file('video')->store('videos', 'public');
            $video->video_url = $videoPath;
        }
        if ($request->has('sequence')) {
            $video->sequence = $request->sequence;
        }

        $video->save();

        return response()->json($video, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = Video::findOrFail($id);
        // Delete video from storage
        Storage::disk('public')->delete($video->video_url);
        $video->delete();

        return response()->json(null, 204);
    }
}
