<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;


class ExchangeRateController extends Controller
{
    protected Request $request;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = $request->date ?? date('Y-m-d');
        $exchangeRates = ExchangeRate::where('date', '=', $date)->get(['currency','date','amount']);
        return response()->json($exchangeRates);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = $request->date ?? date('Y-m-d');
        $exchangeData = $request->all() + ['date' => $date];
        $exchangeRate = ExchangeRate::create($exchangeData);

        return response()->json([
            'status' => true,
            'message' => "ExchangeRate Created successfully!",
            'exchange_rate' => $exchangeRate
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $date = $request->date ?? date('Y-m-d');
        $currency = $request->currency ?? null;
        $exchangeRate = new ExchangeRate();
        $exchangeRates = $exchangeRate
            ->where('date', '=', $date)
            ->where('currency', '=', $currency)
            ->get(['currency','date','amount']);

        if($exchangeRates->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => sprintf('ExchangeRate with currency : %s not found', $request->currency)
            ], 404);
        }

        return response()->json($exchangeRates);
    }

}