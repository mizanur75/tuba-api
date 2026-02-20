<?php

namespace App\Http\Controllers;

use App\Models\Step;
use App\Http\Requests\StoreStepRequest;
use App\Http\Requests\UpdateStepRequest;

class StepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $steps = Step::latest()->get();
        return view('steps.index', compact('steps'));
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
    public function store(StoreStepRequest $request)
    {
        Step::create($request->validated());

        return redirect()
            ->route('steps.index')
            ->with('success', 'Step created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Step $step)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Step $step)
    {
        return view('steps.edit', compact('step'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStepRequest $request, Step $step)
    {
        $step->update($request->validated());

        return redirect()
            ->route('steps.index')
            ->with('success', 'Step updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Step $step)
    {
        //
    }
}