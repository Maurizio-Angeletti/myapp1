<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Shield\Authorization\GroupModel;

class UserController extends Controller
{
    protected $userModel;
    protected $db;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('users/index', $data);
    }

    public function create()
    {
        return view('users/create');
    }

    public function store()
    {
        // Valida i dati
        $validationRules = [
            'username' => 'required|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'group'    => 'required|max_length[255]'
        ];

        // if (!$this->validate($validationRules)) {
        //     return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        // }

        $userData = [
            'username' => $this->request->getPost('username'),
            'active'   => '1',
        ];

        $this->userModel->save($userData);

        $userId = $this->userModel->getInsertID();
        $password = $this->request->getPost('password');
        $group = $this->request->getPost('group');

        $identityData = [
            'user_id' => $userId,
            'type'    => 'email_password',
            'secret'    => $this->request->getPost('email'),
            'secret2'  => password_hash($password, PASSWORD_DEFAULT),
        ];

        $this->db->table('auth_identities')->insert($identityData);

        $groupData = [
            'user_id' => $userId,
            'group'   => $group,
        ];

        $this->db->table('auth_groups_users')->insert($groupData);

        return redirect()->to('/users')->with('success', 'Utente creato con successo!');
    }

    public function edit($id)
{
    $user = $this->userModel->find($id);

    // Ottieni tutti i gruppi disponibili
    $groups = [ 'user','admin', 'developer','super admin']; // Adatta questa lista ai tuoi gruppi
    return view('users/edit', ['user' => $user, 'groups' => $groups]);
}
    public function update($id)
    {
        $validationRules = [
            'username' => 'required|min_length[3]|max_length[30]',
            'email'    => 'required|valid_email',
            'group'    => 'required|max_length[255]'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'id'       => $id,
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        $this->userModel->save($userData);

        $identityData = [
            'secret'   => $this->request->getPost('email'),
            'secret2' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        $this->db->table('auth_identities')->where('user_id', $id)->where('type', 'email_password')->update($identityData);

        $group = $this->request->getPost('group');
        $this->db->table('auth_groups_users')->where('user_id', $id)->update(['group' => $group]);

        return redirect()->to('/admin/users')->with('success', 'Utente aggiornato con successo!');
    }

    public function delete($id)
    {
        $this->db->table('auth_groups_users')->where('user_id', $id)->delete();
        $this->db->table('auth_identities')->where('user_id', $id)->delete();
        $this->userModel->delete($id);

        return redirect()->to('/users')->with('success', 'Utente eliminato con successo!');
    }

   

    public function addUserToGroup($userId, $groupName)
    {
        
        // Trova l'utente specificato
        $user = $this->userModel->find($userId);

        if ($user) {
            // Collega al database
            $db = Config::connect();
            $builder = $db->table('auth_groups_users');

            // Inserisci direttamente l'utente nel gruppo senza fare riferimento alla tabella 'auth_groups'
            $builder->insert([
                'user_id' => $userId,
                'group' => $groupName,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            return "Utente aggiunto con successo al gruppo $groupName.";
        } else {
            return "Utente non trovato.";
        }
    }

    public function groups($userId)
    {
        $user = $this->userModel->find($userId);
        return view("\User\groups", ["user" => $user]);
    }
}
