<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class StockTransferController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:view stock_transfer', only: ['index']),
            new Middleware('admin.permission:create stock_transfer', only: ['create']),
            new Middleware('admin.permission:edit stock_transfer', only: ['edit']),
            new Middleware('admin.permission:delete stock_transfer', only: ['destroy']),
        ];
    }
    public function index(){
        return view('admin.stock_transfer.index');
    }
}