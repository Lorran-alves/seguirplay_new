<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{  
    public function index()
    {
        
        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
        $category = new CategoryController();
        $cupons = $category->getCupons();
        
        return view('web.cart', ['cart' => $cart, 'cupons' => json_encode($cupons)]);
    }

    public function addToCart(Request $request, Plan $plan)
    {
       
        $cart = [];
        
        if (isset($_COOKIE['cart'])) {
            $cart = json_decode($_COOKIE['cart'], true);
        } 

        if (isset($_COOKIE['userCart'])) {
            $user = json_decode($_COOKIE['userCart'], true);
        }else{
            $user = [
                'telefone' => $request->telefone,
                'email' => $request->email
            ];
        }

        $category = $plan->category;
 
        $item = [
            'id' => uniqid(), //identificador único
            'profile' => $request->profile,
            'quantity' => $request->quantity,
            'price' => (empty($plan->quantity_min) ? $plan->price : $plan->price * $request->quantity),
            'plan_id' => $plan->id,
            'category' => $category->title,
            'plan' => $plan->title
        ];

        if($plan->type == 4) {
            
            $comments = [];

            for ($i = 1; $i <= ($request->cmnt_q ?? 1); $i++) {
                $comments[] = $request->input('cmnt_' . $i);
            }

            $item['comments'] = $comments;
            $item['cmnt_q'] = $request->cmnt_q;
        }

        $cart[] = $item;

    

        $expiracao = time() + (2 * 60 * 60); // 2 horas em segundos

        setcookie('cart', json_encode($cart), $expiracao, '/');

        setcookie('userCart', json_encode($user), $expiracao, '/');
        
        return response()->json(['message' => 'Produto adicionado ao carrinho!']);
    }

    // Remover item do carrinho
    public function removeFromCart($index)
    {
       
        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

        // Filtrar os itens, removendo o que tem o ID correspondente
        $cart = array_filter($cart, function ($item) use ($index) {
            return $item['id'] !== $index;
        });

        // Reindexar o array
        $cart = array_values($cart);

        // Atualizar o cookie
        $expiracao = time() + (2 * 60 * 60);
        setcookie('cart', json_encode($cart), $expiracao, '/');

        // Calcular o novo total
        $total = array_sum(array_column($cart, 'price'));

        return response()->json([
            'message' => 'Produto removido do carrinho!',
            'total' => number_format($total, 2, ',', '.')
        ]);
    }

    public function acceptCookies()
    {

        $expiracao = now()->addHours(2);

        $expiracao = time() + (2 * 60 * 60);
        setcookie('seguirplay_cookies_aceitos', 'true', $expiracao, "/");

        return response()->json(['message' => 'Cookies Salvo!']); 
    }
    
    public function clearCart()
    {   
        
        setcookie('cart', '', time() - 3600, '/');
        return response()->json(['message' => 'Carrinho limpo!']);
    }
    
}
