<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Traits\Viewable;
use CodeIgniter\Shield\Validation\ValidationRules;
use Psr\Log\LoggerInterface;
use CodeIgniter\Shield\Controllers\RegisterController;

/**
 * Class RegisterController
 *
 * Handles displaying registration form,
 * and handling actual registration flow.
 */
class MyRegisterController extends RegisterController
{
    use Viewable;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ): void {
        parent::initController(
            $request,
            $response,
            $logger
        );
    }

    /**
     * Displays the registration form.
     *
     * @return RedirectResponse|string
     */
    public function registerView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show');
        }

        return $this->view(setting('Auth.views')['register']);
    }

    /**
     * Attempts to register the user.
     */
    public function registerAction(): RedirectResponse
    {




        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }


        $users = $this->getUserProvider();
        // Validazione dei dati
        $rules = $this->getValidationRules();
        $rules['group'] = 'required'; // Aggiungi la regola per il gruppo


        // Salva l'utente
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));

        if ($user->username === null) {
            $user->username = null;
        }

        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        
        // Recupera l'utente appena inserito
        $user = $users->findById($users->getInsertID());
        // Assegna l'utente al gruppo selezionato
        $group = $this->request->getPost('group');
        $this->addUserToGroup($user->id, $group);
        


        Events::trigger('register', $user);

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $authenticator->startLogin($user);

        // Se esiste un'azione di registrazione, eseguila.
        $hasAction = $authenticator->startUpAction('register', $user);
        if ($hasAction) {
            return redirect()->route('auth-action-show');
        }

        // Attiva l'utente
        $user->activate();

        $authenticator->completeLogin($user);

        // Successo!
        return redirect()->to(config('Auth')->registerRedirect())
            ->with('message', lang('Auth.registerSuccess'));
    }



    /**
     * Returns the User provider
     */
    protected function getUserProvider(): UserModel
    {
        $provider = model(setting('Auth.userProvider'));

        assert($provider instanceof UserModel, 'Config Auth.userProvider is not a valid UserProvider.');

        return $provider;
    }

    /**
     * Returns the Entity class that should be used
     */
    protected function getUserEntity(): User
    {
        return new User();
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return array<string, array<string, list<string>|string>>
     */
    protected function getValidationRules(): array
    {
        $rules = new ValidationRules();

        return $rules->getRegistrationRules();
    }

    public function addUserToGroup($userId, $groupName)
    {
        // Carica il modello degli utenti
        $userModel = new UserModel();

        // Trova l'utente specificato
        $user = $userModel->find($userId);

        if ($user) {
            // Collega al database
            $db = db_connect();
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
}
