<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Lector</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans h-screen flex justify-center items-center">

    <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-md">
        <h2 class="text-3xl font-bold mb-6 text-center text-indigo-400">Registro de Lector</h2>

        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('registro.guardar') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Nombre Completo</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:border-indigo-500">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:border-indigo-500">
            </div>

            <!-- NUEVO CAMPO: CONTRASEÑA -->
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Contraseña</label>
                <input type="password" name="password" required class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:border-indigo-500">
                <p class="text-xs text-gray-400 mt-1">Mínimo 8 caracteres, 1 mayúscula, 1 número y 1 símbolo.</p>
            </div>

            <!-- NUEVO CAMPO: CONFIRMAR CONTRASEÑA -->
            <div class="mb-6">
                <label class="block text-sm font-bold mb-2">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" required class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:border-indigo-500">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Registrarme
            </button>
        </form>
        
        <div class="text-center mt-4">
            <a href="/" class="text-sm text-gray-400 hover:text-white">Volver al inicio</a>
        </div>
    </div>

</body>
</html>