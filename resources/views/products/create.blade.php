<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h1 class="text-2xl font-semibold mb-6">Create a New Product</h1>

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

            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Product Description</label>
                    <textarea id="description" name="description" rows="5" required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
                    <input type="file" id="image" name="image" required
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>

                <!-- Attributes Section -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Attributes</label>
                    @foreach ($attributes as $attribute)
                        <div class="mt-2">
                            <label class="block text-sm font-medium text-gray-600">{{ $attribute->name }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- Variants Section -->
                <div id="variants-container">
                    <div class="variant-group mb-4 border p-4 rounded-md shadow-sm">
                        <h3 class="text-lg font-semibold mb-4">Variant 1</h3>
                        <div class="mb-4">
                            <label for="variant_price_1" class="block text-sm font-medium text-gray-700">Price</label>
                            <input type="text" id="variant_price_1" name="variants[0][price]" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="mb-4">
                            <label for="variant_stock_1" class="block text-sm font-medium text-gray-700">Stock</label>
                            <input type="text" id="variant_stock_1" name="variants[0][stock]" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Attribute Values</label>
                            @foreach ($attributes as $attribute)
                                <div class="mt-2">
                                    <label class="block text-sm font-medium text-gray-600">{{ $attribute->name }}</label>
                                    @foreach ($attribute->values as $value)
                                        <div class="flex items-center">
                                            <input type="checkbox" id="variant_attribute_{{ $attribute->id }}_{{ $value->id }}_1" name="variants[0][attributes][{{ $attribute->id }}][]" value="{{ $value->id }}" class="mr-2">
                                            <label for="variant_attribute_{{ $attribute->id }}_{{ $value->id }}_1" class="text-sm text-gray-600">{{ $value->value }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <button type="button" id="add-variant" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Add Another Variant
                </button>

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Product
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let variantCount = 1;

            const attributes = @json($attributes);

            document.getElementById('add-variant').addEventListener('click', function () {
                variantCount++;
                const container = document.getElementById('variants-container');
                const variantGroup = document.createElement('div');
                variantGroup.classList.add('variant-group', 'mb-4', 'border', 'p-4', 'rounded-md', 'shadow-sm');

                let attributeOptions = '';
                attributes.forEach(attribute => {
                    attributeOptions += `
        <div class="mt-2">
            <label class="block text-sm font-medium text-gray-600">${attribute.name}</label>
    `;
                    attribute.values.forEach(value => {
                        attributeOptions += `
            <div class="flex items-center">
                <input type="checkbox" id="variant_attribute_${attribute.id}_${value.id}_${variantCount}" name="variants[${variantCount - 1}][attributes][${attribute.id}][]" value="${value.id}" class="mr-2">
                <label for="variant_attribute_${attribute.id}_${value.id}_${variantCount}" class="text-sm text-gray-600">${value.value}</label>
            </div>
        `;
                    });
                    attributeOptions += `</div>`;
                });

                variantGroup.innerHTML = `
    <h3 class="text-lg font-semibold mb-4">Variant ${variantCount}</h3>
    <div class="mb-4">
        <label for="variant_price_${variantCount}" class="block text-sm font-medium text-gray-700">Price</label>
        <input type="text" id="variant_price_${variantCount}" name="variants[${variantCount - 1}][price]" required
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>
    <div class="mb-4">
        <label for="variant_stock_${variantCount}" class="block text-sm font-medium text-gray-700">Stock</label>
        <input type="text" id="variant_stock_${variantCount}" name="variants[${variantCount - 1}][stock]" required
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Attribute Values</label>
        ${attributeOptions}
    </div>
`;

                container.appendChild(variantGroup);
            });
        });

    </script>

</x-app-layout>
