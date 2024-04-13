// Déclaration des variables pour intéragir avec le DOM
const reviewTitle = document.getElementById('review-title');

let fiveStars = document.getElementById('five-stars');
let fourStars = document.getElementById('four-stars');
let threeStars = document.getElementById('three-stars');
let twoStars = document.getElementById('two-stars');
let oneStar = document.getElementById('one-star');
let allReviews = document.getElementById('all-reviews');

// Récupération de la valeur en GET de 'stars'
const queryString = window.location.search;

const urlParams = new URLSearchParams(queryString);

const urlValue = urlParams.get('stars');

// Modification du titre des avis selon le paramètre en GET et modification des class pour le frontend

switch (urlValue) {
    case '5' :
        reviewTitle.innerHTML = "Tous les avis 5 étoiles";
        fiveStars.classList.add('filter-border');
        fiveStars.classList.remove('filter-hover');
        break;

    case '4' :
        reviewTitle.innerHTML = "Tous les avis 4 étoiles";
        fourStars.classList.add('filter-border');
        fourStars.classList.remove('filter-hover');
        break;

    case '3' :
        reviewTitle.innerHTML = "Tous les avis 3 étoiles";
        threeStars.classList.add('filter-border');
        threeStars.classList.remove('filter-hover');
        break;

    case '2':
        reviewTitle.innerHTML = "Tous les avis 2 étoiles";
        twoStars.classList.add('filter-border');
        twoStars.classList.remove('filter-hover');
        break;

    case '1':
        reviewTitle.innerHTML = "Tous les avis 1 étoile";
        oneStar.classList.add('filter-border');
        oneStar.classList.remove('filter-hover');
        break;

    default:
        reviewTitle.innerHTML = "Tous les avis";
        allReviews.classList.add('filter-border');
        allReviews.classList.remove('filter-hover');
        break;
}