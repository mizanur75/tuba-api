<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Video::all();
        return view('videos.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVideoRequest $request)
    {
        if (!$request->hasFile('video')) {
            dd('File not detected');
        }

        $videoPath = $request->file('video')->store('videos', 'public');

        Video::create([
            'title' => $request->title,
            'subTitle' => $request->subTitle,
            'shortDescription' => $request->shortDescription,
            'video' => $videoPath,
            'status' => $request->status,
        ]);

        return redirect()->route('videos.index')
            ->with('success', 'Video uploaded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        return view('videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {
        $data = [
            'title' => $request->title,
            'status' => $request->status,
            'subTitle' => $request->subTitle,
            'shortDescription' => $request->shortDescription,
        ];

        // If new video uploaded
        if ($request->hasFile('video')) {

            // Delete old video
            if ($video->video && Storage::disk('public')->exists($video->video)) {
                Storage::disk('public')->delete($video->video);
            }

            // Store new video
            $videoPath = $request->file('video')->store('videos', 'public');
            $data['video'] = $videoPath;
        }

        $video->update($data);

        return redirect()->route('videos.index')
            ->with('success', 'Video updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        //
    }
}