<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\WebController;
use App\Models\Category;
use App\Models\Coment;
use App\Models\Cupom;
use App\Models\CupomUnico;
use App\Models\Plan;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MercadoPago\SDK;
use MercadoPago\Payment;

class GestorPedidoManualController extends Controller
{
    public function index()
    {  
        $categories = Category::all();
   
        return view('dashboard.gestaoPedidoManual.index', [
            'categories' => $categories,

        ]);
    }

    public function gerarPix(Request $request)
    {
        
        $periodo = $this->getPeriod();

        $plan = Plan::find($request->plano_id);

        //começa com falso
        $buyWithCoupon = false;
        session_start();
        $_SESSION['pedido'] = $request->email;
        $purchase = new Purchase();
        $purchase->plan_id = $plan->id;
        $purchase->type_purchase = 'M';
        $purchase->email = $request->email;
        $purchase->telefone = $request->telefone;
        $purchase->profile = $request->profile;
    

        //por padrão o preço é sem o cupom
        $purchase->price = (empty($plan->quantity_min) ? $plan->price : $plan->price * $request->quantity);

        $purchase->price_sale = (empty($plan->quantity_min) ? $plan->price : $plan->price * $request->quantity);

        $purchase->price_tot = (empty($plan->quantity_min) ? $plan->price : $plan->price * $request->quantity);


        // APLICA CUPOM CASO NÃO VIM VAZIO'
        if(isset($request->cupom) && !empty($request->cupom)) {

            $cupomDigitado = strtoupper($request->cupom);
            
            //pega categoria
            $categoria = Category::where('id', $plan->category_id)->first();
            $cupomRequest = new Request([
                'cupom' => $cupomDigitado,
                'categoria' => $categoria->id ?? 0,
                'plan' => $plan->id ?? 0,
                'email' => $request->email ?? null,
            ]);

            $webController = new WebController();
            $resultadoCupom = $webController->verificarCupom($cupomRequest);

            $resultadoCupom = json_decode($resultadoCupom);

            //verifica se o cupom está valido
            if(isset($resultadoCupom->desconto)){
                $valorOriginal = (empty($plan->quantity_min) ? $plan->price : $plan->price * $request->quantity);
                $descontoPorcentagem = $resultadoCupom->desconto / 100; // Usa o desconto do banco
                $purchase->price = $valorOriginal - ($valorOriginal * $descontoPorcentagem);

                $buyWithCoupon = true;
            }
        } 

        $purchase->quantity = $request->quantity;
        $purchase->payment_method = 'pix';
        $purchase->period = $periodo;
        $purchase->payment_id = 0;
        $purchase->termos_id = 4;
        $purchase->politicas_id = 2;
        $purchase->save();

        // comprou com cupom
        if($buyWithCoupon){
            DB::table('venda_cupom')->insert([
                'nome_cupom' => $request->cupom,
                'compra_id' => $purchase->id,
            ]);
        }


        for($i = 1; $i <= $request->cmnt_q ?? 1; $i++){
            $coment = new Coment();
            $coment->purchase_id = $purchase->id;
            $coment->coment =  $request->input('cmnt_'.$i);
            $coment->save();
        }
       
        SDK::setAccessToken('APP_USR-1862735257368010-072921-bfafa63d92f95d243e36b72dee54b99f-177082211');
        
        $payment = new Payment();
  		$payment->description = "Seguir Play #{$purchase->id}";
  		$payment->transaction_amount = (double) round($purchase->price,2);
  		$payment->payment_method_id = "pix";

        $payment->notification_url = route('webhooks', [$purchase->id]);
        $payment->external_reference = $purchase->id;

  			$payment->payer = array(
  				"email" => $purchase->email,
  				"first_name" => $purchase->email,
  				"address"=>  array(
  					"zip_code" => "06233200",
  					"street_name" => "Av. das Nações Unidas",
  					"street_number" => "3003",
  					"neighborhood" => "Bonfim",
  					"city" => "Osasco",
  					"federal_unit" => "SP"
  				)
  			);

  			$payment->save();
		
        $payment->point_of_interaction->purchase = $purchase->id;
        echo json_encode($payment->point_of_interaction);
        
    }


    public function gerarPixCart(Request $request)
    {
    
        
        $cart = isset($_COOKIE['cartDashboard']) ? json_decode($_COOKIE['cartDashboard'], true) : [];
        $user = isset($_COOKIE['userCartDashboard']) ? json_decode($_COOKIE['userCartDashboard'], true) : [];

        //começa com falso
        $buyWithCoupon = false;
        
        // session_start();
        $_SESSION['pedido'] = $request->email;

        $periodo = $this->getPeriod();
        $cupons = $this->getCupons();

        $totalPrice = 0; // Valor total do carrinho
        $purchase_pai = true; // compra pai é sempre a primeira
        $purchase_pai_id = 0; // ID da compra pai


        foreach ($cart as $c) {
            
            $purchase = new Purchase();
            $purchase->plan_id = $c['plan_id'];
            $purchase->email = $user['email'];
            $purchase->telefone = $user['telefone'];
            $purchase->profile = $c['profile'];

            $plan = Plan::find($c['plan_id']);

            $purchase->price = (empty($plan->quantity_min) ? $plan->price : $plan->price * $c['quantity']);

            $purchase->price_sale = (empty($plan->quantity_min) ? $plan->price : $plan->price * $c['quantity']);

            $purchase->price_tot = (empty($plan->quantity_min) ? $plan->price : $plan->price * $c['quantity']);

            // APLICA CUPOM CASO NÃO VIM VAZIO'
            if(isset($request->cupom) && !empty($request->cupom)) {
                $cupomDigitado = strtoupper($request->cupom);

                // Verifica se o cupom digitado existe no array de cupons
                $cupomEncontrado = collect($cupons)->first(function ($cupom) use ($cupomDigitado) {
                    return $cupom['nome'] === $cupomDigitado;
                });

                if ($cupomEncontrado) {
                    $valorOriginal = (empty($plan->quantity_min) ? $plan->price : $plan->price * $c->quantity);
                    $descontoPorcentagem = $cupomEncontrado['desconto'] / 100; // Usa o desconto do banco
                    $purchase->price = $valorOriginal - ($valorOriginal * $descontoPorcentagem);

                    $buyWithCoupon = true;
                }
    
            } 

            $purchase->quantity = $c['quantity'];
            $purchase->payment_method = 'pix';
            $purchase->type_purchase = 'M';
            $purchase->period = $periodo;
            $purchase->payment_id = 0;
            $purchase->termos_id = 3;
            $purchase->politicas_id = 1;
            $purchase->purchase_pai_id = $purchase_pai_id;
            $purchase->save();

            if($purchase_pai){
                $purchase_pai = false;
                $purchase_pai_id = $purchase->id;
            }

            // comprou com cupom
            if($buyWithCoupon){
                DB::table('venda_cupom')->insert([
                    'nome_cupom' => $request->cupom,
                    'compra_id' => $purchase->id,
                ]);
            }

            // SE FOR DO TIPO 4, SALVA OS COMENTÁRIOS
            if(isset($c['cmnt_q'])){
                foreach($c['comments'] as $comment){
                    $coment = new Coment();
                    $coment->purchase_id = $purchase->id;
                    $coment->coment =  $comment;
                    $coment->save();
                }
            }
            
            $totalPrice +=  $purchase->price;

        }
        
        if($totalPrice > 0){
            
            SDK::setAccessToken('APP_USR-1862735257368010-072921-bfafa63d92f95d243e36b72dee54b99f-177082211'); // Either Production or SandBox AccessToken

            $payment = new Payment();
            $payment->description = "Seguir Play #{$purchase_pai_id}";
            $payment->transaction_amount = (double) round($totalPrice,2);
            $payment->payment_method_id = "pix";

            $payment->notification_url = route('webhooks', [$purchase_pai_id]);
            $payment->external_reference = $purchase_pai_id;

            $payment->payer = array(
                "email" => $user['email'],
                "first_name" => $user['email'],
                "address"=>  array(
                    "zip_code" => "06233200",
                    "street_name" => "Av. das Nações Unidas",
                    "street_number" => "3003",
                    "neighborhood" => "Bonfim",
                    "city" => "Osasco",
                    "federal_unit" => "SP"
                )
            );

            $payment->save();

            // Remover cookies do carrinho e do usuário após a compra
            setcookie('cartDashboard', '', time() - 3600, '/');

            $payment->point_of_interaction->purchase = $purchase_pai_id;
            echo json_encode($payment->point_of_interaction);
        }
    }


    public function addToCart(Request $request)
    {
       
        $cart = [];
        
        if (isset($_COOKIE['cartDashboard'])) {
            $cart = json_decode($_COOKIE['cartDashboard'], true);
        }

        if (isset($_COOKIE['userCartDashboard'])) {
            $user = json_decode($_COOKIE['userCartDashboard'], true);
        }else{
            $user = [
                'telefone' => $request->telefone,
                'email' => $request->email
            ];
        }
        $plan = Plan::find($request->plan_id);
        $category = $plan->category;
 
        $item = [
            'id' => uniqid(),
            'profile' => $request->profile,
            'quantity' => $request->quantity,
            'price' => (empty($plan->quantity_min) ? $plan->price : $plan->price * $request->quantity),
            'plan_id' => $plan->id,
            'category' => $category->title,
            'plan' => $plan->title
        ];

        if($plan->type == 4) {
            
            $item['comments'] = $request->comments;
            $item['cmnt_q'] = $request->cmnt_q;
        }

        $cart[] = $item;

        $expiracao = time() + (2 * 60 * 60); // 2 horas em segundos

        setcookie('cartDashboard', json_encode($cart), $expiracao, '/');

        setcookie('userCartDashboard', json_encode($user), $expiracao, '/');
        
        return response()->json(['message' => 'Produto adicionado ao carrinho!']);
    }

    // Remover item do carrinho
    public function removeFromCart($index)
    {
       
        $cart = isset($_COOKIE['cartDashboard']) ? json_decode($_COOKIE['cartDashboard'], true) : [];

        // Filtrar os itens, removendo o que tem o ID correspondente
        $cart = array_filter($cart, function ($item) use ($index) {
            return $item['id'] !== $index;
        });

        // Reindexar o array
        $cart = array_values($cart);

        // Atualizar o cookie
        $expiracao = time() + (2 * 60 * 60);
        setcookie('cartDashboard', json_encode($cart), $expiracao, '/');

        // Calcular o novo total
        $total = array_sum(array_column($cart, 'price'));

        return response()->json([
            'message' => 'Produto removido do carrinho!',
            'total' => number_format($total, 2, ',', '.')
        ]);
    }
    
    public function cartClear()
    {   
        
        setcookie('cartDashboard', '', time() - 3600, '/');
        setcookie('userCartDashboard', '', time() - 3600, '/');

        return redirect()->route('dashboard.gestaoPedidoManual.index')->with('success', 'Carrinho limpo!');
    }

    public function getCart()
    {
        $cart = isset($_COOKIE['cartDashboard']) ? json_decode($_COOKIE['cartDashboard'], true) : [];
        
        return view('dashboard.gestaoPedidoManual.cart', ['cart' => $cart]);
    }

    public function getPeriod():string
    {
        // Obter o ano atual
        $ano = date("Y");

        // Obter o mês atual
        $mes = date("n");

        return $mes .'/' . $ano;

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
