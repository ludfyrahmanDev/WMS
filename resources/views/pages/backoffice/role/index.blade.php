@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">{{ $title }}</h2>
    @if (session('success'))
        <x-base.alert class="mb-2 flex items-center" variant="outline-success">
            <x-base.lucide class="mr-2 h-6 w-6" icon="AlertOctagon" />
            {{ session('success') }}
            <x-base.alert.dismiss-button class="btn-close" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif
    @if (session('failed'))
        <x-base.alert class="mb-2 flex items-center" variant="outline-danger">
            <x-base.lucide class="mr-2 h-6 w-6" icon="AlertOctagon" />
            {{ session('failed') }}
            <x-base.alert.dismiss-button class="btn-close" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route($route . '.create') }}">
                <x-base.button class="mr-2 shadow-md" variant="primary">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="Plus" />
                    Add New Role
                </x-base.button>
            </a>
            <x-base.menu class="hidden">
                <x-base.menu.button class="!box px-2" as="x-base.button">
                    <span class="flex h-5 w-5 items-center justify-center">
                        <x-base.lucide class="h-4 w-4" icon="Plus" />
                    </span>
                </x-base.menu.button>
                <x-base.menu.items class="w-40">
                    <x-base.menu.item>
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Printer" /> Print
                    </x-base.menu.item>
                    <x-base.menu.item>
                        <x-base.lucide class="mr-2 h-4 w-4" icon="FileText" /> Export to
                        Excel
                    </x-base.menu.item>
                    <x-base.menu.item>
                        <x-base.lucide class="mr-2 h-4 w-4" icon="FileText" /> Export to
                        PDF
                    </x-base.menu.item>
                </x-base.menu.items>
            </x-base.menu>
            <div class="mx-auto hidden text-slate-500 md:block">
                Showing 1 to {{$data->total() < 10 ? $data->total() : 10}} of {{$data->total()}} entries
            </div>
            <div class="mt-3 w-full sm:mt-0 sm:ml-auto sm:w-auto md:ml-0">
                <div class="relative w-56 text-slate-500">
                    <x-base.form-input class="!box w-56 pr-10" type="text" placeholder="Search..." id="search" value="{{ request()->get('search') }}"/>
                    <x-base.lucide class="absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4" icon="Search" />
                </div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            No
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Role Name
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Description
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Permissions
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Users
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Company Access
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Status
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            ACTIONS
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($data as $item)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td
                                class="w-16 border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <div>
                                    <div class="whitespace-nowrap font-medium text-slate-800 dark:text-slate-200">
                                        {{ $item->display_name }}
                                    </div>
                                    <div class="mt-0.5 whitespace-nowrap text-xs text-slate-500">
                                        {{ $item->name }}
                                    </div>
                                </div>
                            </x-base.table.td>
                            <x-base.table.td
                                class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <div class="text-slate-600 dark:text-slate-400 text-sm">
                                    {{ Str::limit($item->description ?? 'No description', 50) }}
                                </div>
                            </x-base.table.td>
                            <x-base.table.td
                                class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 text-center">
                                <span class="rounded-full bg-blue-100 dark:bg-blue-900/30 px-2 py-1 text-xs font-medium text-blue-800 dark:text-blue-400">
                                    {{ $item->permissions->count() }} permissions
                                </span>
                            </x-base.table.td>
                            <x-base.table.td
                                class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 text-center">
                                <span class="rounded-full bg-green-100 dark:bg-green-900/30 px-2 py-1 text-xs font-medium text-green-800 dark:text-green-400">
                                    {{ $item->users->count() }} users
                                </span>
                            </x-base.table.td>
                            <x-base.table.td
                                class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 text-center">
                                @php
                                    $hasCompanyAccess = $item->permissions->where('name', 'company.access')->count() > 0;
                                    $cvCount = $item->cvs->count();
                                @endphp
                                @if($hasCompanyAccess)
                                    @if($cvCount > 0)
                                        <span class="rounded-full bg-emerald-100 dark:bg-emerald-900/30 px-2 py-1 text-xs font-medium text-emerald-800 dark:text-emerald-400 flex items-center justify-center gap-1">
                                            <x-base.lucide class="h-3 w-3" icon="Building" />
                                            {{ $cvCount }} CV{{ $cvCount > 1 ? 's' : '' }}
                                        </span>
                                    @else
                                        <span class="rounded-full bg-blue-100 dark:bg-blue-900/30 px-2 py-1 text-xs font-medium text-blue-800 dark:text-blue-400 flex items-center justify-center gap-1">
                                            <x-base.lucide class="h-3 w-3" icon="Globe" />
                                            All CVs
                                        </span>
                                    @endif
                                @else
                                    <span class="rounded-full bg-slate-100 dark:bg-slate-900/30 px-2 py-1 text-xs font-medium text-slate-600 dark:text-slate-400 flex items-center justify-center gap-1">
                                        <x-base.lucide class="h-3 w-3" icon="Lock" />
                                        No Access
                                    </span>
                                @endif
                            </x-base.table.td>
                            <x-base.table.td
                                class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 text-center">
                                @if($item->is_active)
                                    <span class="rounded-full bg-success/20 px-2 py-1 text-xs font-medium text-success">
                                        Active
                                    </span>
                                @else
                                    <span class="rounded-full bg-danger/20 px-2 py-1 text-xs font-medium text-danger">
                                        Inactive
                                    </span>
                                @endif
                            </x-base.table.td>
                            <x-base.table.td
                                class="relative w-56 border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                <div class="flex items-center justify-center space-x-2">
                                    <a class="flex items-center text-primary hover:text-primary/80 transition-colors" 
                                       href="{{ route('role.show', $item->id) }}"
                                       title="View Details">
                                        <x-base.lucide class="h-4 w-4" icon="Eye" />
                                    </a>
                                    <a class="flex items-center text-warning hover:text-warning/80 transition-colors" 
                                       href="{{ route('role.edit', $item->id) }}"
                                       title="Edit Role">
                                        <x-base.lucide class="h-4 w-4" icon="Edit" />
                                    </a>
                                    @if(!in_array($item->name, ['super_admin', 'admin']))
                                        <a class="flex items-center text-danger hover:text-danger/80 transition-colors" 
                                           data-tw-toggle="modal"
                                           data-tw-target="#delete-confirmation-modal-{{ $item->id }}" 
                                           href="#"
                                           title="Delete Role">
                                            <x-base.lucide class="h-4 w-4" icon="Trash2" />
                                        </a>
                                    @endif
                                    <x-base.dialog id="delete-confirmation-modal-{{ $item->id }}">
                                        <x-base.dialog.panel>
                                            <div class="p-5 text-center">
                                                <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
                                                <div class="mt-5 text-3xl">Are you sure?</div>
                                                <div class="mt-2 text-slate-500">
                                                    Do you really want to delete these records? <br />
                                                    This process cannot be undone.
                                                </div>
                                            </div>
                                            <div class="px-5 pb-8 text-center flex justify-center">
                                                <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button"
                                                    variant="outline-secondary">
                                                    Cancel
                                                </x-base.button>
                                                <form action="{{ route('role.destroy', $item->id) }}" method="post"
                                                    class="w-24">
                                                    @method('delete')
                                                    @csrf
                                                    <x-base.button class="w-24" type="submit" variant="danger">
                                                        Delete
                                                    </x-base.button>
                                                </form>
                                            </div>
                                        </x-base.dialog.panel>
                                    </x-base.dialog>
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforeach
                </x-base.table.tbody>

                @if ($data->isEmpty())
                    <x-base.table.tbody>
                        <x-base.table.tr>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600" colspan="7">
                                <div class="flex justify-center items-center py-8">
                                    <div class="text-center">
                                        <x-base.lucide
                                            class="h-16 w-16 text-slate-400 mx-auto mb-4"
                                            icon="Shield"
                                        />
                                        <div class="text-slate-500 text-lg font-medium">No roles found</div>
                                        <div class="text-slate-400 text-sm mt-1">Create your first role to get started</div>
                                    </div>
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    </x-base.table.tbody>
                @endif
            </x-base.table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <x-base.pagination.base
        :data="$data"></x-base.pagination.base>
        <!-- END: Pagination -->
    </div>
    <!-- BEGIN: Delete Confirmation Modal -->
    <x-base.dialog id="delete-confirmation-modal">
        <x-base.dialog.panel>
            <div class="p-5 text-center">
                <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
                <div class="mt-5 text-3xl">Are you sure?</div>
                <div class="mt-2 text-slate-500">
                    Do you really want to delete these records? <br />
                    This process cannot be undone.
                </div>
            </div>
            <div class="px-5 pb-8 text-center">
                <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">
                    Cancel
                </x-base.button>
                <x-base.button class="w-24" type="button" variant="danger">
                    Delete
                </x-base.button>
            </div>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Delete Confirmation Modal -->
@endsection
