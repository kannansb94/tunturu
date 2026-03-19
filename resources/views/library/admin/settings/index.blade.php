@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div
                class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 p-8 shadow-2xl">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-white/20 backdrop-blur-sm rounded-xl">
                            <span class="material-symbols-outlined text-5xl text-white">settings</span>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1">Library Settings</h1>
                            <p class="text-white/90">Configure your library application</p>
                        </div>
                    </div>
                </div>
            </div>



            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                        <div x-data="{ activeTab: 'general' }">
                            <form id="settings-form" action="{{ route('library.admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                            <!-- Tabs -->
                            <div class="flex space-x-1 border-b border-gray-200 dark:border-gray-700 mb-6">
                                <button type="button" @click="activeTab = 'general'"
                                    :class="{ 'border-purple-500 text-purple-600 dark:text-purple-400': activeTab === 'general', 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'general' }"
                                    class="px-4 py-2 border-b-2 font-medium text-sm transition-colors">General</button>
                                <button type="button" @click="activeTab = 'rental'"
                                    :class="{ 'border-purple-500 text-purple-600 dark:text-purple-400': activeTab === 'rental', 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'rental' }"
                                    class="px-4 py-2 border-b-2 font-medium text-sm transition-colors">Rental Rules</button>
                                <button type="button" @click="activeTab = 'payment'"
                                    :class="{ 'border-purple-500 text-purple-600 dark:text-purple-400': activeTab === 'payment', 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'payment' }"
                                    class="px-4 py-2 border-b-2 font-medium text-sm transition-colors">Payment
                                    Gateway</button>
                                <button type="button" @click="activeTab = 'seo'"
                                    :class="{ 'border-purple-500 text-purple-600 dark:text-purple-400': activeTab === 'seo', 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'seo' }"
                                    class="px-4 py-2 border-b-2 font-medium text-sm transition-colors">SEO</button>
                                <button type="button" @click="activeTab = 'email'"
                                    :class="{ 'border-purple-500 text-purple-600 dark:text-purple-400': activeTab === 'email', 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'email' }"
                                    class="px-4 py-2 border-b-2 font-medium text-sm transition-colors">Email Templates</button>
                                <button type="button" @click="activeTab = 'users'"
                                    :class="{ 'border-purple-500 text-purple-600 dark:text-purple-400': activeTab === 'users', 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'users' }"
                                    class="px-4 py-2 border-b-2 font-medium text-sm transition-colors">User
                                    Management</button>
                                <button type="button" @click="activeTab = 'roles'"
                                    :class="{ 'border-purple-500 text-purple-600 dark:text-purple-400': activeTab === 'roles', 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'roles' }"
                                    class="px-4 py-2 border-b-2 font-medium text-sm transition-colors">Roles &
                                    Permissions</button>
                            </div>

                            <!-- Tab Contents -->
                            <div class="space-y-6">
                                <!-- General Settings -->
                                <div x-show="activeTab === 'general'" class="space-y-6">
                                    @foreach($settings['general'] ?? [] as $setting)
                                        <div>
                                            <label for="{{ $setting->key }}"
                                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ $setting->description }}</label>
                                            @if($setting->type === 'text')
                                                <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                                    value="{{ $setting->value }}"
                                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                            @elseif($setting->type === 'file')
                                                @if($setting->value)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $setting->value) }}" alt="Logo"
                                                            class="h-16 w-auto rounded-lg shadow-sm">
                                                    </div>
                                                @endif
                                                <input type="file" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Rental Rules -->
                                <div x-show="activeTab === 'rental'" class="space-y-6" style="display: none;">
                                    @foreach($settings['rental'] ?? [] as $setting)
                                        <div>
                                            <label for="{{ $setting->key }}"
                                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ $setting->description }}</label>
                                            <input type="number" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                                value="{{ $setting->value }}"
                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Payment Gateway -->
                                <div x-show="activeTab === 'payment'" class="space-y-6" style="display: none;">
                                    @foreach($settings['payment'] ?? [] as $setting)
                                        <div>
                                            <label for="{{ $setting->key }}"
                                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ $setting->description }}</label>
                                            @if($setting->type === 'boolean')
                                                <select name="{{ $setting->key }}" id="{{ $setting->key }}"
                                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                                    <option value="1" {{ $setting->value == '1' ? 'selected' : '' }}>Enabled</option>
                                                    <option value="0" {{ $setting->value == '0' ? 'selected' : '' }}>Disabled</option>
                                                </select>
                                            @else
                                                <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                                    value="{{ $setting->value }}"
                                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <!-- SEO Settings -->
                                <div x-show="activeTab === 'seo'" class="space-y-6" style="display: none;">
                                    @foreach($settings['seo'] ?? [] as $setting)
                                        <div>
                                            <label for="{{ $setting->key }}"
                                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ $setting->description }}</label>
                                            @if($setting->type === 'textarea')
                                                <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" rows="4"
                                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">{{ $setting->value }}</textarea>
                                            @else
                                                <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                                    value="{{ $setting->value }}"
                                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Email Templates -->
                                <div x-show="activeTab === 'email'" class="space-y-6" style="display: none;">
                                    @foreach($settings['email'] ?? [] as $setting)
                                        <div>
                                            <label for="{{ $setting->key }}"
                                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ $setting->description }}</label>
                                            @if($setting->type === 'textarea')
                                                <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" rows="4"
                                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">{{ $setting->value }}</textarea>
                                            @elseif($setting->type === 'file')
                                                @if($setting->value)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $setting->value) }}" alt="Logo"
                                                            class="h-16 w-auto rounded-lg shadow-sm">
                                                    </div>
                                                @endif
                                                <input type="file" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                            @else
                                                <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                                    value="{{ $setting->value }}"
                                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                </div>
                            </form>

                                    <!-- User Management -->
                                    <div x-show="activeTab === 'users'" class="space-y-6" style="display: none;">
                                        <div
                                            class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-100 dark:border-blue-800">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">User
                                                        Management</h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Create new
                                                        users and assign roles (Admin/User).</p>
                                                </div>
                                                <a href="{{ route('library.admin.users.create') }}"
                                                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                                                    <span class="material-symbols-outlined">person_add</span>
                                                    Create New User
                                                </a>
                                            </div>
                                        </div>

                                        <div
                                            class="bg-yellow-50 dark:bg-yellow-900/20 rounded-xl p-6 border border-yellow-100 dark:border-yellow-800">
                                            <div class="flex items-start gap-4">
                                                <span
                                                    class="material-symbols-outlined text-yellow-600 dark:text-yellow-500 text-3xl">info</span>
                                                <div>
                                                    <h4 class="text-base font-bold text-gray-900 dark:text-white">Note
                                                    </h4>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                        To manage existing users (edit details, approve KYC, view
                                                        history), please visit the
                                                        <a href="{{ route('library.admin.users.index') }}"
                                                            class="text-blue-600 underline hover:text-blue-800">Users
                                                            Dashboard</a>.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                <!-- Roles & Permissions -->
                                <div x-show="activeTab === 'roles'" class="space-y-6" style="display: none;">
                                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                                        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Roles & Permissions</h3>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage user roles and their access levels.</p>
                                            </div>
                                            <a href="{{ route('library.admin.roles.create') }}" 
                                                class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg shadow transition-colors flex items-center gap-2">
                                                <span class="material-symbols-outlined text-sm">add_moderator</span>
                                                Create Role
                                            </a>
                                        </div>
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                <thead class="bg-gray-50 dark:bg-gray-900/50">
                                                    <tr>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role Name</th>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Permissions</th>
                                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                    @php
                                                        $roles = \App\Models\Role::all();
                                                    @endphp
                                                    @foreach($roles as $role)
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $role->name }}</div>
                                                                <div class="text-xs text-gray-500">{{ $role->slug }}</div>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <div class="flex flex-wrap gap-1">
                                                                    @foreach(array_slice($role->permissions ?? [], 0, 3) as $perm)
                                                                        <span class="px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                                                            {{ str_replace('_', ' ', $perm) }}
                                                                        </span>
                                                                    @endforeach
                                                                    @if(count($role->permissions ?? []) > 3)
                                                                        <span class="px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                                                            +{{ count($role->permissions) - 3 }} more
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                                <div class="flex items-center justify-end gap-2">
                                                                    <a href="{{ route('library.admin.roles.edit', $role->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Edit</a>
                                                                    
                                                                    @if(!in_array($role->slug, ['admin', 'user']))
                                                                        <form action="{{ route('library.admin.roles.destroy', $role->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 ml-2">Delete</button>
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Quick Role Assignment -->
                                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Quick Role Assignment</h3>
                                        <form action="{{ route('library.admin.users.assignRole') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                                            @csrf
                                            
                                            <!-- User Select (Searchable) -->
                                            <div x-data="{
                                                search: '',
                                                open: false,
                                                selectedUser: null,
                                                users: {{ json_encode($users->map(fn($u) => ['id' => $u->id, 'name' => $u->name, 'email' => $u->email, 'role' => ucfirst($u->role)])) }},
                                                get filteredUsers() {
                                                    if (this.search === '') return this.users;
                                                    return this.users.filter(user => 
                                                        user.name.toLowerCase().includes(this.search.toLowerCase()) || 
                                                        user.email.toLowerCase().includes(this.search.toLowerCase())
                                                    );
                                                },
                                                init() {
                                                    // Optional: If you wanted to pre-select based on old input
                                                }
                                            }" class="relative" @click.away="open = false">
                                                <label for="user_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Select User</label>
                                                
                                                <!-- Hidden Input -->
                                                <input type="hidden" name="user_id" :value="selectedUser ? selectedUser.id : ''" required>

                                                <!-- Trigger -->
                                                <div @click="open = !open"
                                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all cursor-pointer flex justify-between items-center">
                                                    <span x-text="selectedUser ? selectedUser.name + ' (' + selectedUser.email + ') - Current: ' + selectedUser.role : 'Choose a user...'"
                                                        :class="{'text-gray-500': !selectedUser}"></span>
                                                    <span class="material-symbols-outlined text-gray-500">expand_more</span>
                                                </div>

                                                <!-- Dropdown -->
                                                <div x-show="open" 
                                                    class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 max-h-60 overflow-auto"
                                                    style="display: none;">
                                                    
                                                    <!-- Search Input -->
                                                    <div class="p-2 sticky top-0 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                                                        <input x-model="search" type="text" placeholder="Search by name or email..."
                                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                                                    </div>

                                                    <!-- List -->
                                                    <ul>
                                                        <template x-for="user in filteredUsers" :key="user.id">
                                                            <li @click="selectedUser = user; open = false; search = ''"
                                                                class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer text-sm border-b border-gray-100 dark:border-gray-800 last:border-0">
                                                                <div class="font-medium text-gray-900 dark:text-gray-100" x-text="user.name"></div>
                                                                <div class="text-xs text-gray-500">
                                                                    <span x-text="user.email"></span> • <span x-text="user.role"></span>
                                                                </div>
                                                            </li>
                                                        </template>
                                                        <li x-show="filteredUsers.length === 0" class="px-4 py-3 text-sm text-gray-500 text-center">
                                                            No users found.
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <!-- Role Select -->
                                            <div>
                                                <label for="role_slug" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Assign Role</label>
                                                <select name="role_slug" id="role_slug" required
                                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                                    <option value="">Choose a role...</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->slug }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Submit Button -->
                                            <div>
                                                <button type="submit"
                                                    class="w-full px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow transition-all flex items-center justify-center gap-2">
                                                    <span class="material-symbols-outlined">badge</span>
                                                    Update Role
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end mb-6 pr-6"
                                x-show="['general', 'rental', 'payment', 'seo', 'email'].includes(activeTab)">
                                <button type="submit" form="settings-form"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all flex items-center gap-2">
                                    <span class="material-symbols-outlined">save</span>
                                    Save Settings
                                </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection