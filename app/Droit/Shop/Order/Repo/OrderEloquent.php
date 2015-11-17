<?php namespace App\Droit\Shop\Order\Repo;

use App\Droit\Shop\Order\Repo\OrderInterface;
use App\Droit\Shop\Order\Entities\Order as M;

class OrderEloquent implements OrderInterface{

    protected $order;

    public function __construct(M $order)
    {
        $this->order = $order;
    }

    public function getPeriod($start,$end,$status = null)
    {
        if($status)
        {
            return $this->order->whereBetween('created_at', [$start, $end])->where('status','=',$status)->get();
        }

        return $this->order->whereBetween('created_at', [$start, $end])->get();
    }

    public function lastYear()
    {
        $order = $this->order->orderBy('created_at', 'desc')->take(1)->get();

        if(!$order->isEmpty())
        {
            return $order->first()->created_at->format('Y');
        }

        return false;
    }

    public function maxOrder($year)
    {
        $order = $this->order->where('order_no','LIKE', $year.'-%')->orderBy('order_no', 'desc')->take(1)->get();

        if(!$order->isEmpty())
        {
            return $order->first();
        }

        return false;
    }

    public function find($id){

        return $this->order->with(['products','user','coupon','shipping'])->find($id);
    }

    public function create(array $data){

        $order = $this->order->create(array(
            'user_id'     => ($data['user_id'] ? $data['user_id'] : null),
            'adresse_id'  => ($data['adresse_id'] ? $data['adresse_id'] : null),
            'coupon_id'   => $data['coupon_id'],
            'shipping_id' => $data['shipping_id'],
            'payement_id' => $data['payement_id'],
            'amount'      => $data['amount'],
            'order_no'    => $data['order_no']
        ));

        if( ! $order )
        {
            return false;
        }

        if(!empty($data['products']))
        {
            // All products for order
            $order->products()->attach($data['products_id']);
        }

        return $order;
    }

    public function update(array $data){

        $order = $this->order->findOrFail($data['id']);

        if( ! $order )
        {
            return false;
        }

        $order->fill($data);

        $order->save();

        return $order;
    }

    public function delete($id){

        $order = $this->order->find($id);

        return $order->delete();
    }

}
