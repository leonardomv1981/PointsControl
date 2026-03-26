<?php

namespace App\Http\Controllers;

use App\Models\Balances;
use App\Models\Programs;
use App\Models\SignatureClub;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $idUsuario = Auth::user()->id;
        $data['programs'] = Programs::where('id_user', $idUsuario)
        ->where('programs.status', 'active')
        ->orderBy('program_name', 'asc')
        ->join('balances', 'programs.id', '=', 'balances.id_program')
        ->select('programs.*', 'balances.total_points')
        ->get();
        $data['user'] = User::where('id', Auth::user()->id)
        ->where('status', 'active')
        ->select( 'id', 'first_name', 'language', 'currency', 'date_format')
        ->first();
        return view('transactions.add', compact('data'));
    }

    public function save(Request $request)
    {
        $action = $request['data']['transactions']['type'];
        $data = $request['data']['transactions'];

        switch ($action) {
            case 'credit':

                $checkOwner = Programs::where('id_user', Auth::user()->id)
                ->where('id', $data['credit']['id_program'])
                ->where('status', 'active')
                ->exists();

                if (!$checkOwner) {
                    $data['error'] = __('transactions.programNotFound');
                }

                if($data['credit']['date'] == null) {
                    $data['error'] = __('general.dateRequired');
                } else if (!is_numeric($data['credit']['id_program'])) {
                    $data['error'] = __('general.programRequired');
                } else if ($data['credit']['points'] == null || $data['credit']['points'] == 0) {
                    $data['error'] = __('general.pointsRequired');
                };
                if (isset($data['error'])) {
                    $idUsuario = Auth::user()->id;
                    $data['programs'] = Programs::where('id_user', $idUsuario)
                    ->where('programs.status', 'active')
                    ->orderBy('program_name', 'asc')
                    ->join('balances', 'programs.id', '=', 'balances.id_program')
                    ->select('programs.*', 'balances.total_points')
                    ->get();
                    $data['user'] = User::where('id', Auth::user()->id)
                    ->where('status', 'active')
                    ->select( 'id', 'first_name', 'language', 'currency', 'date_format')
                    ->first();

                    return view('transactions.add', compact('data'));
                };

                if ($data['credit']['value_points'] == null) {
                    $data['credit']['value_points'] = 0;
                } else if ($data['currency'] == 'brl') {
                    $data['credit']['value_points'] = str_replace(['R$', " \u{A0}"], '', $data['credit']['value_points']);
                    $data['credit']['value_points'] = str_replace('.', '', $data['credit']['value_points']);
                    $data['credit']['value_points'] = str_replace(',', '.', $data['credit']['value_points']);
                } else if ($data['currency'] == 'usd') {
                    $data['credit']['value_points'] = str_replace(['$', "\u{A0}", ' '], '', $data['credit']['value_points']);
                    $data['credit']['value_points'] = str_replace(',', '', $data['credit']['value_points']);
                }
                $data['credit']['status'] = 'active';

                $data['credit']['points'] = str_replace('.', '', $data['credit']['points']);

                $transaction = new Transactions();
                $transaction->id_program = $data['credit']['id_program'];
                $transaction->type = 'credit';
                $transaction->date = $data['credit']['date'];
                $transaction->points = $data['credit']['points'];
                $transaction->value_points = $data['credit']['value_points'];
                $transaction->description = $data['credit']['description'];
                $transaction->save();

                $balance = Balances::find($data['credit']['id_program']);
                $balance->total_points = $balance->total_points + $data['credit']['points'];
                $balance->total_value = $balance->total_value + $data['credit']['value_points'];
                $balance->save();

                return redirect()->route('programs.index', ['locale' => $request->route('locale')]);
                
                break;
            case 'debit':
                $data['debit']['points'] = str_replace('.', '', $data['debit']['points']);

                if($data['debit']['date'] == null) {
                    $data['error'] = __('general.dateRequired');
                } else if (!is_numeric($data['debit']['id_program'])) {
                    $data['error'] = __('general.programRequired');
                } else if ($data['debit']['points'] == null || $data['debit']['points'] == 0) {
                    $data['error'] = __('general.pointsRequired');
                };

                $balance = Balances::find($data['debit']['id_program']);
                
                if ($balance->total_points < $data['debit']['points']) {
                    $data['error'] = __('transactions.insufficientBalance');
                }

                if (isset($data['error'])) {
                    $idUsuario = Auth::user()->id;
                    $data['programs'] = Programs::where('id_user', $idUsuario)
                    ->where('programs.status', 'active')
                    ->orderBy('program_name', 'asc')
                    ->join('balances', 'programs.id', '=', 'balances.id_program')
                    ->select('programs.*', 'balances.total_points')
                    ->get();
                    $data['user'] = User::where('id', Auth::user()->id)
                    ->where('status', 'active')
                    ->select( 'id', 'first_name', 'language', 'currency', 'date_format')
                    ->first();

                    return view('transactions.add', compact('data'));
                };

                
                $data['debit']['points'] = str_replace('.', '', $data['debit']['points']);

                $value = ($balance->total_value / $balance->total_points) * $data['debit']['points'];

                $transaction = new Transactions();
                $transaction->id_program = $data['debit']['id_program'];
                $transaction->type = 'debit';
                $transaction->date = $data['debit']['date'];
                $transaction->points = $data['debit']['points'];
                $transaction->value_points = $value;
                $transaction->description = $data['debit']['description'];
                $transaction->status = 'active';
                $transaction->save();

                if (!$transaction->save()) {
                    return redirect()->back()->withErrors(['msg' => __('transactions.saveError')]);
                }
                
                $balance->total_points = $balance->total_points - $data['debit']['points'];
                $balance->total_value = $balance->total_value - $value;
                $balance->save();

                if (!$balance->save()) {
                    return redirect()->back()->withErrors(['msg' => __('transactions.saveError')]);
                }

                return redirect()->route('programs.index', ['locale' => $request->route('locale')]);
            break;
            case 'transfer':

                $data['debit']['points'] = str_replace('.', '', $data['debit']['points']);
                $data['credit']['points'] = str_replace('.', '', $data['credit']['points']);

                if($data['transfer']['date'] == null) {
                    $data['error'] = __('general.dateRequired');
                } else if (!is_numeric($data['credit']['id_program'])) {                    
                    $data['error'] = __('general.programRequired');
                } else if (!is_numeric($data['debit']['id_program'])) {
                    $data['error'] = __('general.programRequired');
                } else if ($data['debit']['points'] == null || $data['debit']['points'] == 0) {
                    $data['error'] = __('general.pointsRequired');
                } else if ($data['credit']['points'] == null || $data['debit']['points'] == 0) {
                    $data['error'] = __('general.pointsRequired');
                };

                $originProgram = Programs::find($data['debit']['id_program']);
                $destinationProgram = Programs::find($data['credit']['id_program']);
                $balanceDebit = Balances::find($data['debit']['id_program']);
                $balanceCredit = Balances::find($data['credit']['id_program']);

                if ($balanceDebit->total_points < $data['debit']['points']) {
                    $data['error'] = __('transactions.insufficientBalance');
                }

                if (isset($data['error'])) {
                    $idUsuario = Auth::user()->id;
                    $data['programs'] = Programs::where('id_user', $idUsuario)
                    ->where('programs.status', 'active')
                    ->orderBy('program_name', 'asc')
                    ->join('balances', 'programs.id', '=', 'balances.id_program')
                    ->select('programs.*', 'balances.total_points')
                    ->get();
                    $data['user'] = User::where('id', )
                    ->where('status', 'active')
                    ->select( 'id', 'first_name', 'language', 'currency', 'date_format')
                    ->first();

                    $data['user'] = User::where('id', Auth::user()->id)
                    ->where('status', 'active')
                    ->select( 'id', 'first_name', 'language', 'currency', 'date_format')
                    ->first();

                    // dd($data);

                    return view('transactions.add', compact('data'));
                };

                $value = ($balanceDebit->total_value / $balanceDebit->total_points) * $data['debit']['points'];

                $transaction = new Transactions();
                $transaction->id_program = $data['debit']['id_program'];
                $transaction->type = 'debit';
                $transaction->date = $data['transfer']['date'];
                $transaction->points = $data['debit']['points'];
                $transaction->value_points = $value;
                $transaction->description = __('transactions.transferTo') . ' ' . $destinationProgram->program_name;
                $transaction->status = 'active';
                $transaction->save();

                $transaction2 = new Transactions();
                $transaction2->id_program = $data['credit']['id_program'];
                $transaction2->type = 'credit';
                $transaction2->date = $data['transfer']['date'];
                $transaction2->points = $data['credit']['points'];
                $transaction2->value_points = $value;
                $transaction2->description = __('transactions.transferFrom') . ' ' . $originProgram->program_name;
                $transaction2->status = 'active';
                $transaction2->save();

                $balanceCredit->total_points = $balanceCredit->total_points + $data['credit']['points'];
                $balanceCredit->total_value = $balanceCredit->total_value + $value;
                $balanceCredit->save();

                $balanceDebit->total_points = $balanceDebit->total_points - $data['debit']['points'];
                $balanceDebit->total_value = $balanceDebit->total_value - $value;
                $balanceDebit->save();
                
                return redirect()->route('transactions.add', ['locale' => $request->route('locale')]);
                // dd($data);
            break;
                
        }
        // dd($request);
        // $data = $request['data']['transaction'];
        // $program = Programs::find($data['program']);
        // $program->total_points = $program->total_points + $data['points'];
        // $program->save();
        // return redirect()->route('transactions.add', ['locale' => $request->route('locale')]);
    }

    public function delete(Request $request) {
        $data = $request->all();
        $transaction = Transactions::find($data['id']);
        
        $balance = Balances::where('id_program', $transaction->id_program)->get();
        if ($transaction->type == 'credit') {
            $balance[0]->total_points = $balance[0]->total_points - $transaction->points;
            $balance[0]->total_value = $balance[0]->total_value - $transaction->value_points;
        } else {
            $balance[0]->total_points = $balance[0]->total_points + $transaction->points;
            $balance[0]->total_value = $balance[0]->total_value + $transaction->value_points;
        }
        $resultBalance = $balance[0]->save();

        $transaction->status = 'deleted';
        $resultTransaction = $transaction->save();

        if (!$resultBalance || !$resultTransaction) {
            return response()->json(['status' => 'error', 'message' => __('transactions.saveError')], 500);
        } else {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'success']);
    }

    public static function checkSignatureDaily() {

        $today = (int) date('d');
        $lastDay = (int) date('t');

        if ($today === $lastDay) {
            $upperBound = $lastDay < 31 ? 31 : $today;
            $signaturePlans = SignatureClub::where('status', 'active')
                ->whereBetween('day', [$today, $upperBound])
                ->get();

            Log::info('inicia verificação de club dia: ' . $today . ' até dia: ' . $upperBound);
        } else {
            $signaturePlans = SignatureClub::where('status', 'active')
                ->where('day', $today)
                ->get();

            Log::info('inicia verificação de club dia: ' . $today);
        }

        foreach ($signaturePlans as $signaturePlan) {
            $balance = Balances::where('id_program', $signaturePlan->id_program)
            ->where('status' , 'active')
            ->get();

            if ($balance->isEmpty()) {
                Log::error('Erro: Saldo não encontrado para o programa ' . $signaturePlan->id_program . ' no dia ' . date('d') . ' com o signaturePlan id: ' . $signaturePlan->id);
                return;
            }

            if ($signaturePlan->club_value == null) {
                $valuePoints = 0;
            } else {
                $valuePoints = $signaturePlan->club_value;
            }

            $balance[0]->total_points = $balance[0]->total_points + $signaturePlan->points;
            $balance[0]->total_value = $valuePoints + $balance[0]->total_value;
            $balanceResult = $balance[0]->save();

            if (!$balanceResult) {
                Log::error('Erro ao salvar o saldo do programa ' . $signaturePlan->id_program . ' no dia ' . date('d') . ' com o signaturePlan id: ' . $signaturePlan->id);
                return;
            }

            $transaction = new Transactions();
            $transaction->id_program = $signaturePlan->id_program;
            $transaction->type = 'credit';
            $transaction->date = date('Y-m-d');
            $transaction->points = $signaturePlan->points;
            $transaction->value_points = $valuePoints;
            $transaction->description = __('transactions.signatureClub');
            $transaction->status = 'active';
            $transactionResult = $transaction->save();

            if (!$transactionResult) {
                Log::error('Erro ao salvar a transação do programa ' . $signaturePlan->id_program . ' no dia ' . date('d') . ' com o signaturePlan id: ' . $signaturePlan->id);
                return;
            }

            Log::info('Clube de assinatura lançado com sucesso para o programa ' . $signaturePlan->id_program . ' no dia ' . date('d') . ' com o signaturePlan id: ' . $signaturePlan->id);

        }
    }
}
