<div class="mt-4 flex justify-between items-center">
    <div class="mb-2">
        <span class="text-sm text-gray-600">
            Mostrando {{ $items->firstItem() }} a {{ $items->lastItem() }} de
            {{ $items->total() }} elementos
        </span>
    </div>
    @if ($items->hasPages())
        <ul class="inline-flex items-center space-x-2">
            @if ($items->onFirstPage())
                <li class="opacity-50 cursor-not-allowed text-gray-500 px-3 py-1">Anterior</li>
            @else
                <li>
                    <a href="{{ $items->previousPageUrl() }}"
                        class="px-3 py-1 bg-gray-800 text-white rounded hover:bg-gray-700">Anterior</a>
                </li>
            @endif
            @foreach ($items->links()->elements[0] as $page => $url)
                @if ($page == $items->currentPage())
                    <li class="px-3 py-1 bg-slite-500 text-white rounded">{{ $page }}</li>
                @else
                    <li>
                        <a href="{{ $url }}"
                            class="px-3 py-1 bg-gray-800 text-white rounded hover:bg-gray-700">{{ $page }}</a>
                    </li>
                @endif
            @endforeach
            @if ($items->hasMorePages())
                <li>
                    <a href="{{ $items->nextPageUrl() }}"
                        class="px-3 py-1 bg-gray-800 text-white rounded hover:bg-gray-700">Siguiente</a>
                </li>
            @else
                <li class="opacity-50 cursor-not-allowed text-gray-500 px-3 py-1">Siguiente</li>
            @endif
        </ul>
    @endif
</div>
