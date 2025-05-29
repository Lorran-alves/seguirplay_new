<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Cupom;
use App\Models\CupomUnico;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request)
    {
        $category = Category::where('slug', $request->slug)->firstOrFail();
        $plans = $category->plans()->where('plans.isActive', 1)->orderBy('sequence', 'asc')->get();

       $cupons = $this->getCupons();

        return view('web.categories.show', [
            'category' => $category,
            'plans' => $plans,
            'cupons' => json_encode($cupons)

        ]);
    }

    //retorna todos os cupons ativos
    public function getCupons()
    {

        $cuponsCupom = Cupom::where('status', 1)
            ->where(function ($query) {
                $query->whereNull('apartir_de')
                    ->orWhere('apartir_de', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('validade')
                    ->orWhere('validade', '>=', now());
            })
            ->select('nome', 'desconto');

        $cuponsUnicos = CupomUnico::where('validade', 1)
            ->select('nome', 'desconto');

        //unindo as duas tabelas de cupons
        $cupons = $cuponsCupom->union($cuponsUnicos)->get()->toArray();

        return $cupons;
    }
}
