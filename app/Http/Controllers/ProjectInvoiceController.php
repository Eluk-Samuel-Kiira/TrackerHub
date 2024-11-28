<?php

namespace App\Http\Controllers;

use App\Models\ProjectInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $projectInvoice = ProjectInvoice::create([
            'project_id' => $request->projectId,
            'client_id' => $request->ClientId,
            'description' => $request->invoiceDescription,
            'amount' => $request->invoiceAmount,
            'billing_date' => $request->invoiceBilledDate,
            'due_date' => $request->invoiceDueDate,
            'createdBy' => Auth::user()->id
        ]);

        //send mail notificaton here

        if($projectInvoice){
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Project Invoice Added to project successfully.',
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
    public function update(Request $request, ProjectInvoice $projectInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectInvoice $projectInvoice)
    {
        //
    }
}
