<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
        $path = '';
        $file = '';
        $validated = $request->validate(['type' => 'required|in:document,image,other', 'document' => 'mimes:pdf,doc,docx,pptx', 'image' => 'mimes:png,jpeg,jpg,gif']);
        if ($request->type == 'document' && $request->file('document')) {
            $file = $request->file('document');
            $path = $file->store('public/documents');
        } else if ($request->type == 'image' && $request->file('image')) {
            $file = $request->file('image');
            $path = $file->store('public/images');
        } else if ($request->type == 'other' && $request->file('other')) {
            $file = $request->file('other');
            $path = $file->store('public/others');
        } else {
            return response()->json(['message' => 'Invalid request'], 400);
        }
        $filePath = str_replace('public/', 'storage/', $path);
        $document = new Document;
        $document->path = $filePath;
        $document->name = $file->getClientOriginalName();
        $document->extension = $file->getClientOriginalExtension();
        $document->save();

        return response()->json(['message' => 'Document uploaded successfully', 'file' => $document], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(['file' => Document::find($id)], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        return Document::destroy($document->id);
    }
}
