<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Dashboard as ModelDashboard;
use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Dashboard extends Controller
{

    private string $period;
    private array $states = [
        '68' => 'Acre',
        '82' => 'Alagoas',
        '96' => 'Amapa',
        '92' => 'Amazonas',
        '97' => 'Amazonas',
        '71' => 'Bahia',
        '73' => 'Bahia',
        '74' => 'Bahia',
        '75' => 'Bahia',
        '77' => 'Bahia',
        '85' => 'Ceara',
        '88' => 'Ceara',
        '61' => 'Distrito Federal',
        '27' => 'Espirito Santo',
        '28' => 'Espirito Santo',
        '62' => 'Goias',
        '64' => 'Goias',
        '98' => 'Maranhao',
        '99' => 'Maranhao',
        '65' => 'Mato Grosso',
        '66' => 'Mato Grosso',
        '67' => 'Mato Grosso do Sul',
        '31' => 'Minas Gerais',
        '32' => 'Minas Gerais',
        '33' => 'Minas Gerais',
        '34' => 'Minas Gerais',
        '35' => 'Minas Gerais',
        '37' => 'Minas Gerais',
        '38' => 'Minas Gerais',
        '91' => 'Para',
        '93' => 'Para',
        '94' => 'Para',
        '83' => 'Paraiba',
        '41' => 'Parana',
        '42' => 'Parana',
        '43' => 'Parana',
        '44' => 'Parana',
        '45' => 'Parana',
        '46' => 'Parana',
        '81' => 'Pernambuco',
        '87' => 'Pernambuco',
        '86' => 'Piaui',
        '89' => 'Piaui',
        '21' => 'Rio de Janeiro',
        '22' => 'Rio de Janeiro',
        '24' => 'Rio de Janeiro',
        '84' => 'Rio Grande do Norte',
        '51' => 'Rio Grande do Sul',
        '53' => 'Rio Grande do Sul',
        '54' => 'Rio Grande do Sul',
        '55' => 'Rio Grande do Sul',
        '69' => 'Rondonia',
        '95' => 'Roraima',
        '47' => 'Santa Catarina',
        '48' => 'Santa Catarina',
        '49' => 'Santa Catarina',
        '11' => 'Sao Paulo',
        '12' => 'Sao Paulo',
        '14' => 'Sao Paulo',
        '15' => 'Sao Paulo',
        '16' => 'Sao Paulo',
        '17' => 'Sao Paulo',
        '18' => 'Sao Paulo',
        '19' => 'Sao Paulo',
        '79' => 'Sergipe',
        '63' => 'Tocantins'
    ];

    public function __construct()
    {   
        $this->period = $this->getPeriod();
    }

    public function index(Request $request)
    {

        if($request->period){
            $this->period = $request->period;
        }
        
        $newCustomerAndState = $this->getNewCustomersAndState();
        $allCustomerAndState = $this->getAllCustomersAndState();

        $resultMensal = $this->getDashboardMensal();
        
        // Consulta para obter o total das compras
        $totalCompras = Purchase::approved()->sum('price');
        
        $lucroDiario = $this->getLucroDia();
        
        //ajusta aqui os pedidos reembolsados
        $reembolsados = $this->getReembolsados();
        
        $totalClientes = Purchase::distinct('email')->count('email');
        
        $graficoAnual = $this->getGraficoAnual();
        
        $periods = $this->getAllPeriods();
            
        return view('dashboard.metrics.index', [
            'resultMensal'          => $resultMensal,
            'totalCompras'          => $totalCompras,
            'totalClientes'         => $totalClientes,
            'reembolsados'          => $reembolsados,
            'lucroDiario'           => $lucroDiario,
            'graficoAnual'          => $graficoAnual,
            'periods'               => $periods,
            'request'               => $request,
            'period'                => $this->period,
            'newCustomerAndState'   => $newCustomerAndState,
            'allCustomerAndState'   => $allCustomerAndState,
        ]);

    }

    public function getGraficoAnual():array 
    {
        return ModelDashboard::select(
            'id',
            'period',
            DB::raw('SUM(total_sales) AS total_sales'),
            DB::raw('SUM(total_expenses) AS total_expenses'),
            DB::raw('SUM(total_sales - total_expenses) AS lucro')
            )
            ->groupBy('id')
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
    }

    public function getReembolsados():Collection 
    {
        return Order::where('period', $this->period)
        ->wherein('status', ['Partial', 'Refunded', 'Canceled'])
        ->get();
    }

    public function getAllPeriods():Collection
    {
       return  ModelDashboard::distinct()->select('period')->get();
    }

    public function getDashboardMensal():ModelDashboard
    {
        $dashboard = ModelDashboard::where("period", $this->period)->first();

        if(!$dashboard){
            $dashboard = $this->createIfNotExists();
        }

        return $dashboard;

    }

    public function getLucroDia():float
    {
        $dataAtual = now()->toDateString(); // Obtém o dia atual

        $result = Purchase::join('orders', 'purchases.id', '=', 'orders.purchase_id')
            ->whereDate('purchases.created_at', $dataAtual)
            ->whereIn('purchases.status', ['send', 'approved'])
            ->whereNotIn('orders.status', ['Refunded', 'Canceled', 'Partial'])
            ->select(DB::raw('IFNULL(SUM(purchases.price_sale - orders.charge), 0) AS lucro_total'))
            ->first()
            ->lucro_total;

        return $result;
    }


    public function addTotalMonth(float $value):void
    {
        $dashboard = $this->createIfNotExists();

        $dashboard->total_sales += $value;
        $dashboard->save();

    }

    public function addCustomer(string $email, float $price, string $phone):void
    {
        
        $dashboard = ModelDashboard::where('period', $this->period)->first();

        $customer = Customer::where('email', $email)->first();

        //já é cliente?
        if(!$customer){
            $customer = $this->createCustomer($email, $phone);
        }

        // Se for cliente desse mês atualizar total de compras
        if ($customer->period == $this->period) {

            $dashboard->new_customers_purchases += $price;
            $dashboard->save(); 
            return;

        }

        $dashboard->old_customers += 1;
        $dashboard->old_customers_purchases += $price;
        $dashboard->save(); 
        
    }

    public function createIfNotExists():ModelDashboard
    {
   
        // Verificar se já existe um registro para o período atual
        $dashboard = ModelDashboard::where('period', $this->period)->first();

        // Se não existir, criar um novo registro
        if (!$dashboard) {
            $dashboard = new ModelDashboard();
            $dashboard->period = $this->period;
            $dashboard->total_sales = 0;
            $dashboard->total_expenses = 0;
            $dashboard->new_customers = 0;
            $dashboard->new_customers_purchases = 0;
            $dashboard->old_customers = 0;
            $dashboard->old_customers_purchases = 0;
            $dashboard->total_customer_purchases = 0;
            $dashboard->save();
        }

        return $dashboard;
    }   

    public function createCustomer(string $email, string $phone):Customer
    {

        //adiciona cliente ao total
        $dashboard = ModelDashboard::where('period', $this->period)->first();
        $dashboard->new_customers += 1;
        $dashboard->save();
   

        $state = $this->getState($phone);

        $customer = new Customer;
        $customer->email = $email;
        $customer->state = $state;
        $customer->period = $this->period;
        $customer->save();

        return $customer;
        
    }

    public function getState($phone):string
    {

        $startIndex = strpos($phone, '(') + 1;
        $endIndex = strpos($phone, ')');

        $ddd = substr($phone, $startIndex, $endIndex - $startIndex);

        if (!empty($this->states)) {
            
            // Verificar se o DDD está mapeado e retornar o estado correspondente
            if (isset($this->states[$ddd])) {
                return $this->states[$ddd];
            }

        }

        // Retornar vazio se o DDD não estiver mapeado
        return '';
    }
 

    /**
     * subtrair as despesas do mês
     */
    public function subtrairDespesa(float $despesa, string $period, float $price, float $price_sale, string $email):void
    {

        $customer = Customer::where('email', $email)->first();

        $dashboard = ModelDashboard::where('period', $period)->first();
        $dashboard->total_expenses -= $despesa;
        $dashboard->total_sales -= $price_sale;

        //verifica se é cliente novo para subtrair o total
        if(isset($customer->period) && $customer->period == $this->period){
            $dashboard->new_customers_purchases -= $price;
        }else{
            $dashboard->old_customers_purchases -= $price;
        }

        $dashboard->save();

    }

    public function addDespesa(float $value):void
    {
        $dashboard = ModelDashboard::where('period', $this->period)->first();
        $dashboard->total_expenses += $value;
        $dashboard->save();

    }

    public function reajustarDashboard($purchase_id):void
    {

        $purchase = Purchase::find($purchase_id); 
        $order = Order::where("purchase_id", $purchase_id)->first();

        $this->subtrairDespesa($order->charge, $order->period, $purchase->price,$purchase->price_sale, $purchase->email);
    }

    public function ComprasMensal(Request $request)
    {

        $search = $request->search;

        if($request->period){
            $this->period = $request->period;
        }

        $totalMensalPorClienteQuery = Purchase::select(
                DB::raw('SUM(price) as price_total'),
                'email',
                'telefone',
                DB::raw('COUNT(1) AS total_de_compras')
            )
            ->where('period', $this->period)
            ->whereIn('status', ['send', 'approved'])
            ->groupBy('email', 'telefone')
            ->orderBy('total_de_compras', 'desc')
            ->orderBy('price_total', 'desc');

        // Aplicar filtros à consulta totalMensalPorClienteQuery, se necessário
        if ($search) {
            $totalMensalPorClienteQuery->where(function ($query) use ($search) {
                $query->where('email', 'like', '%' . $search . '%')
                    ->orWhere('telefone', 'like', '%' . $search . '%');
            });
        }

        // Executar a consulta totalMensalPorClienteQuery
        $totalMensalPorCliente = $totalMensalPorClienteQuery->paginate(15);

        // return $totalMensalPorCliente;
        return view('dashboard.metrics.purchasesMonth', [
            'purchases' => $totalMensalPorCliente,
            'periods' => $this->getAllPeriods(),
            'request' => $request,
        ]);
    }

    public function getNewCustomersAndState():array
    {   
       $result = Customer::select('state', DB::raw('COUNT(1) as total'))
       ->where('period', $this->period)
       ->groupBy('state')
       ->get()
       ->toArray();

       return $result;
    }

    public function getAllCustomersAndState():array
    {   
       $result = Customer::select('state', DB::raw('COUNT(1) as total'))
       ->groupBy('state')
       ->get()
       ->toArray();

       return $result;
    }
    
    public function getPeriod():string
    {
        // Obter o ano atual
        $ano = date("Y");

        // Obter o mês atual
        $mes = date("n");

        return $mes .'/' . $ano;

    }
      public function vendasCategorias(Request $request)
    {

        if($request->period){
            $this->period = $request->period;
        }

        $totalComprasCategorias = Purchase::select(
            DB::raw('SUM(purchases.price) AS price_total'),
            DB::raw('c.title AS category'),
            DB::raw('purchases.period AS period')
        )
        ->join('plans AS pl', 'purchases.plan_id', '=', 'pl.id')
        ->join('categories AS c', 'pl.category_id', '=', 'c.id')
        ->where('purchases.period', $this->period)
        ->whereIn('purchases.status', ['send', 'approved'])
        ->groupBy('c.id', 'purchases.period')
        ->orderBy('price_total', 'desc')
        ->get();

        $totalComprasCupons = Purchase::select(
            DB::raw('SUM(purchases.price_tot) AS preco_total'),
            DB::raw('SUM(purchases.price) AS preco_desconto'),
            DB::raw('c.nome AS nome'),
            DB::raw('c.desconto AS desconto'),
            DB::raw('COUNT(purchases.id) AS total_compras')
        )
        ->join('venda_cupom AS vc', 'vc.compra_id', '=', 'purchases.id')
        ->join('cupons AS c', 'c.nome', '=', 'vc.nome_cupom')
        ->where('purchases.period', $this->period)
        ->whereIn('purchases.status', ['send', 'approved'])
        ->groupBy('c.nome', 'purchases.period', 'c.desconto')
        ->get();

        return view('dashboard.metrics.vendasCategorias', [
            'purchases' => $totalComprasCategorias,
            'totalComprasCupons' => $totalComprasCupons,
            'periods' => $this->getAllPeriods(),
            'request' => $request,
        ]);
    }


}