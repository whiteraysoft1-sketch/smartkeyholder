<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vcard Templates') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Available Vcard Templates</h3>
                    @if(auth()->user()->profile->selected_template)
                        <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                            <strong>Currently Selected:</strong> {{ ucfirst(auth()->user()->profile->selected_template) }}
                        </div>
                    @endif
                    @if(count($templates) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($templates as $template)
                                @php
                                    $isSelected = auth()->user()->profile->selected_template === $template['file'];
                                @endphp
                                <div class="border rounded-lg p-4 shadow hover:shadow-lg transition {{ $isSelected ? 'border-green-500 bg-green-50' : '' }}">
                                    <div class="font-bold text-indigo-700 mb-2">
                                        {{ $template['name'] }}
                                        @if($isSelected)
                                            <span class="ml-2 bg-green-500 text-white text-xs px-2 py-1 rounded">Selected</span>
                                        @endif
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('dashboard.vcard-templates.preview', ['template' => $template['file']]) }}" target="_blank" class="bg-indigo-600 hover:bg-indigo-700 text-white py-1 px-3 rounded text-sm">Preview</a>
                                        @if(!$isSelected)
                                            <form action="{{ route('dashboard.vcard-templates.select') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="template" value="{{ $template['file'] }}">
                                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded text-sm">Select</button>
                                            </form>
                                        @else
                                            <span class="bg-gray-400 text-white py-1 px-3 rounded text-sm cursor-not-allowed">Selected</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No vcard templates found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
