<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            // $mapStatus = [
            //     'Add' => 'date_add',
            //     'Confirmed' => 'date_confirmed',
            //     'In status' => 'date_in_status',
            // ];
            // $statusName = $req->status;
            // $orders = order::leftJoin('status', function ($join) use ($statusName) {
            //     $join->on('orders.order_id', '=', 'status.order_id')
            //         ->where('status.name', '=', $statusName)
            //         ->whereRaw('status.id = (SELECT id FROM status WHERE order_id = orders.order_id ORDER BY created_at DESC LIMIT 1)');
            // })
            //     ->select('orders.*', 'status.*')->orderBy('status.created_at', 'asc')->paginate(10);
            $fromTimestamp = Carbon::createFromTimestamp($req->startDate / 1000);
            $fromDate = $fromTimestamp->format('Y-m-d H:i:s');
            $toTimestamp = Carbon::createFromTimestamp($req->endDate / 1000);
            $toDate = $toTimestamp->format('Y-m-d H:i:s');
            $orders = order::select('orders.*', 'status.*')
                ->leftJoin('status', function ($join) {
                    $join->on('status.order_id', '=', 'orders.order_id');
                })->where('status.name', '=', $req->status)->where('status.created_at', ">", $fromDate)->where('status.created_at', "<", $toDate)
                ->orderBy('status.created_at')
                ->paginate(10);
            return response()->json($orders);
        }
        // $orders = order::leftJoin('status', function ($join) {
        //     $join->on('orders.order_id', '=', 'status.order_id')
        //         ->whereRaw('status.id = (SELECT id FROM status WHERE order_id = orders.order_id ORDER BY created_at DESC LIMIT 1)');
        // })
        //     ->select('orders.*', 'status.*')->orderBy('status.created_at', 'asc')->paginate(10);
        // $orders = DB::select(DB::raw("SELECT DISTINCT * FROM `orders` LEFT JOIN status on orders.order_status_id = status.id ORDER BY status.created_at"));
        // $orders = order::select('*')
        //     ->distinct()
        //     ->leftJoin('status', 'status.order_id', '=', 'orders.order_id')
        //     ->orderBy('status.created_at')
        //     ->paginate(10);

        $orders = order::select('orders.*', 'status.*')
            ->distinct()
            ->leftJoin('status', function ($join) {
                $join->on('status.order_id', '=', 'orders.order_id')
                    ->on('status.created_at', '=', DB::raw('(SELECT MAX(created_at) FROM status WHERE order_id = orders.order_id)'));
            })
            ->orderBy('status.created_at')
            ->paginate(10);
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