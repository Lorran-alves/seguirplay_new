<?php

use App\Http\Controllers\Dashboard\Dashboard;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\CategoryController as CategoryControllerDashboard;
use App\Http\Controllers\Dashboard\CuponsController;
use App\Http\Controllers\Dashboard\MonetizaController;
use App\Http\Controllers\Dashboard\PurchaseController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\ProvedoresController;
use App\Http\Controllers\Email\EmailController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\PurchaseController as PurchaseControllerWeb;
use App\Http\Controllers\Web\WebhooksController;
use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;
use App\Mail\PaymentMail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\LinkController;
use App\Http\Controllers\Dashboard\GestorPedidoManualController;

use App\Models\Plan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Dashboard
Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::name('auth.')->group(function () {
            Route::get('/entrar', 'formLogin')->name('formLogin');
            Route::post('/entrar', 'login')->name('login');
            Route::post('/sair', 'logout')->name('logout');
        });
    });

    Route::middleware('auth')->group(function () {
        Route::controller(Dashboard::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/comprasMensal', 'ComprasMensal')->name('comprasMensal');
            Route::get('/vendasCategorias', 'vendasCategorias')->name('vendasCategorias');
        });

        // Purchases
        Route::controller(PurchaseController::class)->group(function () {
            Route::name('purchases.')->group(function () {
                Route::get('/compras', 'index')->name('index');
                Route::get('/comprasClientesInativos', 'customersInactives')->name('customersInactives');
                Route::get('/aprovar/{purchase_id}', 'approved')->name('approved');
                Route::delete('/deletar/{purchase_id}', 'destroy')->name('destroy');
                Route::put('/purchase/update', 'update')->name('update');
                Route::get('/purchase/edit/{purchase_id}', 'edit')->name('edit');
            });
        });
        
      
        // Categories
        Route::controller(CategoryControllerDashboard::class)->group(function () {
            Route::name('categories.')->group(function () {
                Route::get('/categorias', 'index')->name('index');
                Route::get('/categorias/novo', 'create')->name('create');
                Route::post('/categorias/novo', 'store')->name('store');
                Route::get('/categorias/{category}', 'show')->name('show');
                Route::get('/categorias/getServices/{category}', 'getServices')->name('getServices');
                Route::delete('/categorias/{category}', 'destroy')->name('destroy');
                Route::post('/categorias/update', 'update')->name('update');
                Route::post('/categorias/getServiceMultiple', 'getServicesMultiple')->name('getServicesMultiple');
            });
        });

        // Services
        Route::controller(ServiceController::class)->group(function () {
            Route::name('services.')->group(function () {
                Route::get('/servicos/novo', 'create')->name('create');
                Route::post('/servicos/novo', 'store')->name('store');
                Route::put('/servicos/atualizar/{plan}', 'update')->name('update');
                Route::get('/servicos/editar/{plan}', 'edit')->name('edit');
                Route::get('/servicos/desativar/{plan}', 'desactive')->name('desactive');
                Route::get('/servicos/ativar/{plan}', 'active')->name('active');
                Route::delete('/servicos/apagar/{plan}', 'destroy')->name('destroy');
                Route::post('/servicos/getDetalhePano', 'getDetalhePano')->name('getDetalhePano');
            });
        });

        // provedores
        Route::controller(ProvedoresController::class)->group(function () {
            Route::name('provedores.')->group(function () {
                Route::get('/provedores/index', 'index')->name('index');
                Route::get('/provedores/novo', 'create')->name('create');
                Route::post('/provedores/novo', 'store')->name('store');
                Route::put('/provedores/atualizar/{id}', 'update')->name('update');
                Route::get('/provedores/editar/{id}', 'edit')->name('edit');
                Route::get('/provedores/desativar/{id}', 'desactive')->name('desactive');
                Route::get('/provedores/ativar/{id}', 'active')->name('active');
                //Route::delete('/provedores/apagar/{id}', 'destroy')->name('destroy');
            });
        });

        // cupons
        Route::controller(CuponsController::class)->group(function () {
            Route::name('cupons.')->group(function () {
                Route::get('/cupons/index', 'index')->name('index');
                Route::get('/cupons/novo', 'create')->name('create');
                Route::post('/cupons/novo', 'store')->name('store');
                Route::put('/cupons/atualizar/{id}', 'update')->name('update');
                Route::get('/cupons/editar/{id}', 'edit')->name('edit');
                Route::get('/cupons/desativar/{id}', 'desactive')->name('desactive');
                Route::get('/cupons/ativar/{id}', 'active')->name('active');
                //Route::delete('/provedores/apagar/{id}', 'destroy')->name('destroy');
            });
        });

        // COMPRAS MONETIZA
        Route::controller(MonetizaController::class)->group(function () {
            Route::name('monetiza.')->group(function () {
                Route::get('/monetiza/compras', 'index')->name('index');
                Route::get('/monetiza/aprovar/{compra_id}', 'approved')->name('approved');
                Route::delete('/monetiza/deletar/{compra_id}', 'destroy')->name('destroy');
                Route::get('/gestaoMonetiza', 'gestaoMonetiza')->name('gestaoMonetiza');
            });
        });
        
        Route::controller(GestorPedidoManualController::class)->group(function () {
            Route::name('gestaoPedidoManual.')->group(function () {
                Route::get('/pedidoManual', 'index')->name('index');
                Route::post('/pedidoManual/gerarPix', 'gerarPix')->name('gerarPix');
                Route::post('/pedidoManual/gerarPixCart', 'gerarPixCart')->name('gerarPixCart');
                Route::post('/pedidoManual/addToCart', 'addToCart')->name('addToCart');
                Route::delete('/pedidoManual/removeFromCart/{index}', 'removeFromCart')->name('removeFromCart');
                Route::get('/pedidoManual/cartClear', 'cartClear')->name('cartClear');
                Route::get('/pedidoManual/getCart', 'getCart')->name('getCart');
            });
        });
        
    });
});

Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart');
    Route::get('/cart/cookies', 'acceptCookies')->name('cookies');
    Route::post('/cart/add/{plan}', 'addToCart')->name('cartAdd');
    Route::delete('/cart/remove/{index}', 'removeFromCart')->name('cartRemove');
    Route::get('/cart/clear', 'clearCart')->name('cartClear');
});

// Web
Route::group(['as' => 'web.'], function () {
    Route::controller(WebController::class)->group(function () {
        Route::get('/', 'home')->name('home');
        Route::post('/pedido', 'verificaPedido')->name('verificaPedido');
        Route::get('/pedido/{email?}', 'pedidos')->name('pedidos');
        Route::get('/contato', 'contact')->name('contact');
        Route::post('/contato', 'contactform')->name('contactform');
        Route::get('/perguntas-frequentes', 'faq')->name('faq');
        Route::get('/politicas-de-privacidade', 'policies')->name('policies');
        Route::get('/seja-um-revendedor', 'dealer')->name('dealer');
        Route::get('/termos-e-condicoes', 'term')->name('term');
        Route::get('/if-post-exist', 'ifPostExist')->name('ifPostExist');
        Route::get('/api', 'api')->name('api');
        Route::get('/api_dashboard/{id}', 'api_dashboard')->name('api_dashboard');
        Route::get('/api_simples/{id}', 'api_simples')->name('api_simples');
        Route::get('/api_dashboard_test/{id}', 'api_dashboard_test')->name('api_dashboard_test');
        Route::post('/api_dashboard_reembolsado/{id}', 'api_dashboard_reembolsado')->name('api_dashboard_reembolsado');
        Route::get('/compra-finalizada', 'compraFinalizada')->name('compraFinalizada');
        Route::post('/verificarCupom', 'verificarCupom')->name('verificarCupom');
        // Route::get('/api_home', 'api_home')->name('api_home');
        
        
    });
    
    Route::controller(LinkController::class)->group(function () {
        Route::post('/getPlatformData/{platform}', 'getPlatformData')->name('getPlatformData');
    });


    // Categories
    Route::controller(CategoryController::class)->group(function () {
        Route::name('categories.')->group(function () {
            Route::get('/{slug}', 'show')->name('show');
        });
    });

    // emails
    Route::prefix('email')->group(function () {
        Route::name('email.')->group(function () {
            Route::get('/lembrete', [EmailController::class, 'lembrete'])->name('lembrete');
            Route::get('/lembreteWeek', [EmailController::class, 'lembreteWeek'])->name('lembreteWeek');
            Route::get('/lembreteMonth', [EmailController::class, 'lembreteMonth'])->name('lembreteMonth');
            Route::get('/cancelar/{email}', [EmailController::class, 'cancelar'])->name('cancelar');
        });
    });

    // Purchases
    Route::controller(PurchaseControllerWeb::class)->group(function () {
        Route::name('purchases.')->group(function () {
            Route::post('/compra/{plan}', 'buy')->name('buy');
            Route::post('/compra/{plan}/pix', 'pix')->name('pix');
            Route::post('/compra/{plan}/buyCard', 'buyCard')->name('buyCard');
            Route::post('/compra/processPayment/card', 'processPaymentCard')->name('processPaymentCard');
            Route::post('/compra/{purchase}/ispay', 'ispay')->name('ispay');
            Route::get('/compra/{purchase_id}/pay', 'pay')->name('pay');
            Route::get('/compra/cart', 'pixCart')->name('pixCart');
            Route::get('/compra/cardCart', 'cardCart')->name('cardCart');
        });
    });
});

//Webhooks
Route::post('/webhooks/{purchase_id}', WebhooksController::class)->name('webhooks');
