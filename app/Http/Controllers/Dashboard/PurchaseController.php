<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Category;
use App\Http\Controllers\Dashboard\Dashboard;
use App\Http\Controllers\Web\WebController;
use App\Models\Order;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;


        $purchases = Purchase::where(function ($query) use ($search) {
            return $query->where('id', 'like', '%' . $search . '%')
                ->orWhere('purchase_pai_id', 'like', '%' . $search . '%')
                ->orWhere('profile', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('telefone', 'like', '%' . $search . '%')
                ->orWhere('period', 'like', '%' . $search . '%')
                ->orWhere('payment_id', 'like', '%' . $search . '%');
                
        });
        if($status){
            if($status == 'approved')
                $purchases = $purchases->where('status', 'approved') ->orWhere('status', 'send');
            if($status == 'pending')
                $purchases = $purchases->where('status', 'pending');
            if($status == 'cancelled')
                $purchases = $purchases->where('status', 'cancelled');
        }
        $purchases = $purchases->orderBy('id', 'desc')
            ->paginate(15);

        foreach($purchases as $p){
            $p->plan = Plan::find($p->plan_id);
            $p->plan->category = Category::find($p->plan->category_id);
        }
        ///dd($purchases);
        return view('dashboard.purchases.index', [
            'purchases' => $purchases,
            'request' => $request
        ]);
    }
    public function approved($purchase_id){
        $purchase = Purchase::find($purchase_id);
        $purchase->status = 'approved';
        $purchase->save();

        $web_controller = new WebController;
        //$web_controller->api_dashboard($purchase_id);

        return redirect()->back()->withSuccess('Aprovado com sucesso!');
    }
    public function destroy($purchase_id){

        $dashboard = new Dashboard;
        $dashboard->reajustarDashboard($purchase_id);

        Purchase::find($purchase_id)->delete();
        Order::where("purchase_id", $purchase_id)->delete();

        return redirect()->back()->withSuccess('Deletado com sucesso!');
    }

    public function edit($purchase_id)
    {

        $purchase = Purchase::find($purchase_id);
        //serviço que o usuario comprou
        $plan = $purchase->planActive;
        $categories = Category::all();

        // enviar resposta json 
        echo json_encode([
            'purchase' => $purchase,
            'plan' => $plan,
            'categories' => $categories
        ]);
    
    }

    public function update(Request $request)
    {
        $purchase = Purchase::find($request->purchase_id);
        $purchase->profile = $request->profile;
        $purchase->plan_id = $request->plan_id;
        $purchase->quantity = $request->quantity;
        $purchase->price = $request->price;

        $purchase->save();

        return redirect()->back()->withSuccess('Compra atualizada com sucesso!');
    }
    
    public function customersInactives(Request $request)
    {
        $search = $request->search;
        $mesesSemComprar = $request->mes ?? 2; // Pega o valor do select ou usa 2 como padrão

        $twoMonthsAgo = now()->subMonths($mesesSemComprar)->startOfDay();

        $purchases = Purchase::where('created_at', '<=', $twoMonthsAgo)
        ->whereNotIn('email', function ($query) {
            $query->select('email')
                ->from('purchases')
                ->where('created_at', '>', now()->subMonths(2));
        })
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhere('profile', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('telefone', 'like', '%' . $search . '%')
                    ->orWhere('period', 'like', '%' . $search . '%')
                    ->orWhere('purchase_pai_id', 'like', '%' . $search . '%')
                    ->orWhere('payment_id', 'like', '%' . $search . '%');
            });
        })
        ->orderBy('id', 'desc')
        ->paginate(15);

        foreach($purchases as $p){
            $p->plan = Plan::find($p->plan_id);
            $p->plan->category = Category::find($p->plan->category_id);
        }
        ///dd($purchases);
        return view('dashboard.purchases.customersInactives', [
            'purchases' => $purchases,
            'request' => $request
        ]);
    }
}
