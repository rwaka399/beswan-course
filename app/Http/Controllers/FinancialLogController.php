<?php

namespace App\Http\Controllers;

use App\Models\FinancialLog;
use Illuminate\Http\Request;

class FinancialLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('financial_logs.index', [
            'financial_logs' => FinancialLog::all(),
        ]);
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
    }

    /**
     * Display the specified resource.
     */
    public function show(FinancialLog $financialLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinancialLog $financialLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinancialLog $financialLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinancialLog $financialLog)
    {
        //
    }
}
