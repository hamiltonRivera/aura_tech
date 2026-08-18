<div class="mr-5 mb-3">
    <div class="lg:grid grid-cols-2 sm:grid-col-1">
       <div>
         <div class="mt-3 ml-4">
            @include('livewire.admin.categories.form')
         </div>
       </div>

       <div>
        @include('livewire.admin.categories.search')
        @include('livewire.admin.categories.table')
       </div>
    </div>
</div>

