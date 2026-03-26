<?php

use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

    Schedule::call(function () {
        Log::info('[CRON] Executando checkSignatureDaily às ' . now());
        TransactionsController::checkSignatureDaily();
    })
    ->timezone('America/Sao_Paulo')
    ->dailyAt('03:01');