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
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()->withCount('cars')->get();

        $viewData = [];
        $viewData['title'] = __('category.title_index');
        $viewData['categories'] = $categories;

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

        $category = new Category;
        $category->setModel((string) $validatedData['model']);
        $category->setBrand((string) $validatedData['brand']);
        $category->setType((string) $validatedData['type']);
        $category->setPassengerCapacity((int) $validatedData['passenger_capacity']);
        $category->setLuggageCapacity((int) $validatedData['luggage_capacity']);
        $category->save();

        return redirect()->route('admin.category.index')->with('success', __('category.created_success'));
    }

    public function edit(int $id): View
    {
        $category = Category::query()->findOrFail($id);

        $viewData = [];
        $viewData['title'] = __('category.title_edit');
        $viewData['category'] = $category;

        return view('admin.category.edit')->with('viewData', $viewData);
    }

    public function update(UpdateCategoryRequest $request, int $id): RedirectResponse
    {
        $category = Category::query()->findOrFail($id);
        $validatedData = $request->validated();

        $category->setModel((string) $validatedData['model']);
        $category->setBrand((string) $validatedData['brand']);
        $category->setType((string) $validatedData['type']);
        $category->setPassengerCapacity((int) $validatedData['passenger_capacity']);
        $category->setLuggageCapacity((int) $validatedData['luggage_capacity']);
        $category->save();

        return redirect()->route('admin.category.index')->with('success', __('category.updated_success'));
    }

    public function delete(int $id): RedirectResponse
    {
        $category = Category::query()->withCount('cars')->findOrFail($id);

        if ($category->getCarsCount() > 0) {
            return back()->with('error', __('category.delete_error_has_cars', ['count' => $category->getCarsCount()]));
        }

        $category->delete();

        return redirect()->route('admin.category.index')->with('success', __('category.deleted_success'));
    }
}
