<?php

namespace App\Http\Controllers;

use App\Models\InvoiceExportPDF;
use App\Http\Requests\StoreInvoiceExportPDFRequest;
use App\Http\Requests\UpdateInvoiceExportPDFRequest;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Customerjobs;
use App\Models\Customerjobservices;
use App\Models\Customerjoblogs;



class InvoiceExportPDFController extends Controller
{
    public function showinvoice($job_number)
    {
        $data['jobInvoiceDetails'] = Customerjobs::select('customerjobs.*')
            ->with(['customerInfo','customerVehicle','customerJobServices'])
            ->orderBy('customerjobs.id','DESC')
            ->where(['customerjobs.job_number'=>$job_number])
            ->first();
        return view('invoices',$data);

    }

    public function invoiceExportPDF($job_number)
    {
        $data['jobInvoiceDetails'] = Customerjobs::select('customerjobs.*')
            ->with(['customerInfo','customerVehicle','customerJobServices'])
            ->orderBy('customerjobs.id','DESC')
            ->where(['customerjobs.job_number'=>$job_number])
            ->first();
        $pdf = PDF::loadView('pdf.invoices', $data);
        return $pdf->download('invoce' . rand(1, 1000) . '.pdf');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInvoiceExportPDFRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceExportPDFRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceExportPDF  $invoiceExportPDF
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceExportPDF $invoiceExportPDF)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceExportPDF  $invoiceExportPDF
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceExportPDF $invoiceExportPDF)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceExportPDFRequest  $request
     * @param  \App\Models\InvoiceExportPDF  $invoiceExportPDF
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceExportPDFRequest $request, InvoiceExportPDF $invoiceExportPDF)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceExportPDF  $invoiceExportPDF
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceExportPDF $invoiceExportPDF)
    {
        //
    }
}
