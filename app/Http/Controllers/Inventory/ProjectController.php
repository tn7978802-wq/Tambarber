<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\ProjectRequest;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('inventory.projects.index', [
            'projects' => Project::withCount('inventoryTransactions')->orderBy('name')->paginate(20),
        ]);
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        Project::create($request->validated());

        return back()->with('success', 'Đã thêm dự án/chi nhánh.');
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->validated());

        return back()->with('success', 'Đã cập nhật dự án/chi nhánh.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return back()->with('success', 'Đã xóa dự án. Các phiếu cũ vẫn được giữ lại.');
    }
}
