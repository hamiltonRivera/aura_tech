namespace App\Livewire\DailyProcess\Expenses;

use Livewire\Component;
use App\Models\ActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;
use App\Models\Gasto;

class Expenses extends Component
{
    use WithPagination;
    public $search = '';
    public $descripcion, $fecha, $monto, $tipo_gasto, $selected_id;
    
    // Nueva variable para el filtro
    public $filtro_tipo_gasto = ''; 
    
    protected $listeners = ['eliminarRegistro' => 'destroy'];
    
    public $tipo_gastos = [
        'Reinversión de negocio',
        'Operacionales',
       'Administrativos',
       'Gastos Fijos',
       'Discrecionales',
       'Gastos Variables',
       'Gastos de emergencia',
       'Personales',
       'Financieros',
       'Comerciales',
       'Impuestos',
       'Otros Gastos'
    ];

    public function render()
    {   
        // Cálculos mensuales (sin cambios)
        $enero = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 1)->sum('monto');
        $febrero = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 2)->sum('monto');
        $marzo = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 3)->sum('monto');
        $abril = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 4)->sum('monto');
        $mayo = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 5)->sum('monto');
        $junio = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 6)->sum('monto');
        $julio = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 7)->sum('monto');
        $agosto = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 8)->sum('monto');
        $septiembre = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 9)->sum('monto');
        $octubre = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 10)->sum('monto');
        $noviembre = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 11)->sum('monto');
        $diciembre = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 12)->sum('monto');
        
        // Consulta base para la tabla
        $query = Gasto::orderBy('id', 'asc')
            ->where('descripcion', 'like', '%' . $this->search . '%');
            
        // Si hay un filtro seleccionado, lo aplicamos a la consulta
        if (!empty($this->filtro_tipo_gasto)) {
            $query->where('tipo_gasto', $this->filtro_tipo_gasto);
        }

        // Calculamos el total de los gastos que coinciden con la búsqueda/filtro
        $totalFiltrado = $query->sum('monto');

        // Paginamos el resultado
        $expenses = $query->paginate(10);
        
        return view('livewire.daily-process.expenses.expenses', compact(
            'expenses', 'totalFiltrado', 'enero', 'febrero', 'marzo', 'abril', 
            'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        ));
    }

    // ... (El resto de tus métodos refresh, store, edit, update, destroy se mantienen igual) ...