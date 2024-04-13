<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReviewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Fonction qui permet de renvoyer la page du formulaire avec la collection d'avis
    public function index(Request $request)
    {
        if ($request->stars){
            $reviewsCollection = DB::table('reviews')
                         ->where('rating', '=', $request->stars)
                         ->orderBy('created_at', 'DESC')
                         ->get();
        }
        else if ($request->sortby == 'old'){
            $reviewsCollection = DB::table('reviews')
                                ->orderBy('created_at', 'ASC')
                                ->get();
        }
        else if ($request->sortby == 'best'){
            $reviewsCollection = DB::table('reviews')
                                ->orderBy('rating', 'DESC')
                                ->get();
        }
        else if ($request->sortby == 'worst'){
            $reviewsCollection = DB::table('reviews')
                                ->orderBy('rating', 'ASC')
                                ->get();
        }
        else{
            $reviewsCollection = DB::table('reviews')
                                ->orderBy('created_at', 'DESC')
                                ->get();
        }

        $averageRating = DB::table('reviews')
                        ->avg('rating');

        return view('index', ['reviewsCollection' => $reviewsCollection, 'averageRating' => $averageRating]);
    }

    // Fonction qui permet de persister les informations du formulaire d'avis en base de données
    public function store(Request $request)
    {
        // Vérification des champs
        $validated = $request->validate([
            'email' => 'required|max:255|email',
            'nickname' => 'required|max:50',
            'rating' => 'required|min:1|max:5|integer',
            'image' => 'image|mimes:jpg,png,jpeg|max:5048',
            'comment' => 'required'
        ]);

        // Renommage de l'image
        $newImageName = time() . '-' . $request->nickname . '.' . $request->image->extension();

        // Déplacement de l'image dans le dossier public/images
        $request->image->move(public_path('images'), $newImageName);

        // Sauvegarde des données en base de données
        $review = Review::create([
            'email' => $request->email,
            'nickname' => $request->nickname,
            'rating' => $request->rating,
            'image' => $newImageName,
            'comment' => $request->comment
        ]);

        // Redirection vers la page du formulaire
        return redirect('/');
    }
}
