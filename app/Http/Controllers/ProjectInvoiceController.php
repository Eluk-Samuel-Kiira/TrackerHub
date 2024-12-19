<?php

namespace App\Http\Controllers;

use App\Models\ProjectInvoice;
use App\Models\Project;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\removeOrAddUserMail; 


class ProjectInvoiceController extends Controller
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
        $request->validate([
            'projectId' => 'required',
            'ClientId' => 'required',
            'invoiceDescription' => 'required|string',
            'invoiceAmount' => 'required|numeric',
            'invoiceBilledDate' => 'required|date',
            'invoiceDueDate' => 'required|date',
        ]);

        $referenceNumber = 'INV-' . now()->format('Ymd') . '-' . strtoupper(uniqid());

        $projectInvoice = ProjectInvoice::create([
            'project_id' => $request->projectId,
            'client_id' => $request->ClientId,
            'description' => $request->invoiceDescription,
            'amount' => $request->invoiceAmount,
            'billing_date' => $request->invoiceBilledDate,
            'due_date' => $request->invoiceDueDate,
            'createdBy' => Auth::user()->id,
            'reference_number' => $referenceNumber,
        ]);

        //send mail notificaton here

        if($projectInvoice){
            $this->resend($projectInvoice->id);
            // session()->flash('toast', [
            //     'type' => 'success',
            //     'message' => 'Project Invoice Added to project successfully.',
            // ]);
            return response()->json([
                'success' => true,
                'message' => __('Project Created Successfully'),
            ]);
        }else{
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Failed to add the invoice to the project.',
            ]);
        }

        return redirect(url('projects/'.$request->projectId.'#invoices'))->with('project', $request->projectId);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectInvoice $projectInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectInvoice $projectInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request
        $request->validate([
            'paidBy' => 'required|numeric',
            'paidOn' => 'required|date',
            'invoiceId' => 'required|numeric',
        ]);

        // Find the specified invoice
        $projectInvoice = ProjectInvoice::find($request->invoiceId);

        if (!$projectInvoice) {
            return response()->json([
                'success' => false,
                'message' => __('Invoice not found'),
            ], 404);
        }

        // Update the invoice details
        $projectInvoice->update([
            'paidBy' => $request->paidBy,
            'paidOn' => $request->paidOn,
            'isPaid' => 1,
            'isActive' => 0, // Assuming the invoice is no longer active after being paid
        ]);

        // Find the associated project
        $project = Project::find($projectInvoice->project_id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => __('Project not found'),
            ], 404);
        }

        $actualAmountPaid = $project->invoices()->where('isPaid', 1)->sum('amount');

        // Check if the project is fully paid off
        if ($actualAmountPaid >= $project->projectCost) {
            $project->txn_status = 'paid';
            $project->isPaidOff = 1; // Indicates the project is fully paid
        }

        // Check if the project is fully paid and completed
        if ($project->isPaidOff == 1 && $project->completionStatus == 1) {
            $project->isActive = 0; // Indicates the project is fully paid and completed
        }

        // Save project only once after updating the necessary fields
        $project->save();

        return response()->json([
            'success' => true,
            'message' => __('Invoice Paid Successfully'),
        ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $projectInvoice = ProjectInvoice::findOrFail($id);

        // Prevent deletion if the invoice is paid
        if ($projectInvoice->isPaid && $projectInvoice->paidOn) {
            return response()->json([
                'success' => false,
                'message' => __('An already paid invoice cannot be deleted.'),
            ]);
        }

        // Delete the invoice and return success response
        $projectInvoice->delete();

        return response()->json([
            'success' => true,
            'message' => __('Invoice deleted successfully.'),
        ]);
    }


    public function resend($id)
    {
        try {
            $invoice = ProjectInvoice::findOrFail($id);

            $project = Project::findOrFail($invoice->project_id);
            $user = Client::findOrFail($invoice->client_id);
            $this->invoiceMail($project, $invoice, $user);

            return response()->json([
                'success' => true,
                'message' => __('Invoice sent successfully.'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Invoice Mail Fail.'),
            ]);
        }
    }

    
    private function invoiceMail($project, $invoice, $user)
    {
        if (getMailOptions('mail_status') === 'enabled') {
            $companyName = getMailOptions('app_name');
            $subject = sprintf(
                'Invoice for %s Project',
                $project->projectName
            );

            $emailMessage = sprintf(
                "Hello %s,\n\nThis is a reminder that the invoice for the '%s' project is available. Please find the details below:\n\n".
                "Invoice ID: %s\n".
                "Amount: $%s\n".
                "Due Date: %s\n\n".
                "If you have any questions or concerns, please feel free to contact us.\n\nThank you,\n%s",
                $user->name,
                $project->projectName,
                $invoice->id,
                $invoice->amount,
                \Carbon\Carbon::parse($invoice->due_date)->format('F j, Y'),
                $companyName
            );

            $content = [
                'subject' => $subject,
                'emailMessage' => $emailMessage,
                'companyName' => $companyName,
                'username' => $user->name,
                'projectName' => $project->projectName,
            ];

            // Send the email using the Mailable class
            Mail::to($user->email)->send(new removeOrAddUserMail($content));
        }
    }

}
