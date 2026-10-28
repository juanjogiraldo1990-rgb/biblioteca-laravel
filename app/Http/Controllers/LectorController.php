<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\MoonshineUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class LectorController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function formulario()
    {
        return view('registro');
    }

    /**
     * Guarda al nuevo Lector en la base de datos.
     */
    public function guardar(Request $request)
    {
        // Validaciones estrictas: correo único y contraseña fuerte
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:moonshine_users,email',
            'password' => [
                'required',
                'confirmed', // Requiere que se escriba dos veces (password_confirmation)
                Password::min(8) // Mínimo 8 caracteres
                    ->letters()
                    ->mixedCase() // Al menos una mayúscula y una minúscula
                    ->numbers()   // Al menos un número
                    ->symbols(),  // Al menos un carácter especial (!@#$%^&*)
            ],
        ], [
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        // Creamos el usuario con rol de Lector (ID 3) y su contraseña encriptada
        MoonshineUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'moonshine_user_role_id' => 3, 
        ]);

        return redirect()->route('registro')->with('success', '¡Registro exitoso! Ya puedes iniciar sesión con tu correo y tu nueva contraseña.');
    }

    /**
     * Recibe la solicitud de préstamo de un libro.
     */
    public function solicitar(Book $book)
    {
        $user = auth('moonshine')->user();

        if ($book->stock <= 0) {
            return back()->with('error', 'Lo sentimos, no hay ejemplares disponibles de este libro.');
        }

        Loan::create([
            'book_id' => $book->id,
            'member_id' => 1, 
            'user_id' => $user->id, 
            'loan_date' => now(),
            'due_date' => now()->addDays(15),
            'status' => 'pending', 
        ]);

        return back()->with('success', '¡Solicitud enviada! El administrador revisará tu petición.');
    }
}