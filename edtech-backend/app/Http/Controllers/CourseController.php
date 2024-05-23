<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return response()->json($courses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric', // Validation for price
        ]);

        // Store thumbnail in storage with a prefixed filename
        $thumbnailPath = $request->file('thumbnail')->storeAs('thumbnails', 'thumbnail_' . time() . '.' . $request->file('thumbnail')->getClientOriginalExtension());

        $course = new Course();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price; // Set the price
        $course->thumbnail_url = $thumbnailPath;
        $course->save();

        return response()->json($course, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $course = Course::findOrFail($id);
        return response()->json($course);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric', // Validation for price
        ]);

        $course = Course::findOrFail($id);
        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price; // Update the price

        if ($request->hasFile('thumbnail')) {
            Storage::delete($course->thumbnail_url);
            // Store thumbnail in storage with a prefixed filename
            $thumbnailPath = $request->file('thumbnail')->storeAs('thumbnails', 'thumbnail_' . time() . '.' . $request->file('thumbnail')->getClientOriginalExtension());
            $course->thumbnail_url = $thumbnailPath;
        }

        $course->save();

        return response()->json($course, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        // Delete related records in other tables (e.g., videos)
        // Example:
        // $course->videos()->delete();

        Storage::delete($course->thumbnail_url);
        $course->delete();

        return response()->json(null, 204);
    }
}
