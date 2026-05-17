<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    private const IMPORT_COLUMNS = [
        'name',
        'short_description',
        'description',
        'category_id',
        'price',
        'sale_price',
        'stock_quantity',
        'brand',
        'color',
        'dimension',
        'model',
        'warranty_period',
        'return_policy',
        'status',
        'featured',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->orderBy('sort_order')->orderBy('id')->paginate(10);
        $categories = Category::orderBy('name')->get(['id', 'name']);
        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'status' => 'boolean',
            'featured' => 'boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['sku'] = 'PRD-' . strtoupper(Str::random(8));
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['featured'] = $request->has('featured') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $galleryImage) {
                $galleryPaths[] = $galleryImage->store('products/gallery', 'public');
            }
            $data['gallery'] = $galleryPaths;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'dimension' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'warranty_period' => 'nullable|string|max:255',
            'return_policy' => 'nullable|string',
            'status' => 'boolean',
            'featured' => 'boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['featured'] = $request->has('featured') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle gallery images - add new ones to existing gallery
        if ($request->hasFile('gallery_images')) {
            $existingGallery = $product->gallery ?? [];
            $galleryPaths = is_array($existingGallery) ? $existingGallery : [];
            
            foreach ($request->file('gallery_images') as $galleryImage) {
                $galleryPaths[] = $galleryImage->store('products/gallery', 'public');
            }
            $data['gallery'] = $galleryPaths;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Update the sort order of products.
     */
    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($request->products as $productData) {
            Product::where('id', $productData['id'])
                ->update(['sort_order' => $productData['sort_order']]);
        }

        return response()->json(['success' => true, 'message' => 'Sort order updated successfully']);
    }

    /**
     * Download sample import file (CSV — opens in Excel).
     */
    public function downloadImportTemplate()
    {
        $categories = Category::orderBy('name')->get(['id', 'name']);
        $sampleCategoryId = $categories->first()?->id ?? 1;

        $sampleRows = [
            [
                'Wireless Bluetooth Headphones',
                'Premium over-ear headphones with noise cancellation',
                'High-quality wireless headphones with 30-hour battery life and comfortable padding.',
                $sampleCategoryId,
                '79.99',
                '59.99',
                '50',
                'Sony',
                'Black',
                '7.3 x 3.0 x 9.9 inches',
                'WH-1000XM5',
                '1 Year',
                '30-day return policy with original packaging',
                '1',
                '0',
            ],
            [
                'Smart Watch Pro',
                'Fitness tracking smartwatch with heart rate monitor',
                'Water-resistant smartwatch with GPS, sleep tracking, and 7-day battery.',
                $sampleCategoryId,
                '199.00',
                '',
                '25',
                'Apple',
                'Silver',
                '1.7 x 0.4 inches',
                'Watch Series 9',
                '2 Years',
                '14-day return for unopened items',
                '1',
                '1',
            ],
        ];

        return response()->streamDownload(function () use ($categories, $sampleRows) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['AVAILABLE CATEGORIES - use category_id from this list']);
            fputcsv($handle, ['category_id', 'category_name']);
            foreach ($categories as $category) {
                fputcsv($handle, [$category->id, $category->name]);
            }
            fputcsv($handle, []);
            fputcsv($handle, ['PRODUCT DATA - fill rows below (do not change the header row)']);
            fputcsv($handle, self::IMPORT_COLUMNS);
            foreach ($sampleRows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, 'products_import_template.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Export all products to CSV (opens in Excel).
     */
    public function export(): StreamedResponse
    {
        $products = Product::with('category')->orderBy('sort_order')->orderBy('id')->get();

        $rows = $products->map(function (Product $product) {
            return [
                $product->name,
                $product->short_description,
                $product->description,
                $product->category_id,
                $product->price,
                $product->sale_price,
                $product->stock_quantity,
                $product->brand,
                $product->color,
                $product->dimension,
                $product->model,
                $product->warranty_period,
                $product->return_policy,
                $product->status ? '1' : '0',
                $product->featured ? '1' : '0',
            ];
        })->all();

        return $this->streamCsv('products_export_' . now()->format('Y-m-d') . '.csv', self::IMPORT_COLUMNS, $rows);
    }

    /**
     * Import products from CSV / Excel-saved CSV.
     */
    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $handle = fopen($request->file('import_file')->getRealPath(), 'r');
        if ($handle === false) {
            return back()->with('error', 'Could not read the uploaded file.');
        }

        $header = null;
        $columnIndex = null;
        $rowNumber = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;
            if ($this->isEmptyCsvRow($row)) {
                continue;
            }

            $normalized = $this->normalizeCsvHeader($row);
            if (in_array('name', $normalized, true)) {
                $header = $normalized;
                if (!in_array('category_id', $header, true) && in_array('category', $header, true)) {
                    $header[array_search('category', $header, true)] = 'category_id';
                }
                $missing = array_diff(self::IMPORT_COLUMNS, $header);
                if (!empty($missing)) {
                    fclose($handle);
                    return back()->with('error', 'Invalid file format. Missing columns: ' . implode(', ', $missing) . '. Please download the sample template.');
                }
                $columnIndex = array_flip($header);
                break;
            }
        }

        if ($header === null || $columnIndex === null) {
            fclose($handle);
            return back()->with('error', 'Could not find product header row. Please download the sample template and keep the header row unchanged.');
        }

        $imported = 0;
        $errors = [];

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;
            if ($this->isEmptyCsvRow($row)) {
                continue;
            }

            $data = [];
            foreach (self::IMPORT_COLUMNS as $column) {
                $data[$column] = trim($row[$columnIndex[$column]] ?? '');
            }

            if ($this->isCategoryReferenceRow($data)) {
                continue;
            }

            $category = null;
            if ($data['category_id'] !== '' && is_numeric($data['category_id'])) {
                $category = Category::find((int) $data['category_id']);
            } elseif ($data['category_id'] !== '') {
                $category = Category::where('name', $data['category_id'])->first();
            }
            if (!$category) {
                $errors[] = "Row {$rowNumber}: Invalid category_id \"{$data['category_id']}\". Choose an ID from the categories list in the template.";
                continue;
            }

            if ($data['name'] === '') {
                $errors[] = "Row {$rowNumber}: Product name is required.";
                continue;
            }

            if ($data['price'] === '' || !is_numeric($data['price']) || (float) $data['price'] < 0) {
                $errors[] = "Row {$rowNumber}: Valid price is required.";
                continue;
            }

            if ($data['stock_quantity'] === '' || !is_numeric($data['stock_quantity']) || (int) $data['stock_quantity'] < 0) {
                $errors[] = "Row {$rowNumber}: Valid stock quantity is required.";
                continue;
            }

            $salePrice = $data['sale_price'] !== '' ? (float) $data['sale_price'] : null;
            $price = (float) $data['price'];
            if ($salePrice !== null && $salePrice >= $price) {
                $errors[] = "Row {$rowNumber}: Sale price must be less than regular price.";
                continue;
            }

            Product::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'short_description' => $data['short_description'] ?: null,
                'description' => $data['description'] ?: null,
                'category_id' => $category->id,
                'price' => $price,
                'sale_price' => $salePrice,
                'stock_quantity' => (int) $data['stock_quantity'],
                'brand' => $data['brand'] ?: null,
                'model' => $data['model'] ?: null,
                'color' => $data['color'] ?: null,
                'dimension' => $data['dimension'] ?: null,
                'warranty_period' => $data['warranty_period'] ?: null,
                'return_policy' => $data['return_policy'] ?: null,
                'status' => $this->parseBooleanColumn($data['status'], true),
                'featured' => $this->parseBooleanColumn($data['featured'], false),
            ]);

            $imported++;
        }

        fclose($handle);

        if ($imported === 0 && !empty($errors)) {
            return back()->with('error', 'Import failed. ' . implode(' ', array_slice($errors, 0, 5)));
        }

        $message = "{$imported} product(s) imported successfully.";
        if (!empty($errors)) {
            $message .= ' Some rows were skipped: ' . implode(' ', array_slice($errors, 0, 3));
            if (count($errors) > 3) {
                $message .= ' (and ' . (count($errors) - 3) . ' more)';
            }
        }

        return redirect()->route('admin.products.index')->with('success', $message);
    }

    private function streamCsv(string $filename, array $headers, array $rows): StreamedResponse
    {
        return response()->streamDownload(function () use ($headers, $rows) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, $headers);
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function isEmptyCsvRow(array $row): bool
    {
        foreach ($row as $value) {
            if (trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }

    private function parseBooleanColumn(string $value, bool $default): bool
    {
        if ($value === '') {
            return $default;
        }

        return in_array(strtolower($value), ['1', 'yes', 'true', 'active'], true);
    }

    private function normalizeCsvHeader(array $header): array
    {
        return array_map(function ($column) {
            $column = (string) $column;
            $column = preg_replace('/^\xEF\xBB\xBF/', '', $column);
            $column = preg_replace('/^\x{FEFF}/u', '', $column);

            return strtolower(trim($column));
        }, $header);
    }

    private function isCategoryReferenceRow(array $data): bool
    {
        return $data['name'] === 'category_id'
            || str_starts_with(strtolower($data['name']), 'available categories')
            || str_starts_with(strtolower($data['name']), 'product data');
    }
}
