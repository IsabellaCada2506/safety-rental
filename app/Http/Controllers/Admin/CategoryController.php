<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-10
 * Description: Admin controller for managing car categories.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Services\Contracts\CategoryServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    private readonly CategoryServiceInterface $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('category.title_index');
        $viewData['categories'] = $this->categoryService->getAllWithCarsCount();

        return view('admin.category.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('category.title_create');

        return view('admin.category.create')->with('viewData', $viewData);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $this->categoryService->createFromValidated($validatedData);

        return redirect()->route('admin.category.index')->with('success', __('category.created_success'));
    }

    public function edit(int $id): View
    {
        $category = $this->categoryService->findOrFail($id);

        $viewData = [];
        $viewData['title'] = __('category.title_edit');
        $viewData['category'] = $category;

        return view('admin.category.edit')->with('viewData', $viewData);
    }

    public function update(UpdateCategoryRequest $request, int $id): RedirectResponse
    {
        $category = $this->categoryService->findOrFail($id);
        $validatedData = $request->validated();

        $this->categoryService->updateFromValidated($category, $validatedData);

        return redirect()->route('admin.category.index')->with('success', __('category.updated_success'));
    }

    public function delete(int $id): RedirectResponse
    {
        $category = $this->categoryService->findWithCarsCountOrFail($id);

        if (! $this->categoryService->canBeDeleted($category)) {
            return back()->with('error', __('category.delete_error_has_cars', ['count' => $category->getCarsCount()]));
        }

        $this->categoryService->delete($category);

        return redirect()->route('admin.category.index')->with('success', __('category.deleted_success'));
    }
}
