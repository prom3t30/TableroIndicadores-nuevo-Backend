<?php

namespace App\Http\Controllers\API;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Models\Rol;
use App\Models\User as Usuario;
use App\Http\Controllers\Controller;
use App\Http\Resources\Usuario as UsuarioResource;
use App\Http\Resources\UsuarioCollection;
use Exception;
use Illuminate\Support\Facades\Log;

class UsuarioController extends Controller
{
    private static $secret_key = 'Sdw1s9x8@';

    public function index()
    {
        $usuarios = Usuario::all();
        return new UsuarioCollection($usuarios);
    }

    public function getByRolId($id)
    {
        $usuarios = Usuario::where('rol_id', '=', $id)->get();
        return new UsuarioCollection($usuarios);
    }

    public function create(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'email' => 'required|max:255|email',
            'documento' => 'required|integer|max:999999999999',
            'rol_id' => 'required|integer|min:1',
            'centro' => 'nullable|max:255'
        ]);

        //Verificar la exitencia del rol
        $rol = Rol::where([['id', '=', $request->rol_id]])->first();
        //Verificar el email
        $email = Usuario::where([['email', '=', $request->email]])->first();
        //Verificar nnúmero de cedula
        $cedula = Usuario::where([['cedula', '=', $request->documento]])->first();


        if (isset($rol)) {
            if (!isset($email)) {
                if (!isset($cedula)) {
                    if (strpos($request->email, '@sena.edu.co')) {

                        $user = new Usuario();

                        $user->name = trim($request->nombre);
                        $user->email = trim($request->email);
                        $user->email_verified_at = now();
                        $user->password = md5(md5(md5($request->documento)));
                        $user->cedula = $request->documento;
                        $user->estado = 1;
                        $user->codigoCentro = $request->centro;
                        $user->rol_id = $request->rol_id;
                        $user->save();
                    } else {
                        return response()->json('El correo electrónico digitado no pertenece al dominio "@sena.edu.co', 502);
                    }
                } else {
                    return response()->json('El número del documento de identidad, ya se encuentra registrado.', 502);
                }
            } else {
                return response()->json('El correo electrónico, ya se encuentra registrado.', 502);
            }
        } else {
            return response()->json('No ha escogido el rol o no existe dentro del sistema.', 502);
        }
    }

    public function getById($id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            return new UsuarioResource($usuario);
        } catch (Exception $error) {
            return response()->json("Eliminado", 404);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',

        ]);

        $Usuario = Usuario::where('id', '=', $request->id)->first();
        $Usuario->update($request->all());
        $Usuario = Usuario::where('id', '=', $request->id)->first();

        return (new UsuarioResource($Usuario))
            ->response()
            ->setStatusCode(202);
    }

    //Obtener los gestores de linea
    public function getUsersManagerLine()
    {
        $id = 3;
        $Usuario = Usuario::select(['name', 'id'])
            ->where([['rol_id', '=', $id]])->get();
        return response()->json($Usuario, 202);
    }

    //Obtener los subdirector del Centro
    public function getUsersManagerCentro()
    {
        $RolSubdirectorid = 10;
        $Usuario = Usuario::select(['name', 'id'])
            ->where([['rol_id', '=', $RolSubdirectorid]])->get();
        return response()->json($Usuario, 202);
    }

    public function delete($id)
    {
        $Usuario = Usuario::findOrFail($id);
        $Usuario->delete();

        return response()->json("Eliminado", 204);
    }

    public function auth(Request $request)
    {
        $Usuario = Usuario::where([['email', '=', $request->email]])->first();
        //Corregir
        //$decripted = Crypt::decryptString($Usuario->password);

        $time = time();

        $token = array(
            'exp' => $time + (60 * 60),
            'aud' => self::Aud(),
            'data' => $Usuario
        );

        if ($Usuario == null) {
            return response()->json("Correo no existente", 503);
        } else {
            //Pendiente por cambiar
            if ($Usuario->password == md5(md5(md5($request->password)))) {
                $jwt = JWT::encode($token, self::$secret_key);
                $response = new tokenResponse($Usuario, $jwt);
                if (!$Usuario->remember_token) {

                    $Usuario->remember_token = md5($jwt);
                    $Usuario->save();
                }
                $datosSesion = Usuario::where([['email', '=', $request->email]])->first();
                session(['token' => $datosSesion->remember_token]);

                return response()->json($response, 200);
            } else {
                return response()->json("Contraseña no corresponde", 503);
            }
        }
    }

    public function getUser($id)
    {
        $usuario = Usuario::where([['id', '=', $id]])->first();
        return response()->json($usuario, 202);
    }

    public function logOut()
    {
        session()->flush();
        return response()->json('Ok', 202);
    }

    private static function Aud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }
}

class tokenResponse
{
    public $data;
    public $token;
    function __construct($_data, $_token)
    {
        $this->data = $_data;
        $this->token = $_token;
    }
}
