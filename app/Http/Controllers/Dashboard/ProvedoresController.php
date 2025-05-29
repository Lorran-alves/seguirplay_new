<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Provedor;
use Illuminate\Http\Request;

class ProvedoresController extends Controller
{
    public function index()
    {
        $provedores = Provedor::all();

        return view('dashboard.provedores.index', [
            'provedores' => $provedores
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // die;

        return view('dashboard.provedores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        $provedor = Provedor::where('valor', $request->valor)->first();
        if(isset($provedor->name)) {
            return redirect()->back()->withSuccess('Valor já ultilizado por outra api!');
        }

        Provedor::create($request->all());

        return redirect()->back()->withSuccess('Cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provedor  $provedor
     * @return \Illuminate\Http\Response
     */
    public function show(Provedor $provedor)
    {
        //
    }


    public function edit($id)
    {
        $provedor = Provedor::find($id);

        return view('dashboard.provedores.edit', ['provedor' => $provedor]);
    }


    public function active($id){

        $provedor = Provedor::find($id);
        $provedor->status = 1;
        $provedor->save();
        
        return redirect()->back()->withSuccess('Ativado com sucesso!');

    }

    public function desactive($id){
        

        $provedor = Provedor::find($id);
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

        $provedor = Provedor::find($id);
      
        $provedor->name = $request->input('name');
        $provedor->token = $request->input('token');
        $provedor->url =$request->input('url');
        $provedor->valor =$request->input('valor');
        $provedor->status = $request->input('status');
       
        $provedor->save();
        
        return redirect()->back()->withSuccess('Atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provedor  $provedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provedor $provedor)
    {
        //
    }
}
