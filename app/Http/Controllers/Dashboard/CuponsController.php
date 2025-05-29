<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Cupom;
use App\Models\Plan;
use Illuminate\Http\Request;

class CuponsController extends Controller
{
    public function index()
    {
        $cupons = Cupom::all();

        return view('dashboard.cupons.index', [
            'cupons' => $cupons
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.cupons.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cupom = Cupom::where('nome', $request->nome)->first();
        
        // Converte o nome do cupom para maiúsculas antes de salvar
        $request->merge(['nome' => strtoupper($request->nome)]);

        if(isset($cupom->nome)) {
            return redirect()->back()->withErrors(['error' => 'Nome do cupom já utilizado']);
        }

        $categoriasSelecionadas = isset($request->categorias_id) ? implode(',', $request->categorias_id) : null;
        $plansSelecionados = isset($request->plans) ? implode(',', $request->plans) : null;
    
        // Cria o cupom com os valores fornecidos
        Cupom::create($request->only(['nome', 'desconto', 'status', 'apartir_de', 'validade', 'only_by_email', 'limited_email']) + [
            'categories_id' => $categoriasSelecionadas,
            'plans_id' => $plansSelecionados
        ]);

        return redirect()->back()->withSuccess('Cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provedor  $provedor
     * @return \Illuminate\Http\Response
    */
    public function show(Cupom $cupom)
    {
        //
    }


    public function edit($id)
    {
        $cupom = Cupom::find($id);
        $categories = Category::all();
        $selectedCategories = explode(',', $cupom->categories_id);
        $selectedPlans = explode(',', $cupom->plans_id);
        $plans = Plan::whereIn('id', $selectedPlans)->get();

        return view('dashboard.cupons.edit', [
            'cupom' => $cupom,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories,
            'selectedPlans' => $selectedPlans,
            'plans' => $plans
        ]);
    }


    public function active($id){

        $provedor = Cupom::find($id);
        $provedor->status = 1;
        $provedor->save();
        
        return redirect()->back()->withSuccess('Ativado com sucesso!');

    }

    public function desactive($id){
        

        $provedor = Cupom::find($id);
        $provedor->status = 0;
        $provedor->save();
        
        return redirect()->back()->withSuccess('Desativado com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provedor  $provedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cupom = Cupom::find($id);

        // Converte o nome do cupom para maiúsculas antes de salvar
        $request->merge(['nome' => strtoupper($request->nome)]);

        //verifica se tem categorias/planos selecionado
        $categoriasSelecionadas = isset($request->categorias_id) ? implode(',', $request->categorias_id) : null;
        $plansSelecionados = isset($request->plans_id) ? implode(',', $request->plans_id) : null;
    
        $cupom->update($request->only(['nome', 'desconto', 'status', 'apartir_de', 'validade', 'only_by_email', 'limited_email']) + [
            'categories_id' => $categoriasSelecionadas,
            'plans_id' => $plansSelecionados
        ]);
    
        return redirect()->back()->withSuccess('Atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provedor  $provedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cupom $cupom)
    {
        //
    }
}
