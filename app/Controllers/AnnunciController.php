<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AnnunciModel;

class AnnunciController extends BaseController
{

    protected $annunci;
    protected $db;
    protected $data = [];



    public function __construct()
    {
        $this->annunci = new AnnunciModel();
        $this->db = db_connect();
    }

    public function index()
    {

        $annunci = $this->annunci->findAll();
       

        $this->db = db_connect();

        return view('annunci/index',['annunci'=>$annunci]);
    }


    public function new()
    {
        //  // Verifica se l'utente è loggato
        //  if (!session()->get('logged_in')) {
        //     return redirect()->to('/login')->with('error', 'Devi essere loggato per accedere a questa pagina.');
        // }

        // // Verifica se l'utente appartiene ai gruppi 'auth' o 'developer'
        // $userGroup = session()->get('group'); // Recupera il gruppo dell'utente dalla sessione

        // if ($userGroup !== 'auth' && $userGroup !== 'developer') {
        //     return redirect()->to('/')->with('error', 'Non hai i permessi per accedere a questa pagina.');
        // }

        // Mostra la vista se i controlli sono superati
        return view('annunci/new');
    }

    public function create()
    {
        $data = [
            'titolo' => $this->request->getPost('titolo'),
            'descrizione' => $this->request->getPost('descrizione'),
            'prezzo' => $this->request->getPost('prezzo'),
        ];

        // Inserisci i dati nella tabella 'annunci'
        $this->db->table('annunci')->insert($data);

        // Reindirizza alla pagina degli annunci con un messaggio di successo
        return redirect()->to('/annunci/index')->with('success', 'Annuncio creato con successo!');
    }
}
