<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Dashboard;
use App\Models\Plan;
use App\Models\Purchase;

use App\Models\Coment;
use App\Models\ProviderAPI;
use App\Models\Order;

use Illuminate\Http\Request;

use App\Mail\PaymentMail;
use App\Mail\ContactMail;
use App\Models\Category;
use App\Models\Cupom;
use App\Models\Provedor;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WebController extends Controller
{  
    public function home()
    { 
       
        $plans = Plan::with('category')->get();
       

        return view('web.home', [
            'plans' => $plans,
            'user' => '',
            'order' => '',
            'status' => '',
        ]);
    }
    

    public function contact()
    {
        return view('web.contact');
    }
    public function contactform(Request $request)
    {

        $name = $request->input("name");
        $email = $request->input("email");
        $number = $request->input("number");
        $url = $request->input("url");
        $message = $request->input("message");
        Mail::send(new ContactMail($email, $name, $number, $url, $message));

        return redirect()->back()->withSuccess('Enviado com sucesso!');
    }

    public function faq()
    {
        return view('web.faq');
    }

    public function policies()
    {
        return view('web.policies');
    }

    public function dealer()
    {
        return view('web.dealer');
    }

    public function term()
    {
        return view('web.term');
    }
    
    public function compraFinalizada()
    {
        session_start();
        $purchase_id = $_SESSION['purchase_id'] ?? 0;
        

        $purchase = Purchase::where('id', $purchase_id)->first();
        
        // pega outras compras 
        $purchases = Purchase::where('id', $purchase_id)
        ->orWhere('purchase_pai_id', $purchase_id)
        ->get();
        
        if($purchase == null) {
            return redirect()->route('web.home');
        }

        //so carrega uma vez
        $_SESSION['purchase_id'] = 0;

        return view('web.compraFinalizada', ['purchases' => $purchases, 'purchase' => $purchase]);
    }
    
    public function verificarCupom(Request $request)
    {
        $cupomEntrada = $request->cupom ?? '';
        $categoria = $request->categoria ?? 0;
        $plan = $request->plano ?? 0;

        $cupom = Cupom::where('nome', $cupomEntrada)
            ->where('status', 1)
            ->where(function ($query) {
                $query->whereNull('apartir_de')
                    ->orWhere('apartir_de', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('validade')
                    ->orWhere('validade', '>=', now());
            })
        ->first();

        if(empty($cupom)){
            return json_encode(['status' => 'error', 'message' => 'Cupom inválido']);
        }

        // verificar se tem categoria associada
        if(isset($cupom->categories_id) && $cupom->categories_id != null){
            $categorias = explode(',', $cupom->categories_id);
            if(!in_array($categoria, $categorias)){
                return json_encode(['status' => 'error', 'message' => 'Cupom inválido para essa categoria']);
            }
        }

        // verificar se tem planos associados
        if(isset($cupom->plans_id) && $cupom->plans_id != null){
            $planos = explode(',', $cupom->plans_id);
            if(!in_array($plan, $planos)){
                return json_encode(['status' => 'error', 'message' => 'Cupom inválido para esse serviço']);
            }
        }

        //verifica se é cupom unico por pessoa
        if($cupom->only_by_email == 1 && isset($request->email)){
            $purchase = Purchase::where('email', $request->email)
                ->whereIn('status', ['approved', 'send'])
                ->whereIn('id', function ($query) use ($cupomEntrada) {
                    $query->select('compra_id')
                        ->from('venda_cupom')
                        ->where('nome_cupom', $cupomEntrada);
                })
                ->first();

            if(isset($purchase->id)){
                return json_encode(['status' => 'error', 'message' => 'Cupom unico por pessoa']);
            }
        }
        
        //verifica se é cupom unico por email
        if($cupom->limited_email != '' && isset($request->email)){
            if($cupom->limited_email != $request->email){
                return json_encode(['status' => 'error', 'message' => 'Cupom unico por email']);
            }
        }


        return json_encode(['status' => 'success', 'message' => 'Cupom válido', 'desconto' => $cupom->desconto]);

    }
    
    
    public function verificaPedido(Request $request)
    { 
        session_start();

        $dado = $request->input("search");
        $purchase = Purchase::where('email', $dado)->first();

        if($purchase != null) {
            $_SESSION['pedido'] = $dado;
            return 'verdadeiro';
        }
        return 'Pedido não encontrado, entre em contato com o <a style="color:#781f60" href="https://api.whatsapp.com/send/?phone=5511985868006" target="_blank">Suporte</a>';
    }

    public function pedidos($email = null)
    {   
        
        session_start();

        //se vim por url redirecionar pra limpar url
        if ($email) {
            $_SESSION['pedido'] = $email;
            return redirect()->route('web.pedidos');
        }

        //redireciona
        if(!isset($_SESSION['pedido']) ) {
            return redirect()->route('web.home');
        }
        $dado = $_SESSION['pedido'];
        
        // unset($_SESSION["pedido"]);

      
         // Obtém o último pedido do usuário
        $ultimoPedido = Purchase::where('email', $dado)
        ->orderBy('created_at', 'desc')
        ->first();

        $purchases = Purchase::where('email', $dado)
        ->where('id', '!=', $ultimoPedido->id)
        ->orderBy('created_at', 'desc')
        ->paginate(5); // Define o número de itens por página


        $result_api = [];
        $pedidos = [];

        //percorre o ultimo pedido
        $pedidos = Order::where('purchase_id', $ultimoPedido->id)->get();
        if(!empty($pedidos[0])) {
            $plan_a = Plan::find($ultimoPedido->plan_id);
            $result_api[$ultimoPedido->id] = $this->getStatusAtual($plan_a->provedor, $pedidos[0]->order_id);
        }else if($ultimoPedido->status == 'pending' || $ultimoPedido->status == 'cancelled'){
            $result_api[$ultimoPedido->id] = ['classe' => 'status4', 'status' => 'Aguardando Pagamento'];
        }else{
            $result_api[$ultimoPedido->id] = ['classe' => 'status1', 'status' => 'Organizando Para Entregar'];
        }

        $pedidos = [];
        // PERCORRE TODOS OS PEDIDOS
        foreach($purchases as $p){
            $pedidos = Order::where('purchase_id', $p->id)->get();
            if(!empty($pedidos[0])) {
                $plan_a = Plan::find($p->plan_id);
                $result_api[$p->id] = $this->getStatusAtual($plan_a->provedor, $pedidos[0]->order_id);
            }else if($p->status == 'pending' || $p->status == 'cancelled'){
                $result_api[$p->id] = ['classe' => 'status4', 'status' => 'Aguardando Pagamento'];
            }else{
                $result_api[$p->id] = ['classe' => 'status1', 'status' => 'Organizando Para Entregar'];
            }
        }

        // Obter o primeiro resultado
        // $ultimoPedido = $purchases->first();

        // Obter todos os outros resultados (exceto o primeiro)
        $outrosResultados = $purchases;
        
        return view('web.orders', ['ultimoPedido' => $ultimoPedido, 'outrosPedidos' => $outrosResultados, 'retornoApi' => $result_api]);
    }

    public function getStatusAtual($provedor_id, $order_id) {

        // Purchase::where('id', $id)->first();
        $provedor = Provedor::where('valor',$provedor_id)->first();
      
        if(!isset($provedor->name)) {
            return false;
        }

        $api = new ProviderAPI($provedor->url, $provedor->token);
        
        $status = [
            'pending'      => ['status1', 'Organizando Para Entregar'],
            'Pending'      => ['status1', 'Organizando Para Entregar'],
            'Processing'   => ['status1', 'Preparando o Pedido'],
            'Partial'      => ['status0', 'Ops, algo deu errado!'], // rembolsado
            'In progress'  => ['status2', 'Em processamento de entrega'],
            'Refunded'     => ['status0', 'Ops, algo deu errado!'], // rembolsado
            'Completed'    => ['status3', 'Concluido a entregar'],
            'Canceled'     => ['status0', 'Ops, algo deu errado!'], // rembolsado
        ];

        $status_r = $api->status($order_id);
        if(!isset($status_r->status)) {
            $status = [
                'status' => 'Organizando Para Entregar',
                'classe' => 'status1',
                'inicial' => 0
            ]; 
        }else{
            $indice = $status_r->status;
            if(array_key_exists($indice, $status)){
                $classe =  $status[$status_r->status][0];
                $status =   $status[$status_r->status][1];
            }else {
                $status = 'Aguardando Pagamento';
                $classe = 'status0';
            }
      
            // Verifique se start_count é NULL e atribua 0 se for o caso
            if ($status_r->start_count === NULL) {
              $status_r->start_count = 0;
            }

            $status = [
                'status' => $status,
                'classe' => $classe,
                'inicial' => $status_r->start_count
            ];
        }
        return $status;
    }
    /**
     * cartão = 4.98% juros
     * saldo do mercado pago = 4.99% juros
     * pix = 0.99% juros
     */
    public function ajustaPrecoTotalJuros($price, $metodo)
    {   
        // Define as taxas de juros para cada método
        $taxas = [
            'pix' => 0.99 / 100,
            'account_money' => 4.99 / 100,
            'master' => 4.98 / 100,
        ];

       
        $taxaJuros = 0; 
        
        if (array_key_exists($metodo, $taxas)) {
            $taxaJuros = $taxas[$metodo];
        } else {
            $taxaJuros = $taxas['master'];
        }

        // Calcula o valor líquido subtraindo os juros do valor total
        $valorLiquido = $price - ($price * $taxaJuros);

        return $valorLiquido;

    }

    public function api(){
        $dashboard = new Dashboard;
        $period = $dashboard->getPeriod();
        try {
            $dolar = $this->getCurrentDollarRate();
            //unico pedido por vez
            $u = Purchase::where('status', 'approved')->orderBy('id', 'desc')->first();
            // var_dump($u);
            //se não tiver ele vai retornar evitando assim erros
            if(empty($u)){
                return;
            }
        
            $plan_a = Plan::find($u->plan_id);
    
            $provedor = Provedor::where('valor',$plan_a->provedor)->first();
        
            if(!isset($provedor->name)) {
                return false;
            }
    
            $api = new ProviderAPI($provedor->url, $provedor->token);
           
            
    
            if($plan_a->type == 4){ //comment
                $comments = Coment::where('purchase_id', $u->id)->get();
    
                $comentString = '';
                $totalComments = count($comments);
    
                //UNIR TODOS OS COMENTÁRIOS SEPARANDO POR '\n'
                foreach ($comments as $key => $c) {
                    $comentString .= addslashes($c->coment);
    
                    // Adicione uma nova linha se não for o último comentário
                    if ($key < $totalComments - 1) {
                        $comentString .= " \n ";
                    }
    
                }
                $order_a = array(
                    'service' => $plan_a->id_provedor,
                    'link' => $u->profile,
                    'quantity' => $u->quantity,
                    'posts' => 0,
                    'delay' => 5,
                    'comments' => $comentString
                );
        
                $order_r = $api->order($order_a); # Subscriptions 
    
                if(!isset($order_r->error) && $order_r != null ){
                    $status_r = $api->status($order_r->order); # return status, charge, remains, start count, currency                    
                    
                    // Entra no loop se o campo currency não estiver presente
                    while (!isset($status_r->currency)) {
                        sleep(5); // Espera 5 segundos antes de tentar novamente
                        $status_r = $api->status($order_r->order); // Tenta obter o status novamente
    
                    }
                    
                    if($status_r->currency == 'USD'){
                        $status_r->charge  *= $dolar;
                    }
    
                    
                    Order::insert(array(
                        'order_id'=> $order_r->order,
                        'purchase_id'=> $u->id,
                        'status'=> $status_r->status,
                        'charge'=> $status_r->charge,
                        'period'=> $period,
                    ));
    
                    $u->status = 'send';
                    $u->price_sale = $this->ajustaPrecoTotalJuros($u->price, $u->payment_method);
                    $u->save();
    
                    $dashboard->addDespesa($status_r->charge);
    
                    $dashboard->addCustomer($u->email, $u->price, $u->telefone);
    
                    $dashboard->addTotalMonth($u->price_sale);
    
                    $preco = (float) str_replace(',', '.', trim($u->price));
                    $preco_tot = (float) str_replace(',', '.', trim($u->price_tot));
                    $desconto = $preco_tot - $preco;
    
                    // Formatando o resultado como moeda brasileira (real)
                    $u->desconto = 'R$ ' . number_format($desconto, 2, ',', '.');
    
                    $category = Category::find($plan_a->category_id);
    
                    Mail::send(new PaymentMail($u->email, 'você', $plan_a, $category->title, $u));
                    
                }
                else{
                    // echo '<br>com erro antes de enviar para api<br>';
                    // echo $plan_a->title . ' =>';
                    // print_r($order_r);
                    // echo"<br><br>";
                }
            }
            else{
                $order_a = array(
                    'service' => $plan_a->id_provedor,
                    'link' => $u->profile,
                    'quantity' => $u->quantity,
                    'posts' => 0,
                    'delay' => 5,
                );
    
                $order_r = $api->order($order_a); # Subscriptions
                
                if(!isset($order_r->error) && $order_r != null){
                    $status_r = $api->status($order_r->order); # return status, charge, remains, start count, currency
    
    
                    // Entra no loop se o campo currency não estiver presente
                    while (!isset($status_r->currency)) {
                        sleep(5); // Espera 5 segundos antes de tentar novamente
                        $status_r = $api->status($order_r->order); // Tenta obter o status novamente
    
                    }
    
                    if($status_r->currency == 'USD'){                     
                        $status_r->charge  *= $dolar;
                    }
                    
    
                    Order::insert(array(
                        'order_id'=> $order_r->order,
                        'purchase_id'=> $u->id,
                        'status'=>$status_r->status,
                        'charge'=>$status_r->charge,
                        'period'=> $period,
                    ));
    
                    $u->status = 'send';
                    $u->price_sale = $this->ajustaPrecoTotalJuros($u->price, $u->payment_method);
                    $u->save();
    
                    //apenas uma vez adicionar a despesa
                    $dashboard->addDespesa($status_r->charge);
    
                    $dashboard->addCustomer($u->email, $u->price, $u->telefone);
    
                    $dashboard->addTotalMonth($u->price_sale);
                    
                    $preco = (float) str_replace(',', '.', trim($u->price));
                    $preco_tot = (float) str_replace(',', '.', trim($u->price_tot));
                    $desconto = $preco_tot - $preco;
    
                    // Formatando o resultado como moeda brasileira (real)
                    $u->desconto = 'R$ ' . number_format($desconto, 2, ',', '.');
    
                    $category = Category::find($plan_a->category_id);
    
                    Mail::send(new PaymentMail($u->email, 'você', $plan_a, $category->title, $u));
                }else{
                    Log::info('api() error'. $order_r->error);
              
                        // echo $u->id . ' - ';
                        // echo $plan_a->title . ' =>';
                        // print_r($order_r);
                        // echo"<br><br>";
                }
            }
            //echo('ok');
            Log::info('api() method executed successfully.');
        } catch (\Throwable $e) {
             // Captura qualquer erro e registra no log
            Log::error('Erro fatal na função api(): ' . $e->getMessage(), ['exception' => $e]);
        }

        //ATUALIZANDO STATUS E ATUALIZANDO DESPESAS SE NECESSÁRIO
    
        $reembolsos = ['Partial', 'Refunded', 'Canceled'];
            
        $orders = Order::whereNotIn('status', $reembolsos)
        ->where('status', '<>', 'Completed')
        ->get();

        $dashboard = new Dashboard;
        
        foreach($orders as $o){
            var_dump($o->purchase_id);
            $p = Purchase::find($o->purchase_id);
            if( $p == null ) continue;
            $plan = Plan::find($p->plan_id);
            
                
            $provedor = Provedor::where('valor',$plan->provedor)->first();
        
            if(!isset($provedor->name)) {
                continue;
            }

            $api = new ProviderAPI($provedor->url, $provedor->token);
            
            $status_r = $api->status($o->order_id); # return status, charge, remains, start count, currency

            if ( isset($status_r->status) ){
                
                $oo = Order::find($o->id);
                $oo->status = $status_r->status;
                $oo->save();

                //subtrair desepesas em caso de reembolso
                if(in_array($status_r->status, $reembolsos) && $oo->period == $period ){
                    
                    $dashboard->subtrairDespesa($oo->charge, $oo->period, $p->price, $p->price_sale, $p->email);

                    //colocar status como erro
                    $p->status = 'erro';
                    $p->save();

                }

            }
        }
    }
    
    public function api_dashboard_test($id){

        echo "";

    }

    public function api_dashboard($id){
        
        Log::info('api_dashboard() executando. ' . $id);
        
        try{
            $dolar = $this->getCurrentDollarRate();
    
            /* Enviando orders */
            if(!is_numeric($id)){
                return false;
            }      
    
            //unico pedido por vez e se não tiver sido enviado
            $u = Purchase::where('id', $id)->where('status', 'approved')->first();
          
            //se não tiver ele vai retornar evitando assim erros
            if(empty($u)){
                Log::info('api_dashboard() abortado. ' . $id);
                return;
            }

            $plan_a = Plan::find($u->plan_id);
    
            $provedor = Provedor::where('valor',$plan_a->provedor)->first();
            
            if(!isset($provedor->name)) {
                return false;
            }
    
            $api = new ProviderAPI($provedor->url, $provedor->token);
            $dashboard = new Dashboard;
            $period = $dashboard->getPeriod();
    
            if($plan_a->type == 4){ //comment
                $comments = Coment::where('purchase_id', $u->id)->get();
    
                $comentString = '';
                $totalComments = count($comments);
    
                //UNIR TODOS OS COMENTÁRIOS SEPARANDO POR '\n'
                foreach ($comments as $key => $c) {
                    $comentString .= addslashes($c->coment);
    
                    // Adicione uma nova linha se não for o último comentário
                    if ($key < $totalComments - 1) {
                        $comentString .= " \n ";
                    }
    
                }
                $order_a = array(
                    'service' => $plan_a->id_provedor,
                    'link' => $u->profile,
                    'quantity' => $u->quantity,
                    'posts' => 0,
                    'delay' => 5,
                    'comments' => $comentString
                );
        
                $order_r = $api->order($order_a); # Subscriptions 
    
    
                if(!isset($order_r->error) && $order_r != null ){
                    $status_r = $api->status($order_r->order); # return status, charge, remains, start count, currency  
                    
                    echo '<pre>';
                    var_dump($status_r);
                    echo '</pre>';
                    
                    // Entra no loop se o campo currency não estiver presente
                    while (!isset($status_r->currency)) {
                        sleep(5); // Espera 5 segundos antes de tentar novamente
                        $status_r = $api->status($order_r->order); // Tenta obter o status novamente
    
                    }
    
                    echo '<pre>'; 
                        var_dump($status_r);
                    echo '</pre>';
    
                    if($status_r->currency == 'USD'){                     
                        $status_r->charge  *= $dolar;
                    }
                    
                    Order::insert(array(
                        'order_id'=> $order_r->order,
                        'purchase_id'=> $u->id,
                        'status'=> $status_r->status,
                        'charge'=> $status_r->charge,
                        'period'=> $period,
                    ));
    
                    $u->status = 'send';
                    $u->price_sale = $this->ajustaPrecoTotalJuros($u->price, $u->payment_method);
                    $u->save();
    
                    //apenas uma vez adicionar a despesa
                    $dashboard->addDespesa($status_r->charge);
    
                    $dashboard->addCustomer($u->email, $u->price, $u->telefone);
    
                    $dashboard->addTotalMonth($u->price_sale);
    
                    $preco = (float) str_replace(',', '.', trim($u->price));
                    $preco_tot = (float) str_replace(',', '.', trim($u->price_tot));
                    $desconto = $preco_tot - $preco;
    
                    // Formatando o resultado como moeda brasileira (real)
                    $u->desconto = 'R$ ' . number_format($desconto, 2, ',', '.');
    
                    $category = Category::find($plan_a->category_id);
    
                    Mail::send(new PaymentMail($u->email, 'você', $plan_a, $category->title, $u));
                }
                else{
                    // echo '<br>com erro antes de enviar para api<br>';
                    echo $plan_a->title . ' =>';
                    print_r($order_r);
                    echo"<br><br>";
                     die;
                }
            }
            else{
                $order_a = array(
                    'service' => $plan_a->id_provedor,
                    'link' => $u->profile,
                    'quantity' => $u->quantity,
                    'posts' => 0,
                    'delay' => 5,
                );
    
                $order_r = $api->order($order_a); # Subscriptions
                
                if(!isset($order_r->error) && $order_r != null){
                    $status_r = $api->status($order_r->order); # return status, charge, remains, start count, currency
    
                    // Entra no loop se o campo currency não estiver presente
                    while (!isset($status_r->currency)) {
                        sleep(5); // Espera 5 segundos antes de tentar novamente
                        $status_r = $api->status($order_r->order); // Tenta obter o status novamente
    
                    }
    
                    if($status_r->currency == 'USD'){                     
                        $status_r->charge  *= $dolar;
                    }
    
                    Order::insert(array(
                        'order_id'=> $order_r->order,
                        'purchase_id'=> $u->id,
                        'status'=>$status_r->status,
                        'charge'=>$status_r->charge,
                        'period'=> $period,
                    ));
    
                    $u->status = 'send';
                    $u->price_sale = $this->ajustaPrecoTotalJuros($u->price, $u->payment_method);
                    $u->save();
    
                    //apenas uma vez adicionar a despesa
                    $dashboard->addDespesa($status_r->charge);
    
                    $dashboard->addCustomer($u->email, $u->price, $u->telefone);
    
                    $dashboard->addTotalMonth($u->price_sale);
    
                    $preco = (float) str_replace(',', '.', trim($u->price));
                    $preco_tot = (float) str_replace(',', '.', trim($u->price_tot));
                    $desconto = $preco_tot - $preco;
    
                    // Formatando o resultado como moeda brasileira (real)
                    $u->desconto = 'R$ ' . number_format($desconto, 2, ',', '.');
    
                    $category = Category::find($plan_a->category_id);
    
                    Mail::send(new PaymentMail($u->email, 'você', $plan_a, $category->title, $u));
    
                }else{
    
                    echo $plan_a->title . ' =>';
                    var_dump($order_r);
                    echo"<br><br>";
                     die;
                }
            }
            Log::info('api_dashboard() method executed successfully. ' . $u->id);
        } catch (\Throwable $e) {
            echo $e->getMessage();
            $u = Purchase::where('id', $id)->first();
    
            if(empty($u)){
                $u->log = $e->getMessage();
                $u->save();
            }
         
            // Captura qualquer erro e registra no log
            Log::error('Erro fatal na função api_dashboard() id: '. $id .' erro: ' . $e->getMessage(), ['exception' => $e]);
            
            return redirect()->back()->withErrors('Erro fatal na função api_dashboard() id: '. $id .' erro: ' . $e->getMessage());
            
        }
        return redirect()->back()->withSuccess('Pedido enviado com sucesso!');
    }
    
     public function api_dashboard_reembolsado($id)
    {
        
        try{
            $dolar = $this->getCurrentDollarRate();
    
            if(!is_numeric($id)){
                throw new \Exception("Pedido não está com id numerico");
                return false;
            }      
    
            //unico pedido por vez e se não tiver sido enviado
            $u = Purchase::where('id', $id)->where('status', 'erro')->first();
          
            //se não tiver ele vai retornar evitando assim erros
            if(empty($u)){
                throw new \Exception("Pedido não está com status de erro");
                return;
            }

            $plan_a = Plan::find($u->plan_id);
    
            $provedor = Provedor::where('valor',$plan_a->provedor)->first();
            
            if(!isset($provedor->name)) {
                 throw new \Exception("Provedor não encontrado");
                return false;
            }
    
            $api = new ProviderAPI($provedor->url, $provedor->token);
            $dashboard = new Dashboard;
            $period = $dashboard->getPeriod();
    
            if($plan_a->type == 4){ //comment
                $comments = Coment::where('purchase_id', $u->id)->get();
    
                $comentString = '';
                $totalComments = count($comments);
    
                //UNIR TODOS OS COMENTÁRIOS SEPARANDO POR '\n'
                foreach ($comments as $key => $c) {
                    $comentString .= addslashes($c->coment);
    
                    // Adicione uma nova linha se não for o último comentário
                    if ($key < $totalComments - 1) {
                        $comentString .= " \n ";
                    }
    
                }
                $order_a = array(
                    'service' => $plan_a->id_provedor,
                    'link' => $u->profile,
                    'quantity' => $u->quantity,
                    'posts' => 0,
                    'delay' => 5,
                    'comments' => $comentString
                );
        
                $order_r = $api->order($order_a); # Subscriptions 
    
    
                if(!isset($order_r->error) && $order_r != null ){
                    $status_r = $api->status($order_r->order); # return status, charge, remains, start count, currency  
                    
                    echo '<pre>';
                    var_dump($status_r);
                    echo '</pre>';
                    
                    // Entra no loop se o campo currency não estiver presente
                    while (!isset($status_r->currency)) {
                        sleep(5); // Espera 5 segundos antes de tentar novamente
                        $status_r = $api->status($order_r->order); // Tenta obter o status novamente
    
                    }
    
                    echo '<pre>'; 
                        var_dump($status_r);
                    echo '</pre>';
    
                    if($status_r->currency == 'USD'){                     
                        $status_r->charge  *= $dolar;
                    }
                    
                    Order::where("purchase_id", $u->id)->delete();
                    
                    Order::insert(array(
                        'order_id'=> $order_r->order,
                        'purchase_id'=> $u->id,
                        'status'=> $status_r->status,
                        'charge'=> $status_r->charge,
                        'period'=> $period,
                    ));
    
                    $u->status = 'send';
                    $u->price_sale = $this->ajustaPrecoTotalJuros($u->price, $u->payment_method);
                    $u->save();
    
                    //apenas uma vez adicionar a despesa
                    $dashboard->addDespesa($status_r->charge);
    
                    $dashboard->addCustomer($u->email, $u->price, $u->telefone);
    
                    $dashboard->addTotalMonth($u->price_sale);
    
                    $preco = (float) str_replace(',', '.', trim($u->price));
                    $preco_tot = (float) str_replace(',', '.', trim($u->price_tot));
                    $desconto = $preco_tot - $preco;
    
                    // Formatando o resultado como moeda brasileira (real)
                    $u->desconto = 'R$ ' . number_format($desconto, 2, ',', '.');
    
                    $category = Category::find($plan_a->category_id);
    
                    Mail::send(new PaymentMail($u->email, 'você', $plan_a, $category->title, $u));
                }
                else{
                    // echo '<br>com erro antes de enviar para api<br>';
                    echo $plan_a->title . ' =>';
                    print_r($order_r);
                    echo"<br><br>";
                    throw new \Exception("Erro ao enviar pedido para API. Plano: {$plan_a->title} | Resposta da API: " . json_encode($order_r));
                }
            }
            else{
                $order_a = array(
                    'service' => $plan_a->id_provedor,
                    'link' => $u->profile,
                    'quantity' => $u->quantity,
                    'posts' => 0,
                    'delay' => 5,
                );
    
                $order_r = $api->order($order_a); # Subscriptions
                
    
    
                if(!isset($order_r->error) && $order_r != null){
                    $status_r = $api->status($order_r->order); # return status, charge, remains, start count, currency
    
                    // Entra no loop se o campo currency não estiver presente
                    while (!isset($status_r->currency)) {
                        sleep(5); // Espera 5 segundos antes de tentar novamente
                        $status_r = $api->status($order_r->order); // Tenta obter o status novamente
    
                    }
    
                    if($status_r->currency == 'USD'){                     
                        $status_r->charge  *= $dolar;
                    }
                    
                    Order::where("purchase_id", $u->id)->delete();
    
                    Order::insert(array(
                        'order_id'=> $order_r->order,
                        'purchase_id'=> $u->id,
                        'status'=>$status_r->status,
                        'charge'=>$status_r->charge,
                        'period'=> $period,
                    ));
    
                    $u->status = 'send';
                    $u->price_sale = $this->ajustaPrecoTotalJuros($u->price, $u->payment_method);
                    $u->save();
    
                    //apenas uma vez adicionar a despesa
                    $dashboard->addDespesa($status_r->charge);
    
                    $dashboard->addCustomer($u->email, $u->price, $u->telefone);
    
                    $dashboard->addTotalMonth($u->price_sale);
    
                    $preco = (float) str_replace(',', '.', trim($u->price));
                    $preco_tot = (float) str_replace(',', '.', trim($u->price_tot));
                    $desconto = $preco_tot - $preco;
    
                    // Formatando o resultado como moeda brasileira (real)
                    $u->desconto = 'R$ ' . number_format($desconto, 2, ',', '.');
    
                    $category = Category::find($plan_a->category_id);
    
                    Mail::send(new PaymentMail($u->email, 'você', $plan_a, $category->title, $u));
    
                }else{
    
                    echo $plan_a->title . ' =>';
                    print_r($order_r);
                    echo"<br><br>";
                    die;
                }
            }
            Log::info('api_dashboard_reembolsado() method executed successfully. ' . $u->id);
        } catch (\Throwable $e) {
            
            $u = Purchase::where('id', $id)->first();

            if(empty($u)){
                $u->log = $e->getMessage();
                $u->save();
            }

            // Captura qualquer erro e registra no log
            Log::error('Erro fatal na função api_dashboard_reembolsados() id: '. $id .' erro: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withErrors('Erro fatal na função api_dashboard_reembolsados() id: '. $id .' erro: ' . $e->getMessage());
            
        }
        return redirect()->back()->withSuccess('Pedido reenviado com sucesso!');
    }
    
    public function api_simples($id){
        
        Log::info('api_simples() executando. ' . $id);
        
        try{
            $dolar = $this->getCurrentDollarRate();
    
            /* Enviando orders */
            if(!is_numeric($id)){
                return false;
            }      
    
            //unico pedido por vez e se não tiver sido enviado
            $u = Purchase::where('id', $id)->where('status', 'approved')->first();
          
            //se não tiver ele vai retornar evitando assim erros
            if(empty($u)){
                Log::info('api_simples() abortado. ' . $id);
                return;
            }

            $plan_a = Plan::find($u->plan_id);
    
            $provedor = Provedor::where('valor',$plan_a->provedor)->first();
            
            if(!isset($provedor->name)) {
                return false;
            }
    
            $api = new ProviderAPI($provedor->url, $provedor->token);
            $dashboard = new Dashboard;
            $period = $dashboard->getPeriod();
    
            if($plan_a->type == 4){ //comment
                $comments = Coment::where('purchase_id', $u->id)->get();
    
                $comentString = '';
                $totalComments = count($comments);
    
                //UNIR TODOS OS COMENTÁRIOS SEPARANDO POR '\n'
                foreach ($comments as $key => $c) {
                    $comentString .= addslashes($c->coment);
    
                    // Adicione uma nova linha se não for o último comentário
                    if ($key < $totalComments - 1) {
                        $comentString .= " \n ";
                    }
    
                }
                $order_a = array(
                    'service' => $plan_a->id_provedor,
                    'link' => $u->profile,
                    'quantity' => $u->quantity,
                    'posts' => 0,
                    'delay' => 5,
                    'comments' => $comentString
                );
        
                $order_r = $api->order($order_a); # Subscriptions 
    
    
                if(!isset($order_r->error) && $order_r != null ){
                    $status_r = $api->status($order_r->order); # return status, charge, remains, start count, currency  
                    
                    // echo '<pre>';
                    // var_dump($status_r);
                    // echo '</pre>';
                    
                    // Entra no loop se o campo currency não estiver presente
                    while (!isset($status_r->currency)) {
                        sleep(5); // Espera 5 segundos antes de tentar novamente
                        $status_r = $api->status($order_r->order); // Tenta obter o status novamente
    
                    }
    
                    // echo '<pre>'; 
                    //     var_dump($status_r);
                    // echo '</pre>';
    
                    if($status_r->currency == 'USD'){                     
                        $status_r->charge  *= $dolar;
                    }
                    
                    Order::insert(array(
                        'order_id'=> $order_r->order,
                        'purchase_id'=> $u->id,
                        'status'=> $status_r->status,
                        'charge'=> $status_r->charge,
                        'period'=> $period,
                    ));
    
                    $u->status = 'send';
                    $u->price_sale = $this->ajustaPrecoTotalJuros($u->price, $u->payment_method);
                    $u->save();
    
                    //apenas uma vez adicionar a despesa
                    $dashboard->addDespesa($status_r->charge);
    
                    $dashboard->addCustomer($u->email, $u->price, $u->telefone);
    
                    $dashboard->addTotalMonth($u->price_sale);
    
                    $preco = (float) str_replace(',', '.', trim($u->price));
                    $preco_tot = (float) str_replace(',', '.', trim($u->price_tot));
                    $desconto = $preco_tot - $preco;
    
                    // Formatando o resultado como moeda brasileira (real)
                    $u->desconto = 'R$ ' . number_format($desconto, 2, ',', '.');
    
                    $category = Category::find($plan_a->category_id);
    
                    Mail::send(new PaymentMail($u->email, 'você', $plan_a, $category->title, $u));
                }
                else{
                    // echo '<br>com erro antes de enviar para api<br>';
                    // echo $plan_a->title . ' =>';
                    // print_r($order_r);
                    // echo"<br><br>";
                     die;
                }
            }
            else{
                $order_a = array(
                    'service' => $plan_a->id_provedor,
                    'link' => $u->profile,
                    'quantity' => $u->quantity,
                    'posts' => 0,
                    'delay' => 5,
                );
    
                $order_r = $api->order($order_a); # Subscriptions
                
                if(!isset($order_r->error) && $order_r != null){
                    $status_r = $api->status($order_r->order); # return status, charge, remains, start count, currency
    
                    // Entra no loop se o campo currency não estiver presente
                    while (!isset($status_r->currency)) {
                        sleep(5); // Espera 5 segundos antes de tentar novamente
                        $status_r = $api->status($order_r->order); // Tenta obter o status novamente
    
                    }
    
                    if($status_r->currency == 'USD'){                     
                        $status_r->charge  *= $dolar;
                    }
    
                    Order::insert(array(
                        'order_id'=> $order_r->order,
                        'purchase_id'=> $u->id,
                        'status'=>$status_r->status,
                        'charge'=>$status_r->charge,
                        'period'=> $period,
                    ));
    
                    $u->status = 'send';
                    $u->price_sale = $this->ajustaPrecoTotalJuros($u->price, $u->payment_method);
                    $u->save();
    
                    //apenas uma vez adicionar a despesa
                    $dashboard->addDespesa($status_r->charge);
    
                    $dashboard->addCustomer($u->email, $u->price, $u->telefone);
    
                    $dashboard->addTotalMonth($u->price_sale);
    
                    $preco = (float) str_replace(',', '.', trim($u->price));
                    $preco_tot = (float) str_replace(',', '.', trim($u->price_tot));
                    $desconto = $preco_tot - $preco;
    
                    // Formatando o resultado como moeda brasileira (real)
                    $u->desconto = 'R$ ' . number_format($desconto, 2, ',', '.');
    
                    $category = Category::find($plan_a->category_id);
    
                    Mail::send(new PaymentMail($u->email, 'você', $plan_a, $category->title, $u));
    
                }else{
    
                    // echo $plan_a->title . ' =>';
                    // var_dump($order_r);
                    // echo"<br><br>";
                     die;
                }
            }
            Log::info('api_simples() method executed successfully. ' . $u->id);
        } catch (\Throwable $e) {
            echo $e->getMessage();
            $u = Purchase::where('id', $id)->first();
    
            if(empty($u)){
                $u->log = $e->getMessage();
                $u->save();
            }
         
            // Captura qualquer erro e registra no log
            Log::error('Erro fatal na função api_simples() id: '. $id .' erro: ' . $e->getMessage(), ['exception' => $e]);
            
            // return redirect()->back()->withErrors('Erro fatal na função api_dashboard() id: '. $id .' erro: ' . $e->getMessage());
            
        }
        
        $u = Purchase::where('status', 'approved')->orderBy('id', 'desc')->first();
        
        //se tiver pedido ele vai chamar a função novamente
        if(isset($u->id)){
            $this->api_simples($u->id);
        }
        
        // return redirect()->back()->withSuccess('Pedido enviado com sucesso!');
    }

    private function getCurrentDollarRate(): float
    {

        return 5;
        $url = "https://api.bcb.gov.br/dados/serie/bcdata.sgs.10813/dados/ultimos/1?formato=json";

        // Inicializa cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'User-Agent: SeuUserAgent',
            'Accept: application/json'
        ));
        
        // Executa a requisição
        $response = curl_exec($ch);

        // Fecha a sessão cURL
        curl_close($ch);

        if ($response) {
            $data = json_decode($response, true);
            if (!empty($data)) {
                return number_format(floatval($data[0]['valor']), 2, '.');
            }
        }
        //padrão em caso de erro
        return 5;
    }


    public function ifPostExist(Request $request){
        $file = 'https://www.instagrm.com/p/CiyH4JMn1/';
        $file_headers = @get_headers($file);
        dd($file_headers);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            $exists = false;
            dd(false);
        }
        else {
            $exists = true;
            dd(true);
        }
    }
    
}
