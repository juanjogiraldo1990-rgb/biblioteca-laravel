<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\MoonshineUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:moonshine_users,email',
        ]);

        MoonshineUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('12345678'),
            'moonshine_user_role_id' => 3,
        ]);

        return redirect()->route('registro')->with('success', '¡Registro exitoso! Ya puedes iniciar sesión con tu correo y la contraseña 12345678');
    }

    /**
     * Recibe la solicitud de préstamo de un libro (Respuesta JSON para MoonShine).
     */
    public function solicitar(Book $book)
    {
        $user = auth('moonshine')->user();

        // Verificamos que el libro tenga stock
        if ($book->stock <= 0) {
            return response()->json([
                'message' => 'Lo sentimos, no hay ejemplares disponibles de este libro.',
                'messageType' => 'error',
            ]);
        }

        // Creamos la solicitud de préstamo en estado 'pending' (Pendiente)
        Loan::create([
            'book_id' => $book->id,
            'member_id' => 1, // ID por defecto para que no falle la llave foránea
            'user_id' => $user->id, // Guardamos el Lector que lo solicita
            'loan_date' => now(),
            'due_date' => now()->addDays(15),
            'status' => 'pending', 
        ]);

        return response()->json([
            'message' => '¡Solicitud enviada! El administrador revisará tu petición.',
            'messageType' => 'success',
        ]);
    }
}