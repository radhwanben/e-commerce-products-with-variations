<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">Products</h1>
                <a href="{{ route('product.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Product
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Table for Products -->
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Variants</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $product->description }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if ($product->image)
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-20 h-auto">
                                @else
                                    No image
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <ul class="list-disc list-inside pl-5">
                                    @forelse ($product->variants as $variant)
                                        <li>
                                            <strong>Price:</strong> ${{ $variant->price }}<br>
                                            <strong>Stock:</strong> {{ $variant->stock }}<br>
                                            <strong>Attributes:</strong>
                                            <ul class="list-disc list-inside pl-5">
                                                @foreach ($variant->attributeValues as $attributeValue)
                                                    <li>{{ $attributeValue->attribute->name }}: {{ $attributeValue->value }}</li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @empty
                                        <li>No variants available.</li>
                                    @endforelse
                                </ul>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-sm text-gray-500 text-center">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
