@props(['data' => []])
<div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
    <x-base.pagination class="w-full sm:mr-auto sm:w-auto">
        <x-base.pagination.link>
            <x-base.lucide
                class="h-4 w-4"
                icon="ChevronsLeft"
            />
        </x-base.pagination.link>
        <x-base.pagination.link>
            <x-base.lucide
                class="h-4 w-4"
                icon="ChevronLeft"
            />
        </x-base.pagination.link>
        <x-base.pagination.link>...</x-base.pagination.link>
        <x-base.pagination.link>1</x-base.pagination.link>
        <x-base.pagination.link active>2</x-base.pagination.link>
        <x-base.pagination.link>3</x-base.pagination.link>
        <x-base.pagination.link>...</x-base.pagination.link>
        <x-base.pagination.link>
            <x-base.lucide
                class="h-4 w-4"
                icon="ChevronRight"
            />
        </x-base.pagination.link>
        <x-base.pagination.link>
            <x-base.lucide
                class="h-4 w-4"
                icon="ChevronsRight"
            />
        </x-base.pagination.link>
    </x-base.pagination>
    <x-base.form-select class="!box mt-3 w-20 sm:mt-0">
        <option>10</option>
        <option>25</option>
        <option>35</option>
        <option>50</option>
    </x-base.form-select>
</div>
