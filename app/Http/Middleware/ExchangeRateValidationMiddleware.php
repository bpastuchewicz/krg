<?php

namespace App\Http\Middleware;

use App\Models\ExchangeRate as ExchangeRateModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ExchangeRateValidationMiddleware
{
    private const SUPPORTED_CURRENCIES = ['USD', 'GBP', 'EUR'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $validateFields = $this->validateFields($request);
        if ($validateFields->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateFields->errors()
            ], 400);
        }

        if (!$this->validateCurrency($request->currency)) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => ['currency' => 'Currency should be one of following: USD, GPB, EUR']
            ], 400);
        }

        if (!$this->validateModel($request)) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => ['model' => sprintf('Echange rate for currency %s and date %s exists in database', $request->currency, $request->date)]
            ], 400);
        }

        return $next($request);
    }

    /**
     *
     * @param string $currency
     * @return bool
     */
    private function validateCurrency(string $currency): bool
    {
        return in_array($currency, self::SUPPORTED_CURRENCIES);
    }


    /**
     *
     * @param Request $request
     * @return \Illuminate\Validation\Validator
     */
    private function validateFields(Request $request): \Illuminate\Validation\Validator
    {
        return Validator::make(
            $request->all(),
            [
                'currency' => 'required',
                'amount' => 'required|numeric|between:0,99.99',
                'date' => 'date_format:Y-m-d'
            ]
        );
    }

    /**
     *
     * @param Request $request
     * @return bool
     */
    private function validateModel(Request $request): bool
    {
        $date = $request->date ?? date('Y-m-d');
        return ExchangeRateModel::select('id')
            ->where('currency', '=', $request->currency)
            ->where('date', '=', $date)
            ->doesntExist();
    }
}
