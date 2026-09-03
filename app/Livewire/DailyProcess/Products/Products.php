<?php

namespace App\Livewire\DailyProcess\Products;

use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Product;
use App\Models\ActivityLog;

class Products extends Component
{

    use WithPagination;
    public $search = '', $search_category = '';
      protected $listeners = ['eliminarRegistro' => 'destroy'];
    //variables de producto
    public $descripcion, $stock, $fecha_vencimiento, $precio_compra, $precio_venta_unidad, $precio_venta_mayor,
        $category_id, $codigo, $selected_id, $carga, $profit_percent, $total_amount_inventary;

    //variable de categoria
    public $name;
 public function render()
{
    $categories = Category::where('name', 'like', '%' . $this->search_category . '%')->get();

    $products = Product::with('category')
        ->whereRelation('category', 'name', 'like', '%' . $this->search . '%')
        ->orWhere('descripcion', 'like', '%' . $this->search . '%')
        ->orWhere('codigo', 'like', '%' . $this->search . '%')
        ->paginate(10);

    $products_in_stock = Product::where('stock', '>=', '1')->count();
    $products_no_stock = Product::where('stock', '=', '0')->count();
    $total_stock = $products_in_stock + $products_no_stock;

    // Guardamos en la propiedad pública
    $total = Product::selectRaw('SUM(precio_venta_unidad * stock) as total')->value('total') ?? 0;
    $this->total_amount_inventary = number_format($total, 2, '.', ',');

    return view('livewire.daily-process.products.products', compact(
        'categories',
        'products',
        'products_in_stock',
        'products_no_stock',
        'total_stock'
    ));
}

    public function refresh()
    {
        return redirect('/private/products');
    }

    //Valida si el código está vacío
    public function validateCod()
    {
        //Si está vacío genera uno aleatorio de la A -Z de 0 -9
       if (empty($this->codigo)) { $this->codigo = $this->generateUniqueCode(); }
    }

    private function generateUniqueCode()
     {
        do { $code = chr(mt_rand(65, 90)) . mt_rand(10000000, 99999999); } while (Product::where('codigo', $code)->exists()); return $code;
     }

    public function store()
    {
        $this->validate([
            'descripcion' => 'required|string',
            'stock' => 'required|numeric',
            'fecha_vencimiento' => 'nullable|date',
            'precio_compra' => 'required|numeric',
            'precio_venta_unidad' => 'required|numeric',
            'precio_venta_mayor' => 'required|numeric',
            'codigo' => 'nullable|string|unique:products,codigo,except,id',
            'category_id' => 'required'

        ]);


        $this->validateCod();
        $newProduct = new Product();
        $newProduct->descripcion = ucfirst(strtolower($this->descripcion));
        $newProduct->stock = $this->stock;
        $newProduct->fecha_vencimiento = $this->fecha_vencimiento;
        $newProduct->precio_compra = $this->precio_compra;
        $newProduct->precio_venta_unidad = $this->precio_venta_unidad;
        $newProduct->precio_venta_mayor = $this->precio_venta_mayor;
        $newProduct->codigo = $this->codigo;
        $newProduct->category_id = $this->category_id;
        $newProduct->codigo = $this->codigo;
        $newProduct->save();

        $newActivitie = new ActivityLog();
        $newActivitie->user_id = auth()->user()->id;
        $newActivitie->activity = "Nuevo Registro - Producto";
        $newActivitie->detail = $newProduct->descripcion;
        $newActivitie->save();

        Alert::success('Producto', 'Producto registrado exitosamente');
        $this->refresh();
    }

    public function edit($id)
    {
        $record = Product::findOrFail($id);
        $this->selected_id = $id;
        $this->descripcion = $record->descripcion;
        $this->precio_compra = $record->precio_compra;
        $this->precio_venta_unidad = $record->precio_venta_unidad;
        $this->precio_venta_mayor = $record->precio_venta_mayor;
        $this->stock = $record->stock;
        $this->fecha_vencimiento = $record->fecha_vencimiento;
        $this->category_id = $record->category_id;
        $this->codigo = $record->codigo;
        $this->profit_percent = $record->precio_venta_unidad - $record->precio_compra;
    }

    public function update()
    {
        $validate =  $this->validate([
            'descripcion' => 'required|string',
            'stock' => 'required|numeric',
            'fecha_vencimiento' => 'nullable|date',
            'precio_compra' => 'required|numeric',
            'precio_venta_unidad' => 'required|numeric',
            'precio_venta_mayor' => 'required|numeric',
            'codigo' => 'nullable|string',
            'category_id' => 'required'

        ]);

        if ($this->selected_id) {
            $record = Product::findOrFail($this->selected_id);
            $record->update($validate);

            $newActivitie = new ActivityLog();
            $newActivitie->user_id = auth()->user()->id;
            $newActivitie->activity = "Registro Actualizado - producto";
            $newActivitie->detail = $record->descripcion;
            $newActivitie->save();

            Alert::success('Producto', 'Producto actualizado exitosamente');
            $this->refresh();
        }
    }

    public function destroy($id)
    {
        $record = Product::findOrFail($id);
        Product::destroy($id);

        $newActivitie = new ActivityLog();
        $newActivitie->user_id = auth()->user()->id;
        $newActivitie->activity = "Registro Eliminado - Producto";
        $newActivitie->detail = $record->descripcion;
        $newActivitie->save();

        Alert::success('Producto', 'Has eliminado el registro');
        $this->refresh();
    }

    public function store_category()
    {
        $this->validate([
            'name' => 'required|string|unique:categories,name,except,id'
        ]);

        $newCategory = new Category();
        $newCategory->name = ucfirst(strtolower($this->name));
        $newCategory->save();
        Alert::success('Categoria', 'Categoria registrada exitosamente');
        $this->refresh();

        $newActivitie = new ActivityLog();
        $newActivitie->user_id = auth()->user()->id;
        $newActivitie->activity = "Nuevo Registro - Categoria";
        $newActivitie->detail = $newCategory->name;
        $newActivitie->save();
    }

    public function match_prices()
    {
        $this->precio_venta_mayor = $this->precio_venta_unidad;
    }


}
