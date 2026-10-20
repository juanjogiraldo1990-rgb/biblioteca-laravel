<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carga Masiva de Libros</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen font-sans">

    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">📚 Carga Masiva de Libros</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">{{ session('error') }}</div>
        @endif

        <form action="{{ route('export.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Selecciona el archivo Excel (.xlsx)</label>
                <input type="file" name="file" accept=".xlsx, .xls, .csv" required
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded">
            </div>

            <div class="bg-blue-50 p-3 rounded text-xs text-blue-800 mb-6">
                <strong>Formato requerido (fila 1):</strong><br>
                title, isbn, description, price, stock, status, category_id, author_id, editorial_id
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ url('/admin/resource/book-resource/book-index-page') }}" class="text-gray-500 hover:text-gray-700 text-sm">Cancelar</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Subir y Procesar
                </button>
            </div>
        </form>
    </div>

</body>
</html>