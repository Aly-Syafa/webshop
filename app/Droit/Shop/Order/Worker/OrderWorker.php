<?php

namespace App\Droit\Shop\Order\Worker;

use App\Droit\Shop\Order\Worker\OrderWorkerInterface;

use App\Droit\Shop\Order\Repo\OrderInterface;
use App\Droit\Shop\Cart\Worker\CartWorkerInterface;
use App\Droit\Shop\Cart\Repo\CartInterface;
use App\Droit\User\Repo\UserInterface;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Droit\Generate\Pdf\PdfGeneratorInterface;

use App\Jobs\CreateOrderInvoice;

class OrderWorker implements OrderWorkerInterface{

    use DispatchesJobs;

    protected $order;
    protected $cart;
    protected $worker;
    protected $user;
    protected $generator;

    public function __construct(OrderInterface $order, CartWorkerInterface $worker, UserInterface $user, CartInterface $cart, PdfGeneratorInterface $generator)
    {
        $this->order     = $order;
        $this->cart      = $cart;
        $this->worker    = $worker;
        $this->user      = $user;
        $this->generator = $generator;
    }

    public function make($shipping,$coupon = null, $admin = null)
    {
        $user = $this->user->find(\Auth::user()->id);

        $commande = [
            'user_id'     => $user->id,
            'order_no'    => $this->newOrderNumber(),
            'amount'      =>  \Cart::total() * 100,
            'coupon_id'   => ($coupon ? $coupon['id'] : null),
            'shipping_id' => $shipping->id,
            'payement_id' => 1,
            'products'    => $this->productIdFromCart()
        ];

        // Order global
        $order = $this->insertOrder($commande);

        // Create invoice for order
        $job = (new CreateOrderInvoice($order));
        $this->dispatch($job);

        return $order;

    }

    public function makeAdmin($commande)
    {
        // TODO Find shipping

        // TODO Find coupon if any

        $commande = [
            'user_id'     => $commande['user_id'],
            'adresse_id'  => (isset($commande['adresse_id']) ? $commande['adresse_id'] : null),
            'order_no'    => $this->newOrderNumber(),
            'amount'      =>  \Cart::total() * 100,
            'coupon_id'   => (isset($commande['coupon_id']) ? $commande['coupon_id'] : null),
            'shipping_id' => $commande['shipping_id'],
            'payement_id' => 1,
            'products'    => $this->productIdFromForm($commande['products'])
        ];

        // Order global
        $order = $this->insertOrder($commande);

        if(isset($commande['tva']))
        {
            $this->generator->setTva($commande['tva']);
        }

        if(isset($commande['free']) && $commande['free'])
        {
            session(['noShipping' => 'noShipping']);
        }

        // Create invoice for order
        $this->generator->factureOrder($order->id);

        return $order;
    }

    public function productIdFromForm($commande)
    {
        $qty = $commande['qty'];

        foreach($commande['products'] as $index => $product)
        {
            if($qty[$index] > 1)
            {
                for($x = 0; $x < $qty[$index]; $x++)
                {
                    $ids[] = $product;
                }
            }
            else
            {
                $ids[] = $product->id;
            }
        }

        return $ids;
    }

    public function insertOrder($commande){

        // Order global
        $order = $this->order->create($commande);

        if(!$order)
        {
            // Save the cart
            $this->saveCart($commande);

            \Log::error('Problème lors de la commande'. serialize($commande));

            throw new \App\Exceptions\OrderCreationException('Problème lors de la commande');
        }

        return $order;
    }

    public function saveCart($commande)
    {
        // Save the cart
        $this->cart->create([
            'user_id'     => $commande['user_id'],
            'cart'        => serialize(\Cart::content()),
            'coupon_id'   => $commande['coupon_id']
        ]);
    }

    public function productIdFromCart()
    {
        foreach(\Cart::content() as $product)
        {
            if($product->qty > 1)
            {
                for($x = 0; $x < $product->qty; $x++)
                {
                    $ids[] = $product->id;
                }
            }
            else
            {
                $ids[] = $product->id;
            }
        }

        return $ids;
    }

    public function newOrderNumber(){

        $lastid = 1;
        $year   = date("Y");
        $last   = $this->order->maxOrder($year);

        if($last)
        {
            list($y, $lastid) = explode('-', $last->order_no);
            $lastid = intval($lastid) + 1;
        }

        // Build order number
        $order_no  = str_pad($lastid, 8, '0', STR_PAD_LEFT);
        $order_no  = $year.'-'.$order_no;

        return $order_no;
    }

}