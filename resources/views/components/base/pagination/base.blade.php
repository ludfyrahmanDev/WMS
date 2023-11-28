@props(['data' => []])
@php
    $page = $data->toArray();
    $lastPage = $page['last_page'] ?? 1;
    $currentPage = $page['current_page'] ?? 1;
    $previousPage =  ($currentPage > 1) ? $currentPage - 1 : 1;
    $nextPage =  ($currentPage < $lastPage) ? $currentPage + 1 : $lastPage;
    $maxPagesToShow = $lastPage < 7 ? $lastPage : 7;
    $halfPagesToShow = (int)floor($maxPagesToShow / 2);
    // get path pagination
    $startPage = ($currentPage - $halfPagesToShow > 0) ? $currentPage - $halfPagesToShow : 1;
    $endPage = ($currentPage + $halfPagesToShow < $lastPage) ? $currentPage + $halfPagesToShow : $lastPage;
    $range = $endPage - $startPage + 1;
    if ($range < $maxPagesToShow) {
        if ($startPage == 1) {
            $endPage = $maxPagesToShow;
        } else {
            $startPage = $endPage - $maxPagesToShow + 1;
        }
    }
    $startPage = ($startPage < 1) ? 1 : $startPage;
    $pageNumbers = range($startPage, $endPage);
    $perPage = $page['per_page'] ?? 10;
    $search = request()->get('search') ?? '';
@endphp
<div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
    <x-base.pagination class="w-full sm:mr-auto sm:w-auto">
        <x-base.pagination.link  :as="'a'" :href="linkPagination($data->path(), $perPage, $search,1)">
            <x-base.lucide
                class="h-4 w-4"
                icon="ChevronsLeft"
            />
        </x-base.pagination.link>
        <x-base.pagination.link :as="'a'" :href="linkPagination($data->path(), $perPage, $search,$previousPage)">
            <x-base.lucide
                class="h-4 w-4"
                icon="ChevronLeft"
            />
        </x-base.pagination.link>
        @foreach ($pageNumbers as $page)
            <x-base.pagination.link :as="'a'" :active="$page == $currentPage" :href="linkPagination($data->path(), $perPage, $search,$page)">{{$page}}</x-base.pagination.link>
        @endforeach
        <x-base.pagination.link :as="'a'" :href="linkPagination($data->path(), $perPage, $search,$nextPage)">
            <x-base.lucide
                class="h-4 w-4"
                icon="ChevronRight"
            />
        </x-base.pagination.link>
        <x-base.pagination.link :as="'a'" :href="linkPagination($data->path(), $perPage, $search,$lastPage)">
            <x-base.lucide
                class="h-4 w-4"
                icon="ChevronsRight"
            />
        </x-base.pagination.link>
    </x-base.pagination>

    <x-base.form-select class="!box mt-3 w-20 sm:mt-0" id="per_page">
        <option {{$perPage == 10 ? 'selected' : ''}}>10</option>
        <option {{$perPage == 25 ? 'selected' : ''}}>25</option>
        <option {{$perPage == 35 ? 'selected' : ''}}>35</option>
        <option {{$perPage == 50 ? 'selected' : ''}}>50</option>
    </x-base.form-select>
</div>
