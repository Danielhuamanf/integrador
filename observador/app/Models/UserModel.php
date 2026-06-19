<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	 	protected $table = 'usuarios';
        protected $allowedFields = ['username','password','type','id_usuario','dni'];
        protected $validationRules = [
            'user' => 'required|is_unique[usuarios.username]'
        ]; 
        public function obtenerUsuario($data) {
                        $Usuario = $this->db->table('usuarios');
                        $Usuario->where($data);
                        
                        return $Usuario->get()->getResultArray();
        }
        public function insertarDatos($data){
                        $table = $this->db->table('usuarios');
                        $table->insert($data);
        }
}