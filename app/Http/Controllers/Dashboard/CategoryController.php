<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Purchase;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('dashboard.categories.index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
       return view('dashboard.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());

        return redirect()->back()->withSuccess('Cadastrado com sucesso!');
    }

    public function show(Category $category)
    {
        $plans = $category->plans()->orderBy('sequence', 'asc')->get();

        return view('dashboard.categories.show', [
            'category' => $category,
            'plans' => $plans
        ]);
    }

    public function getServices(Category $category)
    {
        $plans = $category->plans()->where('plans.isActive', 1)->orderBy('sequence', 'asc')->get();

        echo json_encode(['plans' => $plans]);
    }

    public function getServicesMultiple(Request $request)
    {

        $plans = [];
        if(isset($request->categorias_id)){
            $categoriesIds = array_map('intval', $request->categorias_id);

            $plans = Plan::whereIn('category_id', $categoriesIds)
            ->where('isActive', 1) // Filtro para planos ativos
            ->orderBy('sequence', 'asc')
            ->get();

        }

        

        echo json_encode(['plans' => $plans]);
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provedor  $provedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
    
        // $ordem + 1 porque ordem começa com 0
        if ($request->has('sortedIds')) {
          
            $sortedIds = $request->sortedIds;
           
            foreach ($sortedIds as $ordem => $plan_id) {

                Plan::where('id', $plan_id)->update(['sequence' => $ordem + 1]);
            }
             
        }
        
    }

    
    public function destroy(Category $category)
    {
        $plans = $category->plans()->get();
        foreach($plans as $plan){
            $purchases = $plan->hasMany(Purchase::class)->get();
            foreach($purchases as $purchase){
                $purchase->delete();
            }
            $plan->delete();
        }
        $category->delete();
        return redirect()->back()->withSuccess('Removido com sucesso!');
    }
}
