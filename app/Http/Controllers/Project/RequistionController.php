<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Project\StoreRequistionRequest;
use App\Http\Requests\Project\UpdateRequistionRequest;
use App\Models\Requistion;
use App\Models\Project;
use App\Models\DocumentType;
use App\Models\RequisitionFiles;
use DB;

class RequistionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {        
        $projects = Project::latest()->get();
        $requisitions = Requistion::latest()->get();
        $document_types = DocumentType::latest()->get();
        $requistion_files = RequisitionFiles::latest()->get();
        
        $bladeToReload = $request->query('bladeFileToReload');
        switch ($bladeToReload) {
            case 'reloadRequisitionComponent':
                return view('requistions.partials.requistion-component', [
                    'projects' => $projects,
                    'requisitions' => $requisitions,
                    'document_types' => $document_types,
                    'requistion_files' => $requistion_files,
                ]);
            default:
                return view('requistions.requistion-index', [
                    'projects' => $projects,
                    'requisitions' => $requisitions,
                    'document_types' => $document_types,
                    'requistion_files' => $requistion_files,
                ]);
        }
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
    public function store(StoreRequistionRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['created_by'] = auth()->user()->id;
        $requistion = Requistion::create($validatedData);

        if (isset($request->requistion_page) && !empty($request->requistion_page)) {

            return response()->json([
                'success' => true,
                'reload' => true,
                'componentId' => 'reloadRequisitionComponent',
                'refresh' => false,
                'message' => __('Requistion Submitted Successfully'),
                'redirect' => route('requistion.index'),
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Requistion $requistion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requistion $requistion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequistionRequest $request, Requistion $requistion)
    {
        try {
            // Validate and update the requisition
            $validatedData = $request->validated();
            // \Log::info($request);
            $updated = $requistion->update($validatedData);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'reload' => true,
                    'componentId' => 'reloadRequisitionComponent',
                    'refresh' => false,
                    'message' => __('Requisition updated and submitted successfully'),
                    'redirect' => route('requistion.index'),
                ]);
            }

            // If the update failed for some reason
            return response()->json([
                'success' => false,
                'message' => __('Failed to update requisition. Please try again.'),
            ], 400);
        } catch (\Exception $e) {
            // Handle unexpected exceptions
            return response()->json([
                'success' => false,
                'message' => __('An error occurred: ') . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requistion $requistion)
    {
        
        $requisition_to_project = Requistion::where('id', $requistion->id)->where('status', 'approved')->first();
        if ($requisition_to_project) {
            return response()->json([
                'success' => false,
                'message' => __('This requistion has been approved already!'),
            ]);
        }

        if ($requistion->isActive === 1) {
            return response()->json([
                'success' => false,
                'message' => __('This Requistion Is Still Active!'),
            ]);
        }
    
        $requistion->delete();

        return response()->json([
            'success' => true,
            'reload' => true,
            'componentId' => 'reloadRequisitionComponent',
            'refresh' => false,
            'message' => __('Requisition updated and submitted successfully'),
            'redirect' => route('requistion.index'),
        ]);
    }

    
    public function changeRequisitionStatus(Request $request, $id) 
    {
        $validated = $request->validate([
            'status' => 'required|in:1,0', 
        ]);
    
        $requisition = Requistion::find($id);
    
        if ($requisition) {
            $requisition->isActive = $validated['status'];  
            if ($requisition->save()) {  
                return response()->json([
                    'success' => true,
                    'reload' => true,
                    'refresh' => false,
                    'componentId' => 'reloadRequisitionComponent',
                    'message' => __('Requisition updated successfully'),
                ]);
            }
        }
    
        // If user not found or status update failed
        return response()->json([
            'success' => false,
            'message' => __('Requisition not found or status update failed!'),
        ]);
    }

    public function changeRequisitionResponse(Request $request, $id) 
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,denied,approved', 
        ]);

        $requisition = Requistion::find($id);

        if ($requisition) {
            // Check if the requisition is already approved
            if ($requisition->status === 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => __('An approved requisition cannot be reverted to pending or denied.'),
                ]);
            }


            // Update the status
            // if ($validated['status'] === 'approved') {
            //     $requisition->isActive = 0;
            // }
            $requisition->status = $validated['status'];  
            if ($requisition->save()) {  
                return response()->json([
                    'success' => true,
                    'reload' => true,
                    'refresh' => false,
                    'componentId' => 'reloadRequisitionComponent',
                    'message' => __('Requisition updated successfully'),
                ]);
            }
        }

        // If requisition not found or status update failed
        return response()->json([
            'success' => false,
            'message' => __('Requisition not found or status update failed!'),
        ]);
    }

    
    public function uploadRequisitionFile(Request $request, $id)
{
    DB::beginTransaction();  // Start a database transaction

    try {
        // Validate the incoming request
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,pdf,docx,xlsx,pptx,csv,txt|max:4096',
            'file_type' => 'required|exists:document_types,id',
        ]);

        // Find the requisition or fail
        $requisition = Requistion::findOrFail($id);
        $createdBy = auth()->user()->id;
        $fileType = $request->input('file_type');
        $uploadedFiles = [];

        // Check if files are provided
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Ensure the file is valid before proceeding
                if ($file->isValid()) {
                    // Generate a unique file name
                    $fileName = 'file_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    // Store the file on the 'public' disk
                    $filePath = $file->storeAs("requisition_files/{$id}", $fileName, 'public');

                    // Manually insert file record into the files table
                    \DB::table('requisition_files')->insert([
                        'requisition_id' => $id,  // Foreign key to the requisition
                        'file_name' => $fileName,
                        'file_type' => $fileType,
                        'file_path' => $filePath,
                        'created_by' => $createdBy,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Add to uploaded files list
                    $uploadedFiles[] = $fileName;
                }
            }
        }

        // Commit the transaction
        DB::commit();

        // Return success response
        return response()->json([
            'success' => true,
            'message' => __('Requisition files uploaded successfully'),
            'uploaded_files' => $uploadedFiles,
        ]);
        
    } catch (\Exception $e) {
        // Rollback transaction in case of error
        DB::rollBack();

        // Return error response
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while uploading the files. Please try again later.',
            'error_details' => $e->getMessage(),
        ], 500);
    }
}


}
