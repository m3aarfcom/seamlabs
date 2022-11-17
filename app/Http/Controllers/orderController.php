<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\waiter;
use App\Models\order;
use App\Models\menu;
use App\Models\basic_info;
use App\Models\customer;
class orderController extends Controller
{
    public function create_order(Request $request)
    {
        $order_type = $request->type;
        // should system send item id after Resturant Take the order from customer
        // in test we should send id = 1 for testing purpose
        $order_item = $request->item_id;
        $item = new menu;
        $item = $item::find($order_item);
        if($order_type == 'delivery')
        {
            $fees = new basic_info;
            $fees = $fees::where('option','deliver_fees')->first();
            $fees = $fees->value;
            //this is input some date to get customer record from Db
            // i will assume that we need get the customer by his phone
            // in whole system it should be Function to create customer

            $cust = new customer;
            $cust = $cust::where('phone','01114358682')->first();
            // store order in Db

            $new_order = new order;
            // it should store Customer id and make relation between them
            // but i will assume that i just Store the name only
            $new_order->customer = $cust->name;
            $new_order->type = 'delivery';
            // in real system it should have sepreate colum one for
            // Sub total and other for Additonal like tax, service and so on

            $new_order->cost =((float)$item->price + (float)$fees);
            $new_order->save();
            return
            [
                'Customer name'=>$cust->name,
                'customer phone'=>$cust->phone,
                'Delivery Fees'=>$fees,
                'Total' => ($item->price + $fees),
            ];


        }
        elseif($order_type == 'dine_in')
        {
            // assume table number is 5
            // and the waiter id is 1 because this is the only one in DB records
            $service_charge = new basic_info;
            $service_charge = $service_charge::where('option','service_charge')->first();
            $service_charge = $service_charge->value;

            // get waiter name by id 1

            $waiter = new waiter;
            $waiter = $waiter::find(1);
            $waiter = $waiter->name;

            $new_order = new order;
            // in Dine-in type we will not store customer name just Dine_cust ref
            $new_order->customer = "Dine_in_customer";
            $new_order->type = 'dine_in';
            // in real system it should have sepreate colum one for
            // Sub total and other for Additonal like tax, service and so on
            $new_order->cost = (float) ($item->price + $service_charge);
            $new_order->save();

            return
            [
                'service_charge'=>$service_charge,
                'waiter_name'=> $waiter,
                'Total' => ($item->price + $service_charge),
            ];
        }
        else
        {
            // For TakeAway order
            $new_order = new order;
            // in Dine-in type we will not store customer name just Dine_cust ref
            $new_order->customer = "takeAway_customer";
            $new_order->type = 'takeaway';
            // in real system it should have sepreate colum one for
            // Sub total and other for Additonal like tax, service and so on
            $new_order->cost = (float)$item->price;
            $new_order->save();

            return
            [
                'Total' => ($item->price),
            ];
        }

    }
}
