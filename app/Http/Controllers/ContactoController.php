<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;

class ContactoController extends Controller
{
    public function index() {
        return view('contacto');
    }

    public function send(Request $request) {
        $request->validate([
                            'email' => 'required|email:rfc',
                            'fichero' => 'sometimes|file|mimes:pdf'
                        ]);

        $mensaje = new \stdClass(); // objecto para los datos
        $mensaje->asunto = $request->asunto;
        $mensaje->email = $request->email;
        $mensaje->nombre = $request->nombre;
        $mensaje->mensaje = $request->mensaje;

        $mensaje->fichero = $request->hasFile('fichero') ? $request->file('fichero')->getRealPath() : NULL;
        //$mensaje->ficheroNombre = $request->file('fichero')->getClientOriginalName(); // nombre original del fichero adjunto

        Mail::to('contacto@LaraPelis.com')->send(new Contact($mensaje));

        return redirect()
                ->route('portada')
                ->with('success', 'Mensaje enviado correctamente.');
    }
}
