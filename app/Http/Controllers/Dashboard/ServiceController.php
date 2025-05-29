<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ServiceRequest;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Provedor;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $provedores = Provedor::where('status', 1)->get();
        
        return view('dashboard.services.create', [
            'categories' => $categories,
            'provedores' => $provedores
        ]);
    }
    public function edit(Plan $plan){
        
        $categories = Category::all();
        $provedores = Provedor::where('status', 1)->get();
        
        return view('dashboard.services.edit', [
            'categories' => $categories,
            'provedores' => $provedores,
            'service' => $plan
        ]);
    }
    public function active(Plan $plan){
        $plan->isActive = 1;
        $plan->save();
        
        return redirect()->back()->withSuccess('Ativado com sucesso!');
    }
    public function desactive(Plan $plan){
        $plan->isActive = 0;
        $plan->save();
        
        return redirect()->back()->withSuccess('Desativado com sucesso!');
    }
    public function store(ServiceRequest $request)
    {
        $plan = Plan::create($request->all());

        return redirect()->back()->withSuccess('Cadastrado com sucesso!');
    }
    public function update(ServiceRequest $request, Plan $plan)
    {
        $plan = Plan::find($plan->id);
        $plan->title = $request->input('title');
        //$plan->quantityOption = $request->input('quantityOption');
        $plan->type = $request->type;
        $plan->provedor = $request->input('provedor');
        $plan->id_provedor = $request->input('id_provedor');
        $plan->price = $request->input('price');
        $plan->quantity_min = $request->input('quantity_min');
        $plan->quantity = $request->input('quantity');
        $plan->category_id = $request->input('category_id');
        $plan->save();
        
        //dd($request->all(), $plan);
        return redirect()->back()->withSuccess('Atualizado com sucesso!');
    }
    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect()->back()->withSuccess('Removido com sucesso!');
    }
    
    public function getDetalhePano(Request $request)
    {

        $plan = [];
        if(isset($request->plan_id)){
            $plan = Plan::find($request->plan_id);
        }

        echo json_encode(['plan' => $plan]);
    }
    
}
