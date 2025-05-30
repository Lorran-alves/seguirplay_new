<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Dashboard;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Purchase;
use App\Models\Coment;
use App\Models\Cupom;
use App\Models\CupomUnico;
use App\Models\EmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\SDK;
use MercadoPago\Payment;

class PurchaseController extends Controller
{
    
    protected $keyMercadoPago = 'APP_USR-1862735257368010-072921-bfafa63d92f95d243e36b72dee54b99f-177082211';

    
    public function buy(Request $request, Plan $plan)
    {
        $periodo = $this->getPeriod();

        $purchase = new Purchase();
        $purchase->plan_id = $plan->id;
        $purchase->email = $request->email;
        $purchase->telefone = $request->telefone;
        $purchase->profile = $request->profile;
        
        $purchase->price = (empty($plan->quantity_min) ? $plan->price : $plan->price * $request->quantity);

        $purchase->price_sale = (empty($plan->quantity_min) ? $plan->price : $plan->price * $request->quantity);

        $purchase->price_tot = (empty($plan->quantity_min) ? $plan->price : $plan->price * $request->quantity);

        $purchase->quantity = $request->quantity;
        $purchase->payment_method = 'master';
        $purchase->period = $periodo;
        $purchase->payment_id = 0;
        $purchase->termos_id = 4;
        $purchase->politicas_id = 2;
        $purchase->save();
        
        $this->saveEmailsNotification($request->email, $request->accept_email);

        for($i = 1; $i <= $request->cmnt_q; $i++){
            $coment = new Coment();
            $coment->purchase_id = $purchase->id;
            $coment->coment =  $request->input('cmnt_'.$i);
            $coment->save();
        }

		$fp = fopen("buy_logs_mercado_pago.txt","a");
        fwrite($fp, $purchase->id);
        fwrite($fp, PHP_EOL);
        fwrite($fp, json_encode($purchase->all()));
        fwrite($fp, PHP_EOL);
        fwrite($fp, '=============================================================');
        fwrite($fp, PHP_EOL);
        fclose($fp);
        
        SDK::setAccessToken($this->keyMercadoPago); 
        $preference = new Preference();
        $item = new Item();
        $item->title = "SeguirPlay #{$purchase->id}";
        $item->quantity = 1;
        $item->unit_price = (empty($plan->quantity_min) ? $plan->price : $plan->price * $request->quantity);
        $preference->items = array($item);
        $preference->payment_methods = array(
          "excluded_payment_types" => array(
            array("id" => "ticket"),
            array("id" => "bank_transfer")
          ),
          "installments" => 3
        );
        $preference->back_urls = array(
            "success" => route('web.home'),
            "failure" => route('web.home'),
            "pending" => route('web.home'),
        );
        $preference->auto_return = "approved";
        $preference->external_reference = $purchase->id;
        $preference->notification_url = route('webhooks', [$purchase->id]);
        $preference->save();
        return redirect($preference->init_point);
    }
    
    public function ispay(Purchase $purchase){
        // var_dump($purchase->status);
        if($purchase->status != 'pending'){

            $this->saveBuyCupomUnico($purchase->id);    
            
            //enviar o purchase_id para session
            session_start();
            $_SESSION['purchase_id'] = $purchase->id;
            
            echo json_encode((object)['status' => true]);

        }else{
            echo json_encode((object)['status' => false]);
        }
    }
    
    public function buyCard(Request $request, Plan $plan)
    {

        try{

            $periodo = $this->getPeriod();

            //começa com falso
            $buyWithCoupon = false;
    
            session_start();
            $_SESSION['pedido'] = $request->email;
            $purchase = new Purchase();
            $purchase->plan_id = $plan->id;
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
            $purchase->cpf = $request->cpf;
            $purchase->nome_completo = $request->nome_completo;
            $purchase->data_nascimento = $request->data_nascimento;
            $purchase->payment_method = 'cartao';
            $purchase->period = $periodo;
            $purchase->payment_id = 0;
            $purchase->termos_id = 4;
            $purchase->politicas_id = 2;
            $purchase->save();
    
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

            return response()->json(['status' => true, 'purchase_id' => $purchase->id]);

        }catch(\Exception $e){
            return response()->json(['status' => false]);
        }
        
    }

     public function processPaymentCard(Request $request)
    {

        $purchase = Purchase::find($request->purchase_id);
        if(!$purchase){
            return response()->json(['success' => false, 'message' => 'Pedido não encontrado!']);
        }

        SDK::setAccessToken($this->keyMercadoPago);
       
        $payment = new Payment();
        $payment->transaction_amount = (double) round($purchase->price,2);;
        $payment->token = $request->token_card;
        $payment->description = "Pagamento SeguirPlay #{$purchase->id}";
        $payment->installments = (int) $request->installments;
        $payment->payment_method_id = $request->paymentMethodId;
        $payment->payer = [
            "email" => $purchase->email,
            'identification' => [
                "type" => "CPF",
                "number" => $purchase->cpf
            ],
            
        ];

        $payment->save();

        return response()->json([
            'success' => false,
            'status' => $payment->status,
            'status_detail' => $payment->status_detail,
            'message' => $payment->status_detail,
            'full_response' => $payment->toArray()
        ]);


        if ($payment->status == 'approved') {
            // atualizar status da compra
            $purchase->status = 'approved';
            $purchase->save();
            return response()->json(['success' => true, 'message' => 'Pagamento aprovado!']);
        } else {
            return response()->json(['success' => false, 'message' => $payment->status_detail]);
        }
    }
    
    
    public function pix(Request $request, Plan $plan)
    {
        $periodo = $this->getPeriod();
        $cupons = $this->getCupons();

        //começa com falso
        $buyWithCoupon = false;
        session_start();
        $_SESSION['pedido'] = $request->email;
        $purchase = new Purchase();
        $purchase->plan_id = $plan->id;
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

        $this->saveEmailsNotification($request->email, $request->accept_email);

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
       
        SDK::setAccessToken($this->keyMercadoPago); 
        
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

        $fp = fopen("pix_logs_mercado_pago.txt","a");
        fwrite($fp, PHP_EOL);
        fwrite($fp, '=============================================================');
        fwrite($fp, $purchase->id);
        fwrite($fp, json_encode($request->all()));
        fwrite($fp, PHP_EOL);
        fwrite($fp, 'Data:' . now());
        fwrite($fp, json_encode($payment->toArray()));
        fwrite($fp, PHP_EOL);
        fwrite($fp, '=============================================================');
        fwrite($fp, PHP_EOL);
        fclose($fp);
		
        $payment->point_of_interaction->purchase = $purchase->id;
        echo json_encode($payment->point_of_interaction);
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

    public function saveBuyCupomUnico(int $purchase_id):void
    {

        $result = DB::table('venda_cupom')
        ->where('compra_id', $purchase_id)
        ->first();

        if($result &&  isset($result->nome_cupom)){
            $cupom_unico = CupomUnico::where('nome', $result->nome_cupom)->first();
       
            if($cupom_unico){
                $cupom_unico->validade = 0;
                $cupom_unico->save();
            }
        }
 
    }

    public function saveEmailsNotification(string $email, int $accept):void
    {   
        // Verifica se já existe um registro para o e-mail
        $existingNotification = EmailNotification::where('email', $email)->first();

        if ($existingNotification) {

            //atualiza 
            $existingNotification->last_purchase_date = now(); 
            $existingNotification->accept_email = $accept; 
            $existingNotification->send_1_week = null; 
            $existingNotification->send_3_month = null; 
            $existingNotification->save();

            return;
        } 

        //cria um novo registro
        $newNotification = new EmailNotification();
        $newNotification->email = $email;
        $newNotification->last_purchase_date = now();
        $newNotification->accept_email = $accept;
        $newNotification->save();
        
    }

    public function getPeriod():string
    {
        // Obter o ano atual
        $ano = date("Y");

        // Obter o mês atual
        $mes = date("n");

        return $mes .'/' . $ano;

    }
    
    public function pixCart(Request $request)
    {
    
        
        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
        $user = isset($_COOKIE['userCart']) ? json_decode($_COOKIE['userCart'], true) : [];

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
                    // var_dump($comment);
                    $coment = new Coment();
                    $coment->purchase_id = $purchase->id;
                    $coment->coment =  $comment;
                    $coment->save();
                }
            }
            
            $totalPrice +=  $purchase->price;

        }
        
        if($totalPrice > 0){
            
            SDK::setAccessToken($this->keyMercadoPago); 

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
            setcookie('cart', '', time() - 3600, '/');
            
            $payment->point_of_interaction->purchase = $purchase_pai_id;
            echo json_encode($payment->point_of_interaction);
        }
    }
    
    public function cardCart(Request $request)
    {
        try{
            $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
            $user = isset($_COOKIE['userCart']) ? json_decode($_COOKIE['userCart'], true) : [];

            //começa com falso
            $buyWithCoupon = false;
            
            // session_start();
            $_SESSION['pedido'] = $request->email;

            $periodo = $this->getPeriod();
            $cupons = $this->getCupons();

            $totalPrice = 0;
            $purchase_pai = true;
            $purchase_pai_id = 0;

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
                $purchase->payment_method = 'cartao';
                $purchase->cpf = $request->cpf;
                $purchase->nome_completo = $request->nome_completo;
                $purchase->data_nascimento = $request->data_nascimento;
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
                        // var_dump($comment);
                        $coment = new Coment();
                        $coment->purchase_id = $purchase->id;
                        $coment->coment =  $comment;
                        $coment->save();
                    }
                }
                
                $totalPrice +=  $purchase->price;
            }

            return response()->json(['status' => true, 'purchase_id' => $purchase_pai_id, 'amount' => $totalPrice]);

        }catch(\Exception $e){
            return response()->json(['status' => false]);
        }
        
    }


}

