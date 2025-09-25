<x-app-layout>
    {{-- Header con gradiente --}}
    <x-slot name="header">
        <div class="rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 shadow">
            <div class="px-6 py-6">
                <h2 class="text-2xl font-bold text-Black">Perfil</h2>
                <p class="mt-1 text-sm text-indigo-100">Actualiza tu información, contraseña o elimina tu cuenta.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">
            {{-- Información de perfil --}}
            <div class="overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
                
                <div class="px-6 py-6">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            {{-- Actualizar contraseña --}}
            <div class="overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
                <div class="px-6 py-6">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Eliminar cuenta --}}
            <div class="overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
                <div class="px-6 py-6">
                    <div class="max-w-2xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
