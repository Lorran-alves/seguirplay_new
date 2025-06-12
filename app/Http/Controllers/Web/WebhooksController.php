<?php

namespace App\Http\Controllers\Web;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Purchase;

class WebhooksController extends Controller
{
    public function __invoke($purchase_id, Request $request){
        $fp = fopen("logs_mercado_pago2.txt","a");
        fwrite($fp, $purchase_id);
        fwrite($fp, PHP_EOL);
        fwrite($fp, now());
        fwrite($fp, PHP_EOL);
        fwrite($fp, json_encode($request->all()));
        fwrite($fp, PHP_EOL);
        fwrite($fp, '=============================================================');
        fwrite($fp, PHP_EOL);
        fclose($fp);
        
        if($purchase_id != null){
            if( isset($request->topic) ){
                if($request->topic == 'payment'){
                    $purchase = Purchase::where('id', $purchase_id)->where('status', 'pending')->first();
                    
                    if(empty($purchase)){
                        return;
                    }
                    
                    $payment_id = $request->id;
                    $response = json_decode(Http::get("https://api.mercadopago.com/v1/payments/$payment_id"."?access_token=APP_USR-1862735257368010-072921-bfafa63d92f95d243e36b72dee54b99f-177082211"));
                    
                    $purchase->payment_id = $payment_id;
                    $purchase->status = $response->status != null ? $response->status : $purchase->status ;

                    $purchase->payment_method = $response->payment_method_id != null ? $response->payment_method_id : $purchase->payment_method;
                    
                    $purchase->save();
                    
                    Purchase::where('purchase_pai_id', $purchase_id)->update([
                        'status' => $response->status != null ? $response->status : $purchase->status,
                        'payment_method' => $response->payment_method_id != null ? $response->payment_method_id : $purchase->payment_method,
                        'payment_id' => $payment_id
                    ]);
                    
                    $webController = new WebController();
                    $webController->api_dashboard($purchase_id);

                    $purchases = Purchase::where('purchase_pai_id', $purchase_id)->get();
                    if($purchases->count() > 0){
                        foreach($purchases as $purchase_child){
                            $webController->api_dashboard($purchase_child->id);
                        }
                    }
                }
            }
        }
        
        return;
    }
}
