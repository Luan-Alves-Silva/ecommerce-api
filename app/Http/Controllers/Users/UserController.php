<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            # INICIA QUERY BUILDER
            $users_query = User::query();

            if ($request->get('name')) $users_query->where('name', 'like', '%' . $request->get('name') . '%');

            # PAGINA OS USUARIOS
            $users = $users_query->paginate();

            # RETORNA O JSON DE USUARIOS
            return response()->json($users, 200);

        } catch (\Exception $e) {
            throw ($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try { 
            
            # ARMAZENAR TODOS OS VALORES NECESSÁRIOS PARA
            # CRIAR A MODEL RECEBIDOS DO REQUEST
            $inputs = $request->only([
                'name', 'email',
            ]);
            
            $inputs['password'] = bcrypt("123456");

            # ARMAZENAR REGISTRO NO BANCO DE DADOS
            $user = User::create($inputs);
            
            # RETORNAR MODEL
            return response()->json($user, 200);
            

        } catch (\Exception $e) {

            # RETORNAR MENSAGEM DE ERRO
            return response()->json([
                'error' => $e,
                'message' => 'Ocorreu um erro ao registrar usuário.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            # BUSCA O USUARIO PELO ID
            $user = User::findOrFail($id);

            # RETORNAR INFORMAÇÕES
            return response()->json($user, 200);

        } catch (\Exception $e) {
           throw($e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        try {
            
            $user->delete();

            return response()->json([
                'message' => 'Usuário excluído com sucesso!',
            ]);

        } catch(\Exception $e) {
            throw($e);
        }
    }
}
