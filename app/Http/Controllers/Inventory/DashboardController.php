<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\InventoryTransaction;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();
        $chartStart = now()->startOfMonth()->subMonths(5);

        $monthlyTransactions = InventoryTransaction::query()
            ->whereIn('type', [InventoryTransaction::TYPE_IMPORT, InventoryTransaction::TYPE_EXPORT])
            ->whereBetween('transaction_date', [$chartStart, $monthEnd])
            ->get(['type', 'transaction_date'])
            ->groupBy(fn (InventoryTransaction $transaction) => $transaction->transaction_date->format('Y-m'));

        $chart = collect(range(0, 5))->map(function (int $offset) use ($chartStart, $monthlyTransactions) {
            $month = $chartStart->copy()->addMonths($offset);
            $transactions = $monthlyTransactions->get($month->format('Y-m'), collect());

            return [
                'label' => $month->format('m/Y'),
                'imports' => $transactions->where('type', InventoryTransaction::TYPE_IMPORT)->count(),
                'exports' => $transactions->where('type', InventoryTransaction::TYPE_EXPORT)->count(),
            ];
        });

        return view('inventory.dashboard', [
            'totalProducts' => Product::count(),
            'totalStockQuantity' => Product::sum('stock_quantity'),
            'lowStockCount' => Product::whereColumn('stock_quantity', '<=', 'min_stock_alert')->count(),
            'monthlyImportCount' => InventoryTransaction::where('type', InventoryTransaction::TYPE_IMPORT)
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->count(),
            'monthlyExportCount' => InventoryTransaction::where('type', InventoryTransaction::TYPE_EXPORT)
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->count(),
            'chart' => $chart,
            'lowStockProducts' => Product::with('category')
                ->whereColumn('stock_quantity', '<=', 'min_stock_alert')
                ->orderBy('stock_quantity')
                ->limit(8)
                ->get(),
            'recentTransactions' => InventoryTransaction::with('user')
                ->latest('transaction_date')
                ->limit(8)
                ->get(),
        ]);
    }
}
