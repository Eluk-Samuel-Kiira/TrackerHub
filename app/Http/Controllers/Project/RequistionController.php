<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Project\StoreRequistionRequest;
use App\Http\Requests\Project\UpdateRequistionRequest;
use App\Models\Requistion;
use App\Models\Project;
use App\Models\Setting;
use App\Models\DocumentType;
use App\Models\ProjectExpense;
use App\Models\RequisitionFiles;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\BudgetLimitMail;
use App\Mail\removeOrAddUserMail;
use App\Mail\RequisitionProcessedMail;
use App\Mail\RequisitionNotificationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\UOM;
use App\Models\RequisitionItem;

class RequistionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {    
        $requisitionItems = RequisitionItem::latest()->get();
        $departments = Department::latest()->get();
        $uoms = UOM::latest()->get();
        if (in_array(auth()->user()->role, ['director', 'project_manager'])) {
            $requisitions = Requistion::latest()->get();
            $projects = Project::latest()->get();
            $document_types = DocumentType::latest()->get();
            $requistion_files = RequisitionFiles::latest()->get();

        } elseif (auth()->user()->role === 'accountant') {
            // Accountant sees only approved requisitions
            $requisitions = Requistion::where('status', 'approved')->latest()->get();
            $projects = Project::latest()->get();
            $document_types = DocumentType::latest()->get();
            $requistion_files = RequisitionFiles::latest()->get();
        
        } else {
            $requisitions = Requistion::where('created_by', auth()->user()->id)->latest()->get();
            
            // Get project IDs associated with the user
            $project_ids = DB::table('project_user')
                            ->where('user_id', auth()->user()->id)
                            ->pluck('project_id'); // Fetch only project IDs
        
            $projects = Project::whereIn('id', $project_ids)->latest()->get();
            $document_types = DocumentType::latest()->get();
            $requistion_files = RequisitionFiles::where('created_by', auth()->user()->id)->latest()->get();
        }
    

        $bladeToReload = $request->query('bladeFileToReload');
        switch ($bladeToReload) {
            case 'reloadRequisitionComponent':
                return view('requistions.partials.requistion-component', [
                    'projects' => $projects,
                    'requisitions' => $requisitions,
                    'document_types' => $document_types,
                    'requistion_files' => $requistion_files,
                    'departments' => $departments,
                    'uoms' => $uoms,
                    'requisitionItems' => $requisitionItems,
                ]);
            default:
                return view('requistions.requistion-index', [
                    'projects' => $projects,
                    'requisitions' => $requisitions,
                    'document_types' => $document_types,
                    'requistion_files' => $requistion_files,
                    'departments' => $departments,
                    'uoms' => $uoms,
                    'requisitionItems' => $requisitionItems,
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
        $validatedData['amount'] = $request->amount_create;
        $validatedData['name'] = 'BECL-' . date('mY') . '-' . strtoupper(Str::random(8));

        $requisition = Requistion::create($validatedData);

        // \Log::info($request);
        do {
            $receipt_no = 'BMCL-' . strtoupper(Str::random(6));
        } while (RequisitionItem::where('receipt_no', $receipt_no)->exists());

        $totalAmount = 0;
        $requisitionItems = [];
        if ($request->has('requisitionTitle')) {
            foreach ($request->requisitionTitle as $key => $title) {
                $amount = $request->total_amount[$key];
                $totalAmount += $amount;

                $item = RequisitionItem::create([
                    'requisition_id' => $requisition->id,
                    'title' => $title,
                    'receipt_no' => $receipt_no,
                    'category_id' => $request->requisitionCategoryId[$key],
                    'uom_id' => $request->uom[$key],
                    'quantity' => $request->quantity[$key],
                    'unit_cost' => $request->unitCost[$key],
                    'amount' => $amount,
                ]);

                $requisitionItems[] = $item;
            }
        }

        
        // Fetch recipients
        $recipients = User::whereIn('role', ['project_manager', 'director'])->pluck('email');

        // Send email notification
        foreach ($recipients as $email) {
            Mail::to($email)->send(new RequisitionNotificationMail([
                'projectName' => $requisition->requisitionProject->projectName,
                'requisitionName' => $requisition->name,
                'submittedBy' => auth()->user()->name,
                'requisition_items' => $requisitionItems,
                'totalAmount' => $totalAmount,
                'description' => $request->description,
            ]));
        }

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

            if ($request->has('requisitionTitle')) {
                foreach ($request->requisitionTitle as $key => $title) {
                    $requisitionItem = RequisitionItem::find($request->requisitionItemId[$key]);
                    $requisitionItem->update([
                        'title' => $title,
                        'category_id' => $request->requisitionCategoryId[$key],
                        'uom_id' => $request->uom[$key],
                        'quantity' => $request->quantity[$key],
                        'unit_cost' => $request->unitCost[$key],
                        'amount' => $request->total_amount[$key],
                    ]);
                }
            }

            if ($requistion->status === 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => __('An approved requisition can not be edited.'),
                ]);
            }

            if ($requistion->isPaid === 1) {
                return response()->json([
                    'success' => false,
                    'message' => __('A requisition paid for can not be edited.'),
                ]);
            }

            if ($updated) {
                // return response()->json([
                //     'success' => true,
                //     'reload' => true,
                //     'componentId' => 'reloadRequisitionComponent',
                //     'refresh' => false,
                    // 'message' => __('Requisition updated and submitted successfully'),
                    // 'redirect' => route('requistion.index'),
                // ]);

                return response()->json([
                    'success' => true,
                    'refresh' => true,
                    'reload' => false,
                    'redirect' => route('requistion.index'),
                    'message' => __('Requisition Updated and Submitted successfully'),
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
            'status' => 'required|in:1,0', // 1 = Active (Unpaid), 0 = Inactive (Paid)
        ]);
        
        $requisition = Requistion::find($id);
        
        if ($requisition) {
            /**  
             * Hey developer
             * Active stands for unpaid requisitions
             * Inactive stands for paid
            */

            if ($requisition->status !== 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => __('You cannot make the payment for this requisition unless the Managing Director approves it first.'),
                ]);
            }

            // Prevent changing "Inactive" (Paid) requisitions back to "Active" (Unpaid)
            if ($requisition->isActive == 0) {
                return response()->json([
                    'success' => false,
                    'message' => __('A paid requisition cannot be marked as unpaid.'),
                ]);
            }

            if ($validated['status'] == 1) {
                return response()->json([
                    'success' => false,
                    'message' => __('You are to only process payment by clicking only PAID option.'),
                ]);
            }

            $project = Project::findOrFail($requisition->project_id);
            if ($project) {
                $budgetResult = $this->budgetDeductions($requisition, $project);
            
                if (!$budgetResult['success']) {
                    // \Log::error($budgetResult['message']);
                    return response()->json([
                        'success' => false,
                        'message' => $budgetResult['message'], 
                    ]);
                }

                // Mark requisition as approved and processed 
                $requisition->isActive = $validated['status'];
                $requisition->isPaid = 1;
            
                if ($requisition->save()) {
                    return response()->json([
                        'success' => true,
                        'reload' => true,
                        'refresh' => false,
                        'componentId' => 'reloadRequisitionComponent',
                        'message' => __('Requisition Payment Processed and Paid Successfully.'),
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('Project Not Found!'),
                ]);
            }
                
        }

        // If requisition not found or status update failed
        return response()->json([
            'success' => false,
            'message' => __('Requisition not found or status update failed!'),
        ]);
    }

    public function changeRequisitionResponse(Request $request, $id) 
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,denied,approved', 
            'reasons' => 'nullable|string', 
            'amount' => 'nullable', 
        ]);
                    

        $requisition = Requistion::find($id);
        // \Log::info($validated);
        if ($validated['status'] === 'approved') {
            $requisition->approvedAmount = $validated['amount'];
            $requisition->save(); 
        }
        

        if ($requisition) {
            // Check if the requisition is already approved
            if ($requisition->isActive == 0) {
                return response()->json([
                    'success' => false,
                    'message' => __('A paid requisition cannot be reverted to pending or denied.'),
                ]);
            }

            // Update the budget if status is approved
            $project = Project::findOrFail($requisition->project_id);
            if ($validated['status'] === 'approved') {
                if ($project) {
                    $budgetResult = $this->budgetDeductions($requisition, $project);
            
                    if (!$budgetResult['success']) {
                        // \Log::error($budgetResult['message']);
                        return response()->json([
                            'success' => false,
                            'message' => $budgetResult['message'], 
                        ]);
                    }

                    // Proceed only if budget deductions were successful
                    $requisition->status = 'approved';
                    $requisition->reasons = $validated['reasons'];
                    $requisition->save();

                    $this->requisitionStatusMail($project, $requisition, 'approved');
                
                }
            } else {
                $requisition->status = $validated['status'];
                $requisition->reasons = $validated['reasons'];

                $requisition->save();
                $this->requisitionStatusMail($project, $requisition, $validated['status']);

            }
            return response()->json([
                'success' => true,
                'message' => __('Requisition updated successfully'),
            ]);
        }

        // If requisition not found or status update failed
        return response()->json([
            'success' => false,
            'message' => __('Requisition not found or status update failed because it night have been approved!'),
        ]);
    }

    function generateVoucherNumber()
    {
        // Prefix for payment vouchers
        $prefix = 'BECL';

        // Current date in YYYYMMDD format
        $date = now()->format('Ymd');

        // Generate a unique identifier (e.g., random number or incrementing ID)
        // Check for uniqueness in the database to avoid duplication
        do {
            $uniqueId = Str::padLeft(random_int(1, 99999), 5, '0'); // Generate a random 5-digit number
            $voucherNumber = "{$prefix}-{$date}-{$uniqueId}";
        } while (DB::table('requistions')->where('voucher', $voucherNumber)->exists());

        return $voucherNumber;
    }


    private function requisitionStatusMail($project, $requisition, $action)
    {
        if (getMailOptions('mail_status') === 'enabled') {
            // Define email content
            $user = User::findOrFail($requisition->created_by);
            $companyName = getMailOptions('app_name');
            $subject = sprintf(
                'Update on Requisition %s for %s Project',
                $requisition->name,
                $project->projectName
            );
    
            // Include reason in the message
            $reasonText = $requisition->reasons 
                ? sprintf("\nReason: %s\n", $requisition->reasons) 
                : "\nNo reason was provided for this status update.\n";
    
            // Customize message based on action
            switch ($action) {
                case 'approved':
                    $emailMessage = sprintf(
                        "Hello %s,\n\nGood news! Your requisition for the project '%s' has been approved.\n".
                        "%sYou can proceed with the next steps, i.e., request the accountant to make payments to you as outlined in the project guidelines.\n\nThank you,\n%s",
                        $user->name,
                        $project->projectName,
                        $reasonText,
                        $companyName
                    );
                    break;
    
                case 'pending':
                    $emailMessage = sprintf(
                        "Hello %s,\n\nYour requisition for the project '%s' is currently pending review.\n".
                        "%sYou will be notified once the status is updated. Please ensure all necessary details are provided to avoid delays.\n\nThank you,\n%s",
                        $user->name,
                        $project->projectName,
                        $reasonText,
                        $companyName
                    );
                    break;
    
                case 'denied':
                    $emailMessage = sprintf(
                        "Hello %s,\n\nUnfortunately, your requisition for the project '%s' has been denied.\n".
                        "%sKindly review the feedback provided and make adjustments if necessary. For further clarification, feel free to reach out.\n\nThank you,\n%s",
                        $user->name,
                        $project->projectName,
                        $reasonText,
                        $companyName
                    );
                    break;
    
                default:
                    $emailMessage = sprintf(
                        "Hello %s,\n\nThis is an update regarding your requisition for the project '%s'.\n".
                        "%sPlease contact the project team for more details.\n\nThank you,\n%s",
                        $user->name,
                        $project->projectName,
                        $reasonText,
                        $companyName
                    );
                    break;
            }
    
            $accountants = User::role('accountant')->get();  // Get all users with the accountant role
            if ($accountants) {
                $accountantEmailMessage = sprintf(
                    "Hello,\n\nThe requisition for the project '%s' has been approved and is requesting payment.\n".
                    "Please proceed with the payment steps outlined in the project guidelines.\n\nThank you,\n%s",
                    $project->projectName,
                    $companyName
                );
    
                foreach ($accountants as $accountant) {
                    // Send email to each accountant
                    Mail::to($accountant->email)->send(new removeOrAddUserMail([
                        'subject' => $subject,
                        'emailMessage' => $accountantEmailMessage,
                        'companyName' => $companyName,
                        'username' => $accountant->name,
                        'projectName' => $project->projectName,
                    ]));
                }
            }
    
            $content = [
                'subject' => $subject,
                'emailMessage' => $emailMessage, // Use this key
                'companyName' => $companyName,
                'username' => $user->name,
                'projectName' => $project->projectName,
            ];
    
            // Send email to the user
            Mail::to($user->email)->send(new removeOrAddUserMail($content));
        }
    }
    
    
    private function budgetDeductions($requisition, $project)
    {
        // Validate requisition amount that has to be approved by MD
        if (!isset($requisition->approvedAmount) || !is_numeric($requisition->approvedAmount) || $requisition->approvedAmount <= 0) {
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

        // Calculate the new budget if approved
        $newProjectBudget = $project->projectBudget - $requisition->approvedAmount;


        // Check if the expenditure(What has already been spent on a particular project) exceeds the budget limit
        $project_expenditure = ProjectExpense::where('project_id', $project->id)->sum('approved_amount');
        
        $expected_expenditure = $project_expenditure + $requisition->approvedAmount;
        // \Log::info($expected_expenditure);
        if ($expected_expenditure > $project->projectBudgetLimit) {
            // \Log::info('Budget limit exceeded. Requisition: ' . json_encode($requisition));
            $this->budgetLimitMail($requisition, $project);
            return [
                'success' => false,
                'message' => __('The approval of this requisition will surpass/exceed the budget limit.'),
            ];
        }


        // Only accountant can cashout or make payments
        if (Auth::user()->hasRole('accountant')) {
            
            $voucherNumber = $this->generateVoucherNumber();
            $requisition->voucher  = $voucherNumber;
            $requisition->paid_by  = Auth::user()->id;
            $requisition->save();
            
            // Update the project budget
            $project->update([
                'projectBudget' => $newProjectBudget,
            ]);

            $project_expenses = ProjectExpense::create([
                'project_id' => $project->id,
                'requested_by' => $requisition->created_by,
                'approved_amount' => $requisition->approvedAmount,
            ]);

            // Send mail to project manager and director
            $accountantName = Auth::user()->name;
            $recipients = User::whereIn('role', ['project_manager', 'director'])->pluck('email');
            
            // $voucherNumber = $this->generateVoucherNumber();
            // $requisition->update([
            //     'voucher' => $voucherNumber,
            // ]);
            

            $requisition_items = RequisitionItem::where('requisition_id', $requisition->id)->get();
            // \Log::info($requisition_items);
            
            foreach ($recipients as $email) {
                Mail::to($email)->send(new RequisitionProcessedMail([
                    'projectName' => $project->projectName,
                    'requisitionName' => $requisition->name,
                    'accountantName' => $accountantName,
                    'requisition_items' => $requisition_items,
                    'approvedAmount' => $requisition->approvedAmount,
                    'voucher_number' => $voucherNumber,
                ]));
            }
            
            return [
                'success' => true,
                'message' => __('Project budget updated successfully.'),
            ];
        }

        // \Log::info('Project budget updated successfully: ' . json_encode([
        //     'project_id' => $project->id,
        //     'old_budget' => $project->projectBudget + $requisition->amount,
        //     'new_budget' => $newProjectBudget,
        // ]));

        return [
            'success' => true,
            'message' => __('Requisition status approved successfully.'),
        ];
    }
    
    private function budgetLimitMail($requisition, $project)
    {
        if (getMailOptions('mail_status') === 'enabled') {
            // Fetch the relevant users
            $users = User::whereIn('role', ['director', 'project_manager'])->get();

            // Define email content
            $companyName = getMailOptions('app_name');
            $subject = sprintf(
                'Budget Limit Exceeded for %s Requisition, Amount: %s %s',
                $requisition->name,
                $requisition->approvedAmount,
                $project->currency->name
            );
            $message = sprintf(
                "Project '%s' has a budget limit of %s. However, when requisition '%s' is approved, this limit will be exceeded.\n\n".
                "Details:\n".
                "- Requisition Amount: %s %s\n".
                "- Description: %s\n\n".
                "Kindly review the requisition details to make an informed decision.",
                $project->projectName,
                $project->projectBudgetLimit,
                $requisition->name,
                $requisition->approvedAmount,
                $project->currency->name,
                $requisition->description
            );

            $content = [
                'subject' => $subject,
                'message' => $message,
                'companyName' => $companyName,
                'projectName' => $project->projectName,
                'projectBudgetLimit' => $project->projectBudgetLimit,
                'requisitionName' => $requisition->name,
                'requisitionAmount' => $requisition->approvedAmount,
                'currency' => $project->currency->name,
                'description' => $requisition->description,
            ];

            // Send email to all relevant users
            foreach ($users as $user) {
                Mail::to($user->email)->send(new BudgetLimitMail($content));
            }
        }
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
