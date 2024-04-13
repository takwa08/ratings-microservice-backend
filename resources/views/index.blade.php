<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/aadee783c9.js" crossorigin="anonymous"></script>
    <title>Formulaire d'avis</title>
</head>
    <body>
        <div class="container">
        {{-- Section d'ajout de commentaire --}}
            <section id="add-review">
                <p class="title">Laissez votre avis sur ce produit</p>

                <form action="/store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="first-row">
                        {{-- Email --}}
                        <div class="col-5">
                            <input type="text" name="email" placeholder="Email" value="{{ old('email') }}">

                            @error('email')
                                <div class="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Pseudo --}}
                        <div class="col-5">
                            <input type="text" name="nickname" placeholder="Pseudo" value="{{ old('nickname') }}">

                            @error('nickname')
                                <div class="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="second-row">
                        {{-- Note --}}
                        <div class="col-5">
                            <input type="number" name="rating" min="1" max="5" placeholder="Note sur 5" value="{{ old('rating') }}">

                            @error('rating')
                                <div class="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Upload d'image --}}
                        <div class="col-5">
                            <label for="image" class="file-label"><small>Ajouter une photo</small></label>
                            <input type="file" src="image" alt="image" name="image" value="{{ old('image') }}">
                            @error('image')
                                <div class="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Commentaire --}}
                    <div>
                        <textarea name="comment" cols="30" rows="7" placeholder="Votre commentaire">{{ old('comment') }}</textarea>
                        @error('comment')
                            <div class="alert">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <input type="submit" value="Envoyer">
                </form>
            </section>

            {{-- Section de la liste des commentaires --}}
            <section id="reviewsList">
                <p class="title">
                    <span id="review-title">Tous les avis</span> 
                    ({{ $reviewsCollection->count() }})
                </p>

                {{-- Filtre des avis --}}
                <div class="filter-reviews">
                    
                    <ul>
                        <div class="top-container">
                            <li class="title-filter-reviews">Note moyenne : 
                                @for ($i = 0; $i < round($averageRating, 1); $i++) <i class="fa-solid fa-star"></i>@endfor 
                                <span class="average">{{round($averageRating, 1)}}</span> / 5
                            </li>

                            <div class="dropdown">
                                <button class="dropbtn">Trier par :</button>
                                <div class="dropdown-content">
                                <a href="{{route ('index', ['sortby' => 'recent']) }}">Les plus récents</a>
                                <a href="{{route ('index', ['sortby' => 'old']) }}">Les plus anciens</a>
                                <a href="{{route ('index', ['sortby' => 'best']) }}">Meilleurs notes</a>
                                <a href="{{route ('index', ['sortby' => 'worst']) }}">Moins bonnes notes</a>
                                </div>
                              </div>

                        </div>

                        <li>
                            <a href="{{route('index')}}">
                                <span id="all-reviews" class="bold filter-hover">Toutes les notes</span> 
                            </a>
                        </li>

                        <li>
                            <a id="five-stars" class="filter-hover" href="{{route('index', ['stars' => 5 ])}}">
                                <span>5</span> 
                                @for ($i = 0; $i < 5; $i++) <i class="fa-solid fa-star"></i>@endfor 
                            </a>
                        </li>

                        <li>
                            <a id="four-stars" class="filter-hover" href="{{route('index', ['stars' => 4 ])}}">
                                <span>4</span> @for ($i = 0; $i < 4; $i++) <i class="fa-solid fa-star"></i>@endfor
                            </a>
                        </li>

                        <li>
                            <a id="three-stars" class="filter-hover" href="{{route('index', ['stars' => 3 ])}}">
                                <span>3</span> @for ($i = 0; $i < 3; $i++) <i class="fa-solid fa-star"></i>@endfor
                            </a>
                        </li>

                        <li>
                            <a id="two-stars" class="filter-hover" href="{{route('index', ['stars' => 2 ])}}">
                                <span>2</span> @for ($i = 0; $i < 2; $i++) <i class="fa-solid fa-star"></i>@endfor
                            </a>
                        </li>
                        
                        <li>
                            <a id="one-star" class="filter-hover" href="{{route('index', ['stars' => 1 ])}}">
                                <span>1</span> @for ($i = 0; $i < 1; $i++) <i class="fa-solid fa-star"></i>@endfor
                            </a>
                        </li>
                    </ul>
                </div>
                
                {{-- Listing des avis --}}
                @foreach ($reviewsCollection as $review)
                    <div class="review-container">
                        <div class="nickname-date">
                            <span class="bold ">{{$review->nickname}}</span>
                            <span class="date">Ajouté le : {{ \Carbon\Carbon::parse($review->created_at)->format('d/m/Y')}}</span>
                        </div>
                        <span>
                            @for ($i = 0; $i < $review->rating ; $i++)
                                <i class="fa-solid fa-star"></i> 
                            @endfor
                            {{$review->rating}}.0
                        </span>
                        <p class="comment-text">{{$review->comment}}
                            <img src="{{ asset('images/' . $review->image) }}" alt="image">
                        </p>
                    </div>
                    <div class="border-bottom"></div>
                @endforeach
            </section>
        </div>
        <script src="{{ asset('/js/app.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    </body>
</html>