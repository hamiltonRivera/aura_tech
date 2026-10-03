<div class="mega-menu-main-div">

    <div class="mega-menu-div-container-drop-button">

        <button data-collapse-toggle="mega-menu-operations" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mega-menu-operations" aria-expanded="false">

            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>
    </div>
    <div id="mega-menu-operations" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1">
        <ul class="mega-menu-ul">

            <li>
                <button id="mega-menu-operations-dropdown-button" data-dropdown-toggle="mega-menu-operations-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium text-gray-900 border-b border-gray-100 md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">
                    Procesos diarios <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
</svg>
                </button>
                <div id="mega-menu-operations-dropdown" class="absolute z-10 grid hidden w-auto grid-cols-2 text-sm bg-white border border-gray-100 rounded-lg shadow-md dark:border-gray-700 md:grid-cols-3 dark:bg-gray-700">
                    <div class="mega-menu-button-div">
                        <ul class="space-y-4" aria-labelledby="mega-menu-operations-dropdown-button">
                            <li>
                                <a href="{{route('products')}}" class="mega-menu-ul-li-a">
                                    <i class="fa-solid fa-boxes-stacked"></i> Inventario Productos
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('clients') }}" class="mega-menu-ul-li-a">
                                    <i class="fa-solid fa-users"></i> Clientes
                                </a>
                            </li>
                              @can('administrador')
                              <li>
                                <a href="{{route('expenses')}}" class="mega-menu-ul-li-a">
                                    <i class="fa-solid fa-money-bill"></i> Gastos
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('cash_reconciliation') }}" class="mega-menu-ul-li-a">
                                <i class="fa-solid fa-cash-register"></i>Arqueo de Caja
                            </a>
                            </li>    
 
                        </ul>
                    </div>
                    <div class="mega-menu-button-div">
                     <ul class="space-y-4">
                        <li>
                            <a href="{{route('reports')}}" class="mega-menu-ul-li-a">
                                <i class="fa-solid fa-file-pdf"></i>  Reportes
                            </a>
                        </li>
                          @endcan

                        <li>
                            <a href="{{route('exchange_rate')}}" class="mega-menu-ul-li-a">
                                <i class="fa-solid fa-coins"></i>  Tasa de cambio
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('products_most_sold') }}" class="mega-menu-ul-li-a">
                                <i class="fa-solid fa-boxes-stacked"></i>  Productos más vendidos
                            </a>
                        </li>

                     </ul>
                    </div>
                    <div class="mega-menu-button-div">
                     <ul class="space-y-4">
                        <li>
                            <a href="{{ route('salesDone') }}" class="mega-menu-ul-li-a">
                                <i class="fa-solid fa-eye"></i> Ver ventas realizadas totales
                            </a>
                        </li>


                        <li>
                            <a href="{{ route('sales_done_by_month') }}" class="mega-menu-ul-li-a">
                                <i class="fa-solid fa-eye"></i> Ver ventas realizadas X mes
                            </a>
                        </li>

                        {{-- <li>
                            <a href="{{ route('catalog') }}" class="mega-menu-ul-li-a">
                                <i class="fa-solid fa-book-open"></i> Catálogo
                            </a>
                        </li> --}}

                        <li>
                            <a href="{{ route('combos') }}" class="mega-menu-ul-li-a">
                                <i class="fa-solid fa-book-open"></i> Combos
                            </a>
                        </li>

                     </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
