<?php

namespace App\Http\Controllers;

use App\Models\ChirpComment;
use App\Http\Requests\StoreChirpCommentRequest;
use App\Http\Requests\UpdateChirpCommentRequest;

class ChirpCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChirpCommentRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChirpComment $chirpComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChirpCommentRequest $request, ChirpComment $chirpComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChirpComment $chirpComment)
    {
        //
    }
}
