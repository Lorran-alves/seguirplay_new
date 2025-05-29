<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MonetizaController extends Controller
{
    protected $banco = 'seguir00_monetize';
    // protected $banco_local = 'seguirplay_combo';

    public function index(Request $request)
    {

        $search = $request->search;
        $status = $request->status;

        $query = DB::table($this->banco . '.compras as c')
            ->select('c.id as compra_id', 'c.criado_em as data_compra' , 'c.*', 's.*')
            ->join($this->banco . '.servicos as s', 's.id', '=', 'c.servico')
            ->when($search, function ($query) use ($search) {
                return $query->where('c.id', 'like', '%' . $search . '%')
                    ->orWhere('c.profile', 'like', '%' . $search . '%')
                    ->orWhere('c.email', 'like', '%' . $search . '%');
            })
            ->when($status, function ($query) use ($status) {
                if ($status == 'approved') {

                    return $query->whereIn('c.status', ['approved', 'send']);

                } elseif ($status == 'pending') {

                    return $query->where('c.status', 'pending');

                } else {

                    return $query;

                }
            })
            ->orderBy('c.id', 'desc')
            ->paginate(15);

        return view('dashboard.monetiza.compras', [
            'purchases' => $query,
            'request' => $request
        ]);
    }

    public function approved($compra_id){


        // Aprovar a compra diretamente no banco de dados
        DB::table($this->banco . '.compras')
        ->where('id', $compra_id)
        ->update(['status' => 'approved']);


        return redirect()->back()->withSuccess('Aprovado com sucesso!');

    }

    public function destroy($purchase_id)
    {
        // Excluir a compra diretamente no banco de dados
        DB::table($this->banco . '.compras')->where('id', $purchase_id)->delete();

        return redirect()->back()->withSuccess('Deletado com sucesso!');
    }


    public function gestaoMonetiza()
    {
        $dashboard = new Dashboard;
        $period = $dashboard->getPeriod();

        $total_preco = DB::table($this->banco . '.compras')
        ->select(DB::raw('SUM(preco) as total_preco'))
        ->whereNotIn('status',  ['pending', 'cancelled'])
        ->where('period',  $period)
        ->first();

        $totalClientes = DB::table($this->banco . '.compras')
        ->where('period',  $period)
        ->distinct()
        ->count('email');

        return view('dashboard.metrics.gestaoMonetiza', [
        'totalClientes' => $totalClientes,
        'totalVendas' => $total_preco->total_preco,
        'period' => $period,
        ]);
    }


}
