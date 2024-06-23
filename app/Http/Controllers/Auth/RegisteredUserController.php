<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Filiere;
use App\Models\Site;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\Exception\ReaderException;





class RegisteredUserController extends Controller
{
    
   
    /**
     * Affiche la vue d'enregistrement.
     */
    public function create($encryptedData)
    {
        try {
            // Décrypter les données
            $data = Crypt::decrypt($encryptedData);

            // Valider les données décryptées
            if (!isset($data['role']) || !isset($data['promotion'] )) {
                abort(404, 'Données d\'enregistrement invalides.');
            }  

            // Récupérer les informations nécessaires
            $role = $data['role'];
            $promotion = $data['promotion'];
            if (isset($data['diplome'])) {
                $diplome = $data['diplome'];
            }else{
                $diplome= null;
            }
            

            $filieres = Filiere::all();
            $sites = Site::all();

            // Retourner la vue d'enregistrement avec les données nécessaires
            return view('auth.register', compact('encryptedData', 'role', 'filieres', 'sites', 'promotion','diplome'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            Log::error('Échec du décryptage des données d\'enregistrement', ['error' => $e->getMessage()]);
            abort(404); // Gérez l'erreur comme vous le souhaitez
        }
    }

    /**
     * Traite une demande d'inscription entrante.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request): RedirectResponse
{
    // Validation des données du formulaire
    $validatedData = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'id_role' => ['required', 'integer', 'exists:roles,id'],
        'id_site' => ['integer', 'exists:sites,id'],
        'id_filiere' => ['integer', 'exists:filieres,id'],
        'id_promotion' => ['required', 'integer', 'exists:promotions,id'],
        'id_diplome' => ['integer', 'exists:type_diplomes,id'],
        'phone' => ['sometimes', 'string'],
        'encryptedData' => ['required', 'string'],
        'matricule' => ['integer'],
      
    ]);

    // Vérifier si le rôle de l'utilisateur est 'étudiant' (id rôle = 2)
    if ($request->id_role == 2) {
        $filiere= filiere::findorfail($request->id_filiere);
        $site=Site::findorfail($request->id_filiere);

     // Vérification si l'utilisateur est préinscrit dans le fichier Excel
        $isPreRegistered = $this->checkPreRegistration($request->name, $request->matricule, $filiere->filiere, $site->site);
        // Vérifier les informations de l'étudiant
        if ($isPreRegistered) {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_role' => $request->id_role,
                'id_site' => $request->id_site,
                'id_filiere' => $request->id_filiere,
                'id_promotion' => $request->id_promotion,
                'id_diplome' => $request->id_diplome,
                'phone' => $request->phone,
                'matricule'=>$request->matricule,
            ]);

            event(new Registered($user));
            Auth::login($user);

            return redirect()->route('dashboard');

        } else {
            // Redirection vers la vue d'enregistrement avec les erreurs
            return redirect()->to('http://127.0.0.1:8000/register/eyJpdiI6IjhxT2t0eWFHdkpFT3BvU1ZDeDFIcnc9PSIsInZhbHVlIjoiNFRGaGQvM0xubmROQllyNHhKY2ZwelkrSE1KcXd1dlZTbExIWDkzd3lKeG5tSnBnZ3haQWdhcndiYUNmVEVpV2M4TDJsb2RsZ1I1K1dmRnhFMFlPaEsvRzZ4QlJBVFl4K05VZXUxUFB5ZVE9IiwibWFjIjoiNDY4Y2Q4YTkwZGY2NTc3ZGUxMDM4N2JlYzIxMDgxNmJlZDZiNTRmOTQ1MWNlM2NkZDFlZjc0YWRkYjc2N2VlMyIsInRhZyI6IiJ9')
                    ->withErrors(['message' => 'Informations incorrectes de l\'étudiant.']);
        }

    } elseif ($request->id_role == 3) {
        $isPreRegistered = $this->VerificationAutreUnser($request->name, $request->matricule ,$request->id_role);
        // Création de l'utilisateur pour les rôles autres qu'ensiagnt
        if ($isPreRegistered) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_role' => $request->id_role,
            'id_site' => $request->id_site,
            'id_filiere' => $request->id_filiere,
            'id_promotion' => $request->id_promotion,
            'phone' => $request->phone,
            'matricule'=>$request->matricule,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    } else {
        // Redirection vers la vue d'enregistrement avec les erreurs
        return redirect()->to('http://127.0.0.1:8000/register/eyJpdiI6InFkMTFJNEZHbEZ6cnc5OWVGSzE2WVE9PSIsInZhbHVlIjoiWmNpaWtBazBPV2hRTnAveE1GdzFHZWNhUFVBZXVEbE5JVEVmdXVGM09EVTFvTFRHRE9MR1pnYXdMZlRjK3llQ3p2QUF2bUNMbGV0cldJWU0zWXJPeS9nMmRLUE13UGNpd3lsUUxNQlJ5djQ9IiwibWFjIjoiYzkxMmI2MDEyMzY0NDA1YjU2YmQzNWE3MzRhMWZhNzgxZWI1YjFhZWM4MjhmZGNmNTEyMTVlNzUwNThjNzNjOSIsInRhZyI6IiJ9')
                ->withErrors(['message' => 'Informations incorrectes de l\'étudiant.']);
    }
    } else
    {
        // Création de l'utilisateur pour le rôle admin
        $isPreRegistered = $this->VerificationAutreUnser($request->name, $request->matricule,$request->id_role );
        // Création de l'utilisateur pour les rôles autres qu'ensiagnt
        if ($isPreRegistered) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_role' => $request->id_role,
            'id_site' => $request->id_site,
            'id_filiere' => $request->id_filiere,
            'id_promotion' => $request->id_promotion,
            'phone' => $request->phone,
            'matricule'=>$request->matricule,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    } else {
        // Redirection vers la vue d'enregistrement avec les erreurs
        return redirect()->to('http://127.0.0.1:8000/register/eyJpdiI6IlYyOHBLYkV4dWgvcjZQV0kwS3dETXc9PSIsInZhbHVlIjoiTFg4clUxSnY1WlVHMU5pTkovTUxyZDNXTEM0TXBOeTdteFBmc3hnVUltUWZCbE9tTmh4WFV3QzM4NktmR2RhalcycnZJeEFRYmNrNVNjLy9HOU01Z2RZL2pjTTRFQlhYQjlJOFltVHd2TVE9IiwibWFjIjoiMTY2YzZkMGVlMjdiOTAwYWIwOGY1MzM4YWU4YmY2ZmZjYzlhZWY3OTgzOTQ0OTQ3ZTkyNTA4NDJiZDNiM2MzNSIsInRhZyI6IiJ9')
                ->withErrors(['message' => 'Informations incorrectes de l\'administreur.']);
    }
    }
}
/**
     * Check if the user is already pre-registered in the Excel file.
     *
     * @param string $name
     * @param string $matricule
     * @param int $filiere
     * @param int $site
     * @return bool
     */
    private function checkPreRegistration($name, $matricule, $filiere, $site)
    {
        // Vérifier si le fichier Excel est vide
        $filePath = public_path('preinscriptionexcel\PreInscriptionsEtudiant.xlsx');
        if (filesize($filePath) === 0) {
            
            return false; // Fichier vide, renvoyer un message
            $messageErreur = "Le fichier de préinscription est vide. Veuillez télécharger le fichier et réessayer.";
            return $messageErreur;
        }
 
       
    
        // Utiliser Spout pour lire le fichier Excel
        try {
            $reader = ReaderEntityFactory::createReaderFromFile($filePath);
            $reader->open($filePath);
            $worksheetIterator = $reader->getSheetIterator();
            $worksheetIterator->rewind();
            $worksheet = $worksheetIterator->current(); // Obtenir la première feuille de calcul
    
            // Filtrer les utilisateurs pré-inscrits
            $preRegisteredUsers = [];

            foreach ($reader->getSheetIterator() as $sheet) {

                foreach ($sheet->getRowIterator() as $row) {
        
                    // Vérifier s'il y a au moins 4 colonnes avant d'accéder aux cellules (mesure de sécurité)
                    if (count($row->getCells()) < 4) {
                        continue; // Ignorer les lignes avec moins de 4 colonnes
                    }
        
                    // Comparaison efficace des valeurs en utilisant array_filter et l'opérateur ternaire
                    $isPreRegistered = array_filter([
                        $row->getCellAtIndex(0)->getValue() == $name
                        && $row->getCellAtIndex(1)->getValue() == $matricule
                        && $row->getCellAtIndex(2)->getValue() == $filiere
                        && $row->getCellAtIndex(3)->getValue() == $site
                    ]) ? "1" : "2";
        
                    $preRegisteredUsers[] = $isPreRegistered;
                }
            }
           
                
            $reader->close();
        } catch (ReaderException $e) {
            Log::error('Échec de la lecture du fichier Excel de préinscription', ['error' => $e->getMessage()]);
            return false; // Gestion d'erreur si le fichier ne peut pas être lu
        }
        if (in_array('1', $preRegisteredUsers)) {
            return true;
        } else {
            return false;
        }
    }
/**
     * Check if the user is already pre-registered in the Excel file.
     *
     * @param string $name
     * @param string $matricule
     * @param int $filiere
     * @param int $site
     * @return bool
     */
    private function VerificationAutreUnser($name, $matricule ,$role)
    {
        if ($role == 3) {
            $filePath = public_path('preinscriptionexcel\preinscriptionsenseignant.xlsx');
            if (filesize($filePath) === 0) {
                
                return false; // Fichier vide, renvoyer un message
                $messageErreur = "Le fichier de préinscription est vide. Veuillez télécharger le fichier et réessayer.";
                return $messageErreur;
            }
        } elseif($role == 1) {
            $filePath = public_path('preinscriptionexcel\PreInscriptionsaAdmin.xlsx');
            if (filesize($filePath) === 0) {
                
                return false; // Fichier vide, renvoyer un message
                $messageErreur = "Le fichier de préinscription est vide. Veuillez télécharger le fichier et réessayer.";
                return $messageErreur;
            }
        }
        
        // Vérifier si le fichier Excel est vide
     
 
       
    
        // Utiliser Spout pour lire le fichier Excel
        try {
            $reader = ReaderEntityFactory::createReaderFromFile($filePath);
            $reader->open($filePath);
            $worksheetIterator = $reader->getSheetIterator();
            $worksheetIterator->rewind();
            $worksheet = $worksheetIterator->current(); // Obtenir la première feuille de calcul
    
            // Filtrer les utilisateurs pré-inscrits
            $preRegisteredUsers = [];

            foreach ($reader->getSheetIterator() as $sheet) {

                foreach ($sheet->getRowIterator() as $row) {
        
                    // Vérifier s'il y a au moins 4 colonnes avant d'accéder aux cellules (mesure de sécurité)
                    if (count($row->getCells()) < 2) {
                        continue; // Ignorer les lignes avec moins de 4 colonnes
                    }
        
                    // Comparaison efficace des valeurs en utilisant array_filter et l'opérateur ternaire
                    $isPreRegistered = array_filter([
                        $row->getCellAtIndex(0)->getValue() == $name
                        && $row->getCellAtIndex(1)->getValue() == $matricule
                    ]) ? "1" : "2";
        
                    $preRegisteredUsers[] = $isPreRegistered;
                }
            }
         
            $reader->close();
        } catch (ReaderException $e) {
            Log::error('Échec de la lecture du fichier Excel de préinscription', ['error' => $e->getMessage()]);
            return false; // Gestion d'erreur si le fichier ne peut pas être lu
        }
        if (in_array('1', $preRegisteredUsers)) {
            return true;
        } else {
            return false;
        }
    }
    
}

