<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;

class ordersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if ($req->status && $req->startDate && $req->endDate) {
            $mapStatus = [
                'Add' => 'date_add',
                'Confirmed' => 'date_confirmed',
                'In status' => 'date_in_status',
            ];
            $orders = order::leftJoin('status', function ($join) {
                $join->on('orders.order_id', '=', 'status.order_id')
                    ->whereRaw('status.id = (SELECT id FROM status WHERE order_id = orders.order_id ORDER BY id LIMIT 1)');
            })
                ->where($mapStatus[$req->status], ">", $req->startDate)->where($mapStatus[$req->status], "<", $req->endDate)->select('orders.*', 'status.*')->orderBy('status.created_at')->paginate(10);
            return response()->json($orders);
        }
        $orders = order::leftJoin('status', function ($join) {
            $join->on('orders.order_id', '=', 'status.order_id')
                ->whereRaw('status.id = (SELECT id FROM status WHERE order_id = orders.order_id ORDER BY id LIMIT 1)');
        })
            ->select('orders.*', 'status.*')->orderBy('status.created_at')->paginate(10);
        return response()->json($orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}