<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;

class ServiceController extends Controller
{
    /**
     * Bảng dịch vụ: cắt tóc, cạo râu, gội đầu, tạo kiểu, combo...
     */
    public function index(): View
    {
        $services = collect();

        try {
            $services = Service::active()->orderBy('price')->get();
        } catch (QueryException $exception) {
            report($exception);
        }

        return view('services.index', [
            'services' => $services,
        ]);
    }
}