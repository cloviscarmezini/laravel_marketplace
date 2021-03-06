<?php

namespace App\Http\Controllers;

use App\Payment\PagSeguro\CreditCard;
use App\Payment\PagSeguro\Notification;
use Exception;
use Illuminate\Http\Request;
use App\Store;
use Ramsey\Uuid\Uuid;

class CheckoutController extends Controller
{
    public function index()
    {
        if(!Auth()->check()){
            return redirect()->route('login');
        }

        if(!session()->has('cart')) return redirect()->route('home');

        $this->makePagSeguroSession();

        $cartItems = array_map(function($line){
            return $line['amount'] * $line['price'];
        }, session()->get('cart'));

        $cartItems = array_sum($cartItems);

        return view('checkout', compact('cartItems'));

    }

    public function proccess(Request $request)
    {
        try {
            $dataPost = $request->all();
            $user = Auth()->user();
            $cartItems = session()->get('cart');
            $stores = array_unique(array_column($cartItems, 'store_id'));
            $reference = Uuid::uuid4();

            //var_dump($reference);exit;

            $creditCardPayment = new CreditCard($cartItems, $user, $dataPost, $reference);

            $result = $creditCardPayment->doPayment();

            $userOrder = [
                'reference' => $reference,
                'pagseguro_code' => $result->getCode(),
                'pagseguro_status' => $result->getStatus(),
                'items' => serialize($cartItems)
            ];

            $userOrder = $user->orders()->create($userOrder);

            $userOrder->stores()->sync($stores);

            //Notificar loja de novo pedido

            $store = (new Store())->notifyStoreOwners($stores);

            session()->forget('cart');
            session()->forget('pagseguro_session_code');

            return response([
                'data' => [
                    'status'  => true,
                    'message' => 'Pedido criado com sucesso',
                    'order'   => $reference
                ]
            ]);
        }
        catch(\Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar pedido!';
            return response([
                'data' => [
                    'status'  => false,
                    'message' => $message
                ]
                ],401);
        }
    }

    public function thanks()
    {
        return view('thanks');
    }

    public function notification()
    {
        try {
            $notification = new Notification();

            $notification = $notification->getTransaction();

            //atualizar pedido usu??rio
            $reference = base64_decode($notification->getReference());
            $userOrder = UserOrder::whereReferene($reference);
            $userOrder->update([
                'pagseguro_status' => $notification->getStatus()
            ]);
            //coment??rios sobre o pedido pago
            if($notification->getStatus() == 3) {
                //Liberar o pedido do usu??rio, atualizar o status do pedido para separa????o
                //Notificar o usu??rio que o pedido foi pago...
                //Notificar a loja da confirma????o do pedido...
            }

            return response()->json([], 204);

        } catch(Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : '';
            return response()->json(['error' => $message], 500);
        }
    }

    private function makePagSeguroSession()
    {
        if(!session()->has('pagseguro_session_code')){
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            session()->put('pagseguro_session_code', $sessionCode->getResult());
        }
    }
}
