@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">{{ $title }}</h2>
        <a href="{{ route('role.index') }}" class="ml-auto">
            <x-base.button variant="outline-secondary">
                <x-base.lucide class="mr-2 h-4 w-4" icon="ArrowLeft" />
                Back to Roles
            </x-base.button>
        </a>
    </div>

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
        <div class="intro-y col-span-12">
            <form action="{{ $route }}" method="post" onsubmit="debugFormSubmit(event)">
                @csrf
                @if ($type != 'create')
                    @method('PUT')
                @endif

                <!-- BEGIN: Basic Information -->
                <div class="intro-y box p-5 mb-6">
                    <div class="border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                        <div class="text-base font-medium">Basic Information</div>
                        <div class="text-slate-500 text-sm mt-1">Configure the basic role information</div>
                    </div>

                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 sm:col-span-6">
                            <div class="input-form">
                                <x-base.form-label for="display_name">Role Name *</x-base.form-label>
                                <x-base.form-input 
                                    class="w-full" 
                                    id="display_name" 
                                    type="text" 
                                    required 
                                    name="display_name"
                                    value="{{ $data->display_name ?? old('display_name') }}" 
                                    placeholder="Enter role name..." 
                                />
                                @error('display_name')
                                    <div class="pristine-error text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <div class="input-form">
                                <x-base.form-label for="is_active">Status</x-base.form-label>
                                <div class="mt-2">
                                    <x-base.form-switch>
                                        <x-base.form-switch.input 
                                            id="is_active" 
                                            name="is_active" 
                                            type="checkbox"
                                            checked="{{ ($data->is_active ?? true) ? 'checked' : '' }}"
                                        />
                                        <x-base.form-switch.label for="is_active">
                                            Active
                                        </x-base.form-switch.label>
                                    </x-base.form-switch>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-12">
                            <div class="input-form">
                                <x-base.form-label for="description">Description</x-base.form-label>
                                <x-base.form-textarea 
                                    class="w-full" 
                                    id="description" 
                                    name="description"
                                    rows="3"
                                    placeholder="Enter role description..."
                                >{{ $data->description ?? old('description') }}</x-base.form-textarea>
                                @error('description')
                                    <div class="pristine-error text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Basic Information -->

                <!-- BEGIN: Permissions -->
                <div class="intro-y box p-5 mb-6">
                    <div class="border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <div class="text-lg font-semibold text-slate-800 dark:text-slate-200">
                                    <x-base.lucide class="inline mr-2 h-5 w-5 text-primary" icon="Shield" />
                                    Role Permissions
                                </div>
                                <div class="text-slate-500 text-sm mt-1">Grant specific permissions to this role for system access control</div>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <x-base.button type="button" id="select-all" variant="primary" size="sm">
                                    <x-base.lucide class="mr-1 h-4 w-4" icon="CheckSquare" />
                                    Select All
                                </x-base.button>
                                <x-base.button type="button" id="deselect-all" variant="outline-secondary" size="sm">
                                    <x-base.lucide class="mr-1 h-4 w-4" icon="Square" />
                                    Clear All
                                </x-base.button>
                                <x-base.button type="button" id="toggle-view" variant="outline-primary" size="sm">
                                    <x-base.lucide class="mr-1 h-4 w-4" icon="Grid" />
                                    <span id="view-text">Compact View</span>
                                </x-base.button>
                            </div>
                        </div>
                    </div>

                    <!-- Permission Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                                        <x-base.lucide class="w-4 h-4 text-blue-600 dark:text-blue-400" icon="Layers" />
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-blue-900 dark:text-blue-100">Total Groups</p>
                                    <p class="text-lg font-semibold text-blue-600 dark:text-blue-400" id="total-groups">{{ count($permissions) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 border border-green-200 dark:border-green-800">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                                        <x-base.lucide class="w-4 h-4 text-green-600 dark:text-green-400" icon="Shield" />
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-900 dark:text-green-100">Total Permissions</p>
                                    <p class="text-lg font-semibold text-green-600 dark:text-green-400" id="total-permissions">{{ $permissions->flatten()->count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-4 border border-purple-200 dark:border-purple-800">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center">
                                        <x-base.lucide class="w-4 h-4 text-purple-600 dark:text-purple-400" icon="CheckCircle" />
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-purple-900 dark:text-purple-100">Selected</p>
                                    <p class="text-lg font-semibold text-purple-600 dark:text-purple-400" id="selected-count">0</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter -->
                    <div class="mb-6">
                        <div class="relative">
                            <x-base.form-input 
                                type="text" 
                                id="permission-search" 
                                placeholder="Search permissions..." 
                                class="pl-10 pr-4 py-2 w-full"
                            />
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-base.lucide class="h-4 w-4 text-slate-400" icon="Search" />
                            </div>
                        </div>
                    </div>

                    <!-- BEGIN: Company Access -->
                    <div class="mb-6">
                        <div class="bg-gradient-to-r from-emerald-50 to-blue-50 dark:from-emerald-900/20 dark:to-blue-900/20 rounded-xl border-2 border-emerald-200 dark:border-emerald-700 p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center mr-4">
                                        <x-base.lucide class="h-5 w-5 text-white" icon="Building" />
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-emerald-800 dark:text-emerald-200">
                                            Company Access
                                        </h3>
                                        <p class="text-sm text-emerald-600 dark:text-emerald-400 mt-1">
                                            Enable access to company data and select which CV/companies can be accessed
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <x-base.form-switch>
                                        <x-base.form-switch.input 
                                            id="company_access_toggle" 
                                            name="company_access_toggle" 
                                            type="checkbox"
                                            class="company-access-toggle"
                                            checked="@if(($data->permissions ?? collect())->pluck('name')->contains('company.access') || ($data->cvs ?? collect())->count() > 0) checked @endif"
                                        />
                                        <x-base.form-switch.label for="company_access_toggle" class="text-emerald-700 dark:text-emerald-300">
                                            Enable Company Access
                                        </x-base.form-switch.label>
                                    </x-base.form-switch>
                                </div>
                            </div>
                            
                            <div id="company-access-selection" class="pt-4 border-t border-emerald-200 dark:border-emerald-700" 
                                 style="display: {{ (($data->permissions ?? collect())->pluck('name')->contains('company.access') || ($data->cvs ?? collect())->count() > 0) ? 'block' : 'none' }};">
                                
                                <!-- Debug info -->
                                @if(session('debug'))
                                    <div class="bg-yellow-50 border border-yellow-200 rounded p-3 mb-4">
                                        <pre>{{ session('debug') }}</pre>
                                    </div>
                                @endif
                                
                                @error('cvs')
                                    <div class="bg-red-50 border border-red-200 text-red-700 rounded p-3 mb-4">
                                        {{ $message }}
                                    </div>
                                @enderror
                                
                                <div class="mb-4">
                                    <x-base.form-label for="cv_access" class="text-emerald-800 dark:text-emerald-200 font-medium">
                                        Select CV/Companies to Access
                                    </x-base.form-label>
                                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1 mb-3">
                                        Choose which companies this role can access. Leave empty for access to all companies.
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach(App\Models\CV::all() as $cv)
                                        <div class="bg-white dark:bg-slate-800 rounded-lg border border-emerald-200 dark:border-slate-600 p-3 hover:border-emerald-300 dark:hover:border-emerald-600 transition-colors">
                                            <x-base.form-check class="cv-checkbox">
                                                <x-base.form-check.input 
                                                    type="checkbox" 
                                                    name="cvs[]" 
                                                    value="{{ $cv->id }}"
                                                    id="cv_{{ $cv->id }}"
                                                    class="cv-checkbox-input scale-110"
                                                    checked="{{($data->cvs ?? collect())->pluck('id')->contains($cv->id) ? 'checked' : ''}}"
                                                />
                                                <x-base.form-check.label for="cv_{{ $cv->id }}" class="flex items-center cursor-pointer w-full">
                                                    <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center mr-3">
                                                        <x-base.lucide class="h-4 w-4 text-emerald-600 dark:text-emerald-400" icon="Building2" />
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="text-sm font-medium text-slate-800 dark:text-slate-200">
                                                            {{ $cv->name }}
                                                        </div>
                                                        @if($cv->description)
                                                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                                                {{ Str::limit($cv->description, 50) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </x-base.form-check.label>
                                            </x-base.form-check>
                                        </div>
                                    @endforeach
                                </div>
                                
                                @if(App\Models\CV::count() == 0)
                                    <div class="text-center py-8">
                                        <x-base.lucide class="h-12 w-12 text-slate-400 mx-auto mb-3" icon="Building" />
                                        <p class="text-slate-500 dark:text-slate-400">No companies/CVs available</p>
                                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Create companies first to assign access</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- END: Company Access -->

                    <div class="space-y-4" id="permissions-container">
                        @foreach($permissions as $groupName => $groupPermissions)
                            <div class="permission-group bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-700" data-group="{{ Str::slug($groupName) }}">
                                <div class="p-4 border-b border-slate-200 dark:border-slate-700">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <x-base.form-check.input 
                                                type="checkbox" 
                                                class="group-checkbox mr-3 scale-110" 
                                                data-group="{{ Str::slug($groupName) }}"
                                                id="group-{{ Str::slug($groupName) }}"
                                            />
                                            <x-base.form-check.label for="group-{{ Str::slug($groupName) }}" class="flex items-center cursor-pointer">
                                                @php
                                                    $icons = [
                                                        'Dashboard' => 'BarChart3',
                                                        'Users' => 'Users',
                                                        'Roles' => 'Shield',
                                                        'Products' => 'Package',
                                                        'Categories' => 'Folder',
                                                        'Stock' => 'Archive',
                                                        'Sales' => 'ShoppingCart',
                                                        'Customers' => 'UserCheck',
                                                        'Suppliers' => 'Truck',
                                                        'Delivery Orders' => 'Send',
                                                        'Vehicle Services' => 'Wrench',
                                                        'Vehicles' => 'Car',
                                                        'Drivers' => 'UserCircle',
                                                        'Transport' => 'MapPin',
                                                        'Cash Flow' => 'CreditCard',
                                                        'Spending Categories' => 'Tags',
                                                        'Tax' => 'Calculator',
                                                        'Closing' => 'FileCheck'
                                                    ];
                                                    $icon = $icons[$groupName] ?? 'Shield';
                                                @endphp
                                                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center mr-3">
                                                    <x-base.lucide class="h-4 w-4 text-primary" icon="{{ $icon }}" />
                                                </div>
                                                <div>
                                                    <div class="text-base font-semibold text-slate-800 dark:text-slate-200">
                                                        {{ $groupName }}
                                                    </div>
                                                    <div class="text-xs text-slate-500 mt-0.5">
                                                        {{ count($groupPermissions) }} permissions
                                                    </div>
                                                </div>
                                            </x-base.form-check.label>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs bg-slate-200 dark:bg-slate-700 px-2 py-1 rounded-full text-slate-600 dark:text-slate-400 group-counter">
                                                0/{{ count($groupPermissions) }}
                                            </span>
                                            <button type="button" class="toggle-group text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                                                <x-base.lucide class="h-4 w-4 transform transition-transform duration-200" icon="ChevronDown" />
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="permission-items p-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                                    @foreach($groupPermissions as $permission)
                                        <div class="permission-item bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-600 p-3 hover:border-primary/30 hover:bg-primary/5 dark:hover:bg-primary/10 transition-all duration-200" data-permission="{{ strtolower($permission->display_name) }}">
                                            <x-base.form-check class="permission-checkbox">
                                                <x-base.form-check.input 
                                                    type="checkbox" 
                                                    name="permissions[]" 
                                                    value="{{ $permission->id }}"
                                                    data-group="{{ Str::slug($groupName) }}"
                                                    id="permission-{{ $permission->id }}"
                                                    class="scale-110"
                                                    checked="{{ ($data->permissions && $data->permissions->contains($permission->id)) || (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) }}"
                                                />
                                                <x-base.form-check.label for="permission-{{ $permission->id }}" class="ml-3 cursor-pointer flex-1">
                                                    <div class="font-medium text-slate-800 dark:text-slate-200 text-sm">
                                                        {{ $permission->display_name }}
                                                    </div>
                                                    @if($permission->description)
                                                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                                            {{ $permission->description }}
                                                        </div>
                                                    @endif
                                                </x-base.form-check.label>
                                            </x-base.form-check>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @error('permissions')
                        <div class="pristine-error text-danger mt-4 p-3 bg-danger/10 border border-danger/20 rounded-lg">
                            <x-base.lucide class="inline mr-2 h-4 w-4" icon="AlertCircle" />
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <!-- END: Permissions -->

                <!-- BEGIN: Form Actions -->
                <div class="intro-y box p-5">
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('role.index') }}">
                            <x-base.button type="button" variant="outline-secondary">
                                <x-base.lucide class="mr-2 h-4 w-4" icon="X" />
                                Cancel
                            </x-base.button>
                        </a>
                        <x-base.button type="submit" variant="primary">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="Save" />
                            {{ $type == 'create' ? 'Create Role' : 'Update Role' }}
                        </x-base.button>
                    </div>
                </div>
                <!-- END: Form Actions -->
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let isCompactView = false;

            // Update counters
            function updateCounters() {
                const totalSelected = document.querySelectorAll('input[name="permissions[]"]:checked').length;
                document.getElementById('selected-count').textContent = totalSelected;

                // Update group counters
                document.querySelectorAll('.permission-group').forEach(group => {
                    const groupSlug = group.dataset.group;
                    const groupPermissions = group.querySelectorAll('input[name="permissions[]"]');
                    const checkedPermissions = group.querySelectorAll('input[name="permissions[]"]:checked');
                    const counter = group.querySelector('.group-counter');
                    
                    if (counter) {
                        counter.textContent = `${checkedPermissions.length}/${groupPermissions.length}`;
                        
                        // Update counter color based on selection
                        counter.className = counter.className.replace(/bg-\w+-\d+/g, '');
                        counter.className = counter.className.replace(/text-\w+-\d+/g, '');
                        
                        if (checkedPermissions.length === 0) {
                            counter.classList.add('bg-slate-200', 'dark:bg-slate-700', 'text-slate-600', 'dark:text-slate-400');
                        } else if (checkedPermissions.length === groupPermissions.length) {
                            counter.classList.add('bg-green-200', 'dark:bg-green-900/50', 'text-green-800', 'dark:text-green-300');
                        } else {
                            counter.classList.add('bg-yellow-200', 'dark:bg-yellow-900/50', 'text-yellow-800', 'dark:text-yellow-300');
                        }
                    }
                });
            }

            // Search functionality
            const searchInput = document.getElementById('permission-search');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const permissionGroups = document.querySelectorAll('.permission-group');
                
                permissionGroups.forEach(group => {
                    const groupName = group.querySelector('.text-base').textContent.toLowerCase();
                    const permissions = group.querySelectorAll('.permission-item');
                    let hasVisiblePermissions = false;
                    
                    permissions.forEach(permission => {
                        const permissionName = permission.dataset.permission || '';
                        const permissionText = permission.querySelector('.font-medium').textContent.toLowerCase();
                        
                        if (permissionName.includes(searchTerm) || permissionText.includes(searchTerm) || groupName.includes(searchTerm)) {
                            permission.style.display = 'block';
                            hasVisiblePermissions = true;
                        } else {
                            permission.style.display = 'none';
                        }
                    });
                    
                    group.style.display = hasVisiblePermissions ? 'block' : 'none';
                });
            });

            // Toggle view functionality
            const toggleViewBtn = document.getElementById('toggle-view');
            const viewText = document.getElementById('view-text');
            
            toggleViewBtn.addEventListener('click', function() {
                isCompactView = !isCompactView;
                const permissionItems = document.querySelectorAll('.permission-items');
                
                if (isCompactView) {
                    permissionItems.forEach(container => {
                        container.classList.remove('grid-cols-1', 'md:grid-cols-2', 'xl:grid-cols-3');
                        container.classList.add('grid-cols-1', 'md:grid-cols-3', 'xl:grid-cols-4');
                    });
                    
                    document.querySelectorAll('.permission-item').forEach(item => {
                        item.classList.add('p-2');
                        item.classList.remove('p-3');
                        const description = item.querySelector('.text-xs');
                        if (description) description.style.display = 'none';
                    });
                    
                    viewText.textContent = 'Detailed View';
                } else {
                    permissionItems.forEach(container => {
                        container.classList.remove('grid-cols-1', 'md:grid-cols-3', 'xl:grid-cols-4');
                        container.classList.add('grid-cols-1', 'md:grid-cols-2', 'xl:grid-cols-3');
                    });
                    
                    document.querySelectorAll('.permission-item').forEach(item => {
                        item.classList.remove('p-2');
                        item.classList.add('p-3');
                        const description = item.querySelector('.text-xs');
                        if (description) description.style.display = 'block';
                    });
                    
                    viewText.textContent = 'Compact View';
                }
            });

            // Group toggle functionality
            document.querySelectorAll('.toggle-group').forEach(toggleBtn => {
                toggleBtn.addEventListener('click', function() {
                    const group = this.closest('.permission-group');
                    const permissionItems = group.querySelector('.permission-items');
                    const chevron = this.querySelector('svg');
                    
                    if (permissionItems.style.display === 'none') {
                        permissionItems.style.display = 'grid';
                        chevron.style.transform = 'rotate(0deg)';
                    } else {
                        permissionItems.style.display = 'none';
                        chevron.style.transform = 'rotate(-90deg)';
                    }
                });
            });

            // Select All functionality
            document.getElementById('select-all').addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
                const groupCheckboxes = document.querySelectorAll('.group-checkbox');
                
                checkboxes.forEach(checkbox => checkbox.checked = true);
                groupCheckboxes.forEach(checkbox => {
                    checkbox.checked = true;
                    checkbox.indeterminate = false;
                });
                updateCounters();
            });

            // Deselect All functionality
            document.getElementById('deselect-all').addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
                const groupCheckboxes = document.querySelectorAll('.group-checkbox');
                
                checkboxes.forEach(checkbox => checkbox.checked = false);
                groupCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                    checkbox.indeterminate = false;
                });
                updateCounters();
            });

            // Group checkbox functionality
            document.querySelectorAll('.group-checkbox').forEach(groupCheckbox => {
                groupCheckbox.addEventListener('change', function() {
                    const group = this.dataset.group;
                    const groupPermissions = document.querySelectorAll(`input[name="permissions[]"][data-group="${group}"]`);
                    
                    groupPermissions.forEach(permission => {
                        permission.checked = this.checked;
                    });
                    updateCounters();
                });
            });

            // Individual permission checkbox functionality
            document.querySelectorAll('input[name="permissions[]"]').forEach(permissionCheckbox => {
                permissionCheckbox.addEventListener('change', function() {
                    const group = this.dataset.group;
                    const groupCheckbox = document.querySelector(`.group-checkbox[data-group="${group}"]`);
                    const groupPermissions = document.querySelectorAll(`input[name="permissions[]"][data-group="${group}"]`);
                    const checkedPermissions = document.querySelectorAll(`input[name="permissions[]"][data-group="${group}"]:checked`);
                    
                    // Update group checkbox state
                    if (checkedPermissions.length === groupPermissions.length) {
                        groupCheckbox.checked = true;
                        groupCheckbox.indeterminate = false;
                    } else if (checkedPermissions.length > 0) {
                        groupCheckbox.checked = false;
                        groupCheckbox.indeterminate = true;
                    } else {
                        groupCheckbox.checked = false;
                        groupCheckbox.indeterminate = false;
                    }
                    updateCounters();
                });
            });

            // Initialize group checkbox states and counters
            document.querySelectorAll('.group-checkbox').forEach(groupCheckbox => {
                const group = groupCheckbox.dataset.group;
                const groupPermissions = document.querySelectorAll(`input[name="permissions[]"][data-group="${group}"]`);
                const checkedPermissions = document.querySelectorAll(`input[name="permissions[]"][data-group="${group}"]:checked`);
                
                if (checkedPermissions.length === groupPermissions.length) {
                    groupCheckbox.checked = true;
                    groupCheckbox.indeterminate = false;
                } else if (checkedPermissions.length > 0) {
                    groupCheckbox.checked = false;
                    groupCheckbox.indeterminate = true;
                } else {
                    groupCheckbox.checked = false;
                    groupCheckbox.indeterminate = false;
                }
            });

            // Company Access Toggle functionality
            const companyAccessToggle = document.getElementById('company_access_toggle');
            const companyAccessSelection = document.getElementById('company-access-selection');
            const companyPermissionInput = document.getElementById('company_permission');
            const cvCheckboxInputs = document.querySelectorAll('.cv-checkbox-input');
            
            companyAccessToggle.addEventListener('change', function() {
                console.log('Company access toggle changed:', this.checked);
                
                if (this.checked) {
                    companyAccessSelection.style.display = 'block';
                    
                    // Auto-add company.access permission (ID: 74) to permissions array by creating hidden input
                    let hiddenPermissionInput = document.querySelector('input[name="permissions[]"][value="74"]');
                    if (!hiddenPermissionInput) {
                        hiddenPermissionInput = document.createElement('input');
                        hiddenPermissionInput.type = 'hidden';
                        hiddenPermissionInput.name = 'permissions[]';
                        hiddenPermissionInput.value = '74';
                        hiddenPermissionInput.id = 'hidden_company_access';
                        companyAccessSelection.appendChild(hiddenPermissionInput);
                        console.log('Added company.access permission hidden input');
                    }
                } else {
                    companyAccessSelection.style.display = 'none';
                    
                    // Remove company.access permission
                    const hiddenPermissionInput = document.getElementById('hidden_company_access');
                    if (hiddenPermissionInput) {
                        hiddenPermissionInput.remove();
                        console.log('Removed company.access permission hidden input');
                    }
                    
                    // Uncheck all CV selections when disabled
                    cvCheckboxInputs.forEach(input => {
                        input.checked = false;
                    });
                }
                updateCounters();
            });

            // Initialize company access permission on page load
            if (companyAccessToggle.checked) {
                let hiddenPermissionInput = document.querySelector('input[name="permissions[]"][value="74"]');
                if (!hiddenPermissionInput) {
                    hiddenPermissionInput = document.createElement('input');
                    hiddenPermissionInput.type = 'hidden';
                    hiddenPermissionInput.name = 'permissions[]';
                    hiddenPermissionInput.value = '74';
                    hiddenPermissionInput.id = 'hidden_company_access';
                    companyAccessSelection.appendChild(hiddenPermissionInput);
                }
            }

            // Initial counter update
            updateCounters();

            // Add smooth animations
            document.querySelectorAll('.permission-item').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-1px)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });

        // Debug function for form submission
        function debugFormSubmit(event) {
            console.log('Form submission debug:');
            
            // Debug permissions
            const permissions = document.querySelectorAll('input[name="permissions[]"]:checked');
            console.log('Selected permissions:', Array.from(permissions).map(p => p.value));
            
            // Debug CVs
            const cvs = document.querySelectorAll('input[name="cvs[]"]:checked');
            console.log('Selected CVs:', Array.from(cvs).map(cv => cv.value));
            
            // Check company access toggle
            const companyToggle = document.getElementById('company_access_toggle');
            console.log('Company access enabled:', companyToggle.checked);
            
            // Allow form to submit
            return true;
        }
    </script>
    @endpush
@endsection
