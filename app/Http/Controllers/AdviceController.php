<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use Illuminate\Http\Request;

class AdviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advices = Advice::latest()->get();

        return view('advices.index', compact('advices'));
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string|max:2000',
            'status' => 'required|in:0,1',
        ]);

        Advice::create($data);

        return redirect()->route('advices.index')
            ->with('success', 'Advice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Advice $advice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advice $advice)
    {
        return view('advices.edit', compact('advice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advice $advice)
    {
        $data = $request->validate([
            'content' => 'required|string|max:2000',
            'status' => 'required|in:0,1',
        ]);

        $advice->update($data);

        return redirect()->route('advices.index')
            ->with('success', 'Advice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advice $advice)
    {
        //
    }
}
