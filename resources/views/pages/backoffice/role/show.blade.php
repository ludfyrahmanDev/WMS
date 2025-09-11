@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">{{ $title }}</h2>
        <div class="ml-auto flex space-x-3">
            <a href="{{ route('role.edit', $role->id) }}">
                <x-base.button variant="primary">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="Edit" />
                    Edit Role
                </x-base.button>
            </a>
            <a href="{{ route('role.index') }}">
                <x-base.button variant="outline-secondary">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="ArrowLeft" />
                    Back to Roles
                </x-base.button>
            </a>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <!-- BEGIN: Role Information -->
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="box p-5 mb-6">
                <div class="border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="text-base font-medium">Role Information</div>
                </div>

                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 sm:col-span-6">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Role Name</label>
                            <div class="text-lg font-semibold text-slate-800 dark:text-slate-200">
                                {{ $role->display_name }}
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">System Name</label>
                            <div class="text-slate-700 dark:text-slate-300 font-mono bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded">
                                {{ $role->name }}
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Status</label>
                            @if($role->is_active)
                                <span class="inline-flex items-center rounded-full bg-success/20 px-3 py-1 text-sm font-medium text-success">
                                    <x-base.lucide class="mr-1 h-4 w-4" icon="CheckCircle" />
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-danger/20 px-3 py-1 text-sm font-medium text-danger">
                                    <x-base.lucide class="mr-1 h-4 w-4" icon="XCircle" />
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Created Date</label>
                            <div class="text-slate-700 dark:text-slate-300">
                                {{ $role->created_at->format('M d, Y • H:i') }}
                            </div>
                        </div>
                    </div>

                    @if($role->description)
                        <div class="col-span-12">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Description</label>
                                <div class="text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800 p-3 rounded-lg">
                                    {{ $role->description }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- BEGIN: Permissions -->
            <div class="box p-5">
                <div class="border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-base font-medium">Permissions</div>
                            <div class="text-slate-500 text-sm mt-1">
                                {{ $role->permissions->count() }} permissions assigned to this role
                            </div>
                        </div>
                    </div>
                </div>

                @if($role->permissions->count() > 0)
                    <div class="space-y-6">
                        @foreach($role->permissions->groupBy('group') as $groupName => $groupPermissions)
                            <div class="permission-group">
                                <div class="flex items-center mb-3">
                                    <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="Shield" />
                                    <h3 class="text-base font-medium text-slate-700 dark:text-slate-300">
                                        {{ $groupName }}
                                    </h3>
                                    <span class="ml-2 rounded-full bg-primary/20 px-2 py-1 text-xs font-medium text-primary">
                                        {{ $groupPermissions->count() }} permissions
                                    </span>
                                </div>

                                <div class="ml-7 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach($groupPermissions as $permission)
                                        <div class="flex items-center p-3 rounded-lg bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                                            <x-base.lucide class="mr-2 h-4 w-4 text-success" icon="Check" />
                                            <div>
                                                <div class="text-sm font-medium text-slate-800 dark:text-slate-200">
                                                    {{ $permission->display_name }}
                                                </div>
                                                @if($permission->description)
                                                    <div class="text-xs text-slate-500 mt-1">
                                                        {{ $permission->description }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <x-base.lucide class="h-16 w-16 text-slate-400 mx-auto mb-4" icon="Shield" />
                        <div class="text-slate-500 text-lg font-medium">No permissions assigned</div>
                        <div class="text-slate-400 text-sm mt-1">This role has no permissions assigned yet</div>
                        <a href="{{ route('role.edit', $role->id) }}" class="mt-4 inline-block">
                            <x-base.button variant="primary" size="sm">
                                Assign Permissions
                            </x-base.button>
                        </a>
                    </div>
                @endif
            </div>
            <!-- END: Permissions -->
        </div>

        <!-- BEGIN: Role Statistics -->
        <div class="intro-y col-span-12 lg:col-span-4">
            <div class="box p-5 mb-6">
                <div class="border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="text-base font-medium">Statistics</div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg mr-3">
                                <x-base.lucide class="h-5 w-5 text-blue-600 dark:text-blue-400" icon="Shield" />
                            </div>
                            <div>
                                <div class="text-sm font-medium text-slate-800 dark:text-slate-200">Permissions</div>
                                <div class="text-xs text-slate-500">Total assigned</div>
                            </div>
                        </div>
                        <div class="text-xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $role->permissions->count() }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-lg bg-green-50 dark:bg-green-900/20">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 dark:bg-green-900/50 rounded-lg mr-3">
                                <x-base.lucide class="h-5 w-5 text-green-600 dark:text-green-400" icon="Users" />
                            </div>
                            <div>
                                <div class="text-sm font-medium text-slate-800 dark:text-slate-200">Users</div>
                                <div class="text-xs text-slate-500">With this role</div>
                            </div>
                        </div>
                        <div class="text-xl font-bold text-green-600 dark:text-green-400">
                            {{ $role->users->count() }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-lg bg-purple-50 dark:bg-purple-900/20">
                        <div class="flex items-center">
                            <div class="p-2 bg-purple-100 dark:bg-purple-900/50 rounded-lg mr-3">
                                <x-base.lucide class="h-5 w-5 text-purple-600 dark:text-purple-400" icon="Layers" />
                            </div>
                            <div>
                                <div class="text-sm font-medium text-slate-800 dark:text-slate-200">Groups</div>
                                <div class="text-xs text-slate-500">Permission groups</div>
                            </div>
                        </div>
                        <div class="text-xl font-bold text-purple-600 dark:text-purple-400">
                            {{ $role->permissions->groupBy('group')->count() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- BEGIN: Users with this Role -->
            @if($role->users->count() > 0)
                <div class="box p-5">
                    <div class="border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                        <div class="text-base font-medium">Users with this Role</div>
                        <div class="text-slate-500 text-sm mt-1">{{ $role->users->count() }} users assigned</div>
                    </div>

                    <div class="space-y-3">
                        @foreach($role->users->take(5) as $user)
                            <div class="flex items-center p-3 rounded-lg bg-slate-50 dark:bg-slate-800">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-medium text-sm mr-3">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-slate-800 dark:text-slate-200">
                                        {{ $user->name }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        {{ $user->email }}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if($role->users->count() > 5)
                            <div class="text-center pt-3">
                                <div class="text-sm text-slate-500">
                                    And {{ $role->users->count() - 5 }} more users...
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <!-- END: Users with this Role -->
        </div>
    </div>
@endsection
