<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Project\StoreRequistionRequest;
use App\Http\Requests\Project\UpdateRequistionRequest;
use App\Models\Requistion;
use App\Models\Project;
use App\Models\DocumentType;
use App\Models\ProjectExpense;
use App\Models\RequisitionFiles;
use DB;
use Illuminate\Support\Facades\Storage;

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

            if ($requistion->status === 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => __('An approved requisition can not be edited.'),
                ]);
            }

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
    
        try {
            $requisitionFolderPath = 'requisition_files/' . $requistion->id; 
            if (Storage::disk('public')->exists($requisitionFolderPath)) {
                Storage::disk('public')->deleteDirectory($requisitionFolderPath);
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error occurred while deleting the requisition: ') . $e->getMessage(),
            ]);
        }
    }

    
    public function changeRequisitionStatus(Request $request, $id) 
    {
        $validated = $request->validate([
            'status' => 'required|in:1,0', 
        ]);
    
        $requisition = Requistion::find($id);
    
        if ($requisition) {
            if ($requisition->status === 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => __('An approved requisition status can not be changed'),
                ]);
            }
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

            // Update the budget if status is approved
            if ($validated['status'] === 'approved') {
                $project = Project::findOrFail($requisition->project_id);
                if ($project) {
                    $budgetResult = $this->budgetDeductions($requisition, $project);
                
                    if (!$budgetResult['success']) {
                        \Log::error($budgetResult['message']);
                        return response()->json([
                            'success' => false,
                            'message' => $budgetResult['message'], 
                        ]);
                    }
                
                    // Proceed only if budget deductions were successful
                    $requisition->isActive = 0;
                    $requisition->status = 'approved';
                    $requisition->save();

                
                    return response()->json([
                        'success' => true,
                        'reload' => true,
                        'refresh' => false,
                        'componentId' => 'reloadRequisitionComponent',
                        'message' => __('Requisition updated successfully'),
                    ]);
                }
            }
        }

        // If requisition not found or status update failed
        return response()->json([
            'success' => false,
            'message' => __('Requisition not found or status update failed because it night have been approved!'),
        ]);
    }

    
    private function budgetDeductions($requisition, $project)
    {
        // Validate requisition amount
        if (!isset($requisition->amount) || !is_numeric($requisition->amount) || $requisition->amount <= 0) {
            \Log::error('Invalid requisition amount: ' . json_encode($requisition));
            return [
                'success' => false,
                'message' => __('Invalid requisition amount.'),
            ];
        }

        // Ensure project budget properties are valid
        if (!isset($project->projectBudget, $project->projectBudgetLimit)) {
            \Log::error('Invalid project properties: ' . json_encode($project));
            return [
                'success' => false,
                'message' => __('Invalid project data.'),
            ];
        }

        // Calculate the new budget
        $newProjectBudget = $project->projectBudget - $requisition->amount;

        // Check if the deduction exceeds the budget limit
        if ($newProjectBudget < $project->projectBudgetLimit) {
            // \Log::info('Budget limit exceeded. Requisition: ' . json_encode($requisition));
            return [
                'success' => false,
                'message' => __('This requisition will surpass/exceed the budget limit.'),
            ];
        }

        // Update the project budget
        $project->update([
            'projectBudget' => $newProjectBudget,
        ]);

        $project_expenses = ProjectExpense::create([
            'project_id' => $project->id,
            'requested_by' => $requisition->id,
            'approved_amount' => $requisition->amount,
        ]);

        // \Log::info('Project budget updated successfully: ' . json_encode([
        //     'project_id' => $project->id,
        //     'old_budget' => $project->projectBudget + $requisition->amount,
        //     'new_budget' => $newProjectBudget,
        // ]));

        return [
            'success' => true,
            'message' => __('Project budget updated successfully.'),
        ];
    }



    public function uploadRequisitionFile(Request $request, $id)
    {
        DB::beginTransaction(); 

        try {
            $request->validate([
                'files.*' => 'required|file|mimes:jpg,jpeg,png,pdf,docx,xlsx,pptx,csv,txt|max:5096',
                'file_type' => 'required|exists:document_types,id',
            ]);

            
            // if ($request->hasFile('files')) { 
            //     \Log::info($request->all());
            //     die();
            // }

            $requisition = Requistion::findOrFail($id);
            $createdBy = auth()->user()->id;
            $fileType = $request->input('file_type');
            $uploadedFiles = [];

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    if ($file->isValid()) {

                        $fileName = 'file_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        
                        $filePath = $file->storeAs("requisition_files/{$id}", $fileName, 'public');

                        \DB::table('requisition_files')->insert([
                            'requisition_id' => $id, 
                            'file_name' => $fileName,
                            'file_type' => $fileType,
                            'file_path' => $filePath,
                            'created_by' => $createdBy,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        $uploadedFiles[] = $fileName;
                    }
                }
            }

            DB::commit();

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


    public function deleteFile(Request $request)
    {
        $request->validate([
            'file_id' => 'required|exists:requisition_files,id',    
            'file_location' => 'required|string',               
            'requisition_id' => 'required|exists:requistions,id',  
        ]);

        try {
            // Retrieve the file from the database using file_id
            $file = RequisitionFiles::findOrFail($request->file_id);

            // Get the file's location and generate the full file path within the storage directory
            $fileLocation = $request->file_location; // This should include the file's relative path
            $filePath = str_replace(asset('storage/'), '', $fileLocation); // Remove the public URL part

            // Delete the file from the storage directory using the Storage facade
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);  // Delete the file from the 'public' disk
            }

            // Now delete the file entry from the database
            $file->delete();

            return response()->json(['success' => true, 'message' => 'File deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting file', 'error' => $e->getMessage()]);
        }
    }



}
