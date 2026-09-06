<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductSpecification;
use App\Models\ProductFaq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $brandId = $request->get('brand_id');
        $categoryId = $request->get('category_id');
        $model = $request->get('model');
        $page = $request->get('page', 1);

        $cacheKey = 'products_page_' . md5(serialize([
            'search' => $search,
            'brand_id' => $brandId,
            'category_id' => $categoryId,
            'model' => $model,
            'page' => $page,
        ]));

        $products = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($search, $brandId, $categoryId, $model) {
            return Product::with(['brand', 'category'])
                ->when($search, function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('model', 'like', "%{$search}%")
                          ->orWhere('slug', 'like', "%{$search}%");
                    });
                })
                ->when($brandId, function ($query, $brandId) {
                    return $query->where('brand_id', $brandId);
                })
                ->when($categoryId, function ($query, $categoryId) {
                    return $query->where('category_id', $categoryId);
                })
                ->when($model, function ($query, $model) {
                    return $query->where('model', 'like', "%{$model}%");
                })
                ->latest()
                ->paginate(5);
        });

        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'brands', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string',
            'slug'            => 'required|string|max:500|unique:products,slug',
            'model'           => 'nullable|string|max:255',
            'brand_id'        => 'required|exists:brands,id',
            'category_id'     => 'nullable|exists:categories,id',
            'base_price'      => 'required|numeric|min:0',
            'selling_price'   => 'required|numeric|min:0',
            'quotation_price' => 'required|numeric|min:0',
            'description'     => 'nullable|string',
            'specs'           => 'nullable|array',
            'specs.*.label'   => 'required_with:specs.*.value|string|max:255',
            'specs.*.value'   => 'nullable|string|max:255',
            'faqs'            => 'nullable|array',
            'faqs.*.question' => 'required_with:faqs.*.answer|string|max:500',
            'faqs.*.answer'   => 'nullable|string',
        ]);

        $product = Product::create($validated);

        // Save specifications
        if (!empty($validated['specs'])) {
            foreach ($validated['specs'] as $index => $spec) {
                if (!empty($spec['label'])) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'label'      => $spec['label'],
                        'value'      => $spec['value'] ?? '',
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        // Save FAQs
        if (!empty($validated['faqs'])) {
            foreach ($validated['faqs'] as $index => $faq) {
                if (!empty($faq['question'])) {
                    ProductFaq::create([
                        'product_id' => $product->id,
                        'question'   => $faq['question'],
                        'answer'     => $faq['answer'] ?? '',
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        Cache::flush();

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return redirect()->route('products.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $brands     = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $product->load('specifications', 'faqs');

        return view('products.edit', compact('product', 'brands', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'            => 'required|string',
            'slug'            => 'required|string|max:500|unique:products,slug,' . $product->id,
            'model'           => 'nullable|string|max:255',
            'brand_id'        => 'required|exists:brands,id',
            'category_id'     => 'nullable|exists:categories,id',
            'base_price'      => 'required|numeric|min:0',
            'selling_price'   => 'required|numeric|min:0',
            'quotation_price' => 'required|numeric|min:0',
            'description'     => 'nullable|string',
            'specs'           => 'nullable|array',
            'specs.*.label'   => 'required_with:specs.*.value|string|max:255',
            'specs.*.value'   => 'nullable|string|max:255',
            'faqs'            => 'nullable|array',
            'faqs.*.question' => 'required_with:faqs.*.answer|string|max:500',
            'faqs.*.answer'   => 'nullable|string',
        ]);

        $product->update($validated);

        // Replace all specs: delete old, insert fresh
        $product->specifications()->delete();
        if (!empty($validated['specs'])) {
            foreach ($validated['specs'] as $index => $spec) {
                if (!empty($spec['label'])) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'label'      => $spec['label'],
                        'value'      => $spec['value'] ?? '',
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        // Replace all FAQs: delete old, insert fresh
        $product->faqs()->delete();
        if (!empty($validated['faqs'])) {
            foreach ($validated['faqs'] as $index => $faq) {
                if (!empty($faq['question'])) {
                    ProductFaq::create([
                        'product_id' => $product->id,
                        'question'   => $faq['question'],
                        'answer'     => $faq['answer'] ?? '',
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        Cache::flush();

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        Cache::flush();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
