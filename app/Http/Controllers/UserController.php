<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //Listar dados
    public function index() 
    {
        // Recuperar registros do banco de dados
        $users = User::get();
        // Carregar VIEW
        return view('users.index', ['users' => $users] );
    }

    //Importar dados
    public function import(Request $request)
    {
        //Validar arquivo
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ],[
            'file.required' => 'O campo arquivo é obrigatório!',
            'file.mimes' => 'Arquivo inválido, apenas arquivos CSV!',
            'file.max' => 'Tamanho do arquivo excede :max Mb!'
        ]);

        // Criar array com as colunas do database
        //$headers = ['categoria', 'rota', 'cidade', 'id_motor', 'motorista'];
        $headers = ['name', 'email', 'password'];

        // Receber arquivo CSV e ler dados       
        $dataFile = array_map('str_getcsv', file($request->file('file')));

        $numberRegisteredRecords = 0;
        $emailAlreadyRegistered = false;

        // Percorrer dados do arquivo
        foreach($dataFile as $keyData => $row) {
            $values = explode(';',$row[0]);
            foreach($headers as $key => $header) {
                if($header == "email") {
                    if(User::where('email', $values[$key])->first()){
                        $emailAlreadyRegistered .= $values[$key] . ",";
                    }
                }

                // Verifica se a coluna é senha
                if($header == "password") {
                    // Criptografar senha
                    //$arrayValues[$keyData][$header] = Hash::make($arrayValues[$keyData]['password'],['rounds' => 12 ]);
                }

                $arrayValues[$keyData][$header] = $values[$key];

            }
        
            $numberRegisteredRecords++;

        }

        if($emailAlreadyRegistered) {
            return back()->with('error', 'E-mail já cadastrado! <br> ' . $emailAlreadyRegistered);
        };

        // Cadastrar registros no banco de dados
        User::insert($arrayValues);

        return back()->with('success', 'Dados importados com sucesso! <br>Quantidade: ' . $numberRegisteredRecords);
    }

}
