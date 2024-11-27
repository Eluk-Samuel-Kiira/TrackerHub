<?php

namespace App\Http\Controllers;

use App\Models\ProjectFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectFileController extends Controller
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
        //dd($request->all());

        $request->validate([
            'projectId'=>'required',
            'documentName'=>'required|string|unique:project_files,document_name',
            'document'=>'required',
            'documentTypeId'=> 'required'
        ]);

        // Ensure the 'uploads' directory exists in public storage
        if (!Storage::disk('public')->exists('uploads')) {
            Storage::disk('public')->makeDirectory('uploads');
        }

        $documentPath = $request->file('document')->storeAs('uploads', time() . '_' . $request->file('document')->getClientOriginalName(), 'public');

        $projectFile = ProjectFile::create([
            'project_id'=>$request->projectId,
            'document_name'=>$request->documentName,
            'document_path'=>$documentPath,
            'created_by'=>Auth::user()->id,
            'document_type'=>$request->documentTypeId,
        ]);

        if($projectFile){
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Document Added to project successfully.',
            ]);
        }else{
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Failed to add the document to the project.',
            ]);
        }

        return redirect(url('projects/'.$request->projectId.'#files'))->with('project', $request->projectId);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectFile $projectFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectFile $projectFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectFile $projectFile)
    {
        //
    }
}
