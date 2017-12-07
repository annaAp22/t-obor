<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Good;
use App\Models\Order;
use Validator;

class OrderController extends Controller
{
    /**
     * Корзина
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cart() {
        if(session()->has('goods.cart')) {
            $cart = session()->get('goods.cart');
            //товары коллекции
            $cart['goods'] = Good::whereIn('id', array_keys($cart))->where('status', 1)->with(['buyalso', 'buyalso.attributes'])->get();
            //с товарами покупают
            $cart['buyalso'] = collect();
            foreach($cart['goods'] as $key => $good) {
                $good->count = $cart[$good->id]['cnt'];
                $good->amount = $cart[$good->id]['cnt'] * $good->price;

                $cart['buyalso'] = $cart['buyalso']->merge($good->buyalso);
            }
            $cart['buyalso'] = $cart['buyalso']->unique('id')->reject(function ($item, $key) use ($cart) {
                $id = $item->id;
                return $cart['goods']->search(function ($item2, $key2) use ($id) {
                    return $item2->id == $id;
                })!==false;
            });
            $cart['amount'] = $cart['goods']->sum('amount');
        }

        $this->setMetaTags();
        return view('order.cart', ['cart' => !empty($cart) ? $cart : null]);
    }

    /**
     * Сохранение изменений в корзине
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cartEdit(Request $request) {
        if(!$request->has('goods') || !is_array($request->input('goods')) || !count($request->input('goods')) || !session()->has('goods.cart'))  {
            return redirect()->route('cart');
        }
        $cart = session()->get('goods.cart');
        session()->forget('goods.cart');
        foreach($request->input('goods') as $id => $cnt) {
            session()->put('goods.cart.'.$id, ['cnt' => $cnt, 'price' => $cart[$id]['price']]);
        }
        return redirect()->route('order');
    }

    /**
     * Оформление заказа - выбор доставки и оплаты
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function order() {
        if(!session()->has('goods.cart')) {
            return redirect()->route('cart');
        }

        $cart = session()->get('goods.cart');
        //товары коллекции
        $cart['goods'] = Good::whereIn('id', array_keys($cart))->where('status', 1)->get();
        foreach($cart['goods'] as $key => $good) {
            $good->count = $cart[$good->id]['cnt'];
            $good->amount = $cart[$good->id]['cnt'] * $good->price;
        }
        $cart['amount'] = $cart['goods']->sum('amount');

        //способы доставки
        $deliveries = \App\Models\Delivery::where('status', 1)->orderBy('id')->get();
        //способы оплаты
        $payments = \App\Models\Payment::where('status', 1)->orderBy('id')->get();

        $this->setMetaTags();
        return view('order.order', ['cart' => $cart, 'deliveries' => $deliveries, 'payments' => $payments]);
    }

    /**
     * Сохранение заказа
     * @param Requests\DeliveryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delivery(\App\Http\Requests\DeliveryRequest $request) {
        if(!session()->has('goods.cart')) {
            return redirect()->route('cart');
        }
        $data = $request->input();
        $data['datetime'] = date('Y-m-d H:i:s');
        $data['status'] = 'wait';
        $data['payment_add'] = 'Местоположение: '.$data['city'].', Почтовый индекс: '.$data['index'].', Комментарий: '.$data['payment_add'];

        $order = Order::create($data);
        $amount = 0;
        foreach(session()->get('goods.cart') as $good_id => $good) {
            $order->goods()->attach($good_id, ['cnt' => $good['cnt'], 'price' => $good['price']]);
            $amount += $good['cnt']*$good['price'];
        }
        $order->update(['amount' => $amount]);

        session()->forget('goods.cart');

        session()->flash('goods.order.id', $order->id);
        session()->flash('goods.order.name', $order->name);
        return redirect()->route('order.confirm');
    }

    /**
     * Страница благодарности за заказ
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function confirm() {
        if(!session()->has('goods.order')) {
            return redirect()->route('cart');
        }

        $this->setMetaTags();
        return view('order.confirm', [
            'order_id' => session()->get('goods.order.id'),
            'customer' => session()->get('goods.order.name'),
        ]);
    }


    /**
     * Быстрый заказ
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fast(Request $request) {
        $data = $request->input();

        $validator = Validator::make($data, [
            'id' => 'required|exists:goods,id',
            'name' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['message' => 'При оформлении заказа произошла ошибка. Попробуйте снова.']);

        $good = Good::find($request->input('id'));
        $quantity = $request->input('quantity');
        $amount = $good->price * $quantity;
        $data = ['name' => $request->input('name'), 'phone' => $request->input('phone'), 'amount' => $amount, 'datetime' => date('Y-m-d H:i:s'), 'status' => 'wait'];
        $order = Order::create($data);


        $order->goods()->attach($request->input('id'), ['cnt' => 1, 'price' => $good->price]);

        return response()->json(['result' => 'OK']);
    }
}
