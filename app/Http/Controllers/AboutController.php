<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAboutRequest;
use App\Http\Requests\UpdateAboutRequest;
use App\Models\About;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $about = About::latest()->get();
        return view('about.index', compact('about'));
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
    public function store(StoreAboutRequest $request)
    {
        $data = $request->validated();

        // Upload images
        if ($request->hasFile('image1')) {
            $data['image1'] = $request->file('image1')->store('about', 'public');
        }

        if ($request->hasFile('image2')) {
            $data['image2'] = $request->file('image2')->store('about', 'public');
        }

        About::create($data);

        return redirect()->route('about.index')
            ->with('success', 'About created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(About $about)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(About $about)
    {
        return view('about.edit', compact('about'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAboutRequest $request, About $about)
    {
        $data = $request->validated();

        // Update image1
        if ($request->hasFile('image1')) {
            if ($about->image1 && Storage::disk('public')->exists($about->image1)) {
                Storage::disk('public')->delete($about->image1);
            }

            $data['image1'] = $request->file('image1')->store('about', 'public');
        }

        // Update image2
        if ($request->hasFile('image2')) {
            if ($about->image2 && Storage::disk('public')->exists($about->image2)) {
                Storage::disk('public')->delete($about->image2);
            }

            $data['image2'] = $request->file('image2')->store('about', 'public');
        }

        $about->update($data);

        return redirect()->route('about.index')
            ->with('success', 'About updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(About $about)
    {
        //
    }
}