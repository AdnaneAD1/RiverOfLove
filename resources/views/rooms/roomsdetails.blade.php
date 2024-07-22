<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>River Of Love</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/styles2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/templatemo-villa-agency.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <!--

TemplateMo 591 villa agency

https://templatemo.com/tm-591-villa-agency

-->
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    <nav>
        <div class="nav__bar">
            <div class="logo">
                <a href="/"><img src="{{ asset('assets/img/logo-river-removebg-preview (2).png') }}" alt="logo" style="font-size: 30px;" /></a>
            </div>
            <div class="nav__menu__btn" id="menu-btn">
                <i class="ri-menu-line"></i>
            </div>
        </div>
        <ul class="nav__links" id="nav-links">
            <li><a href="/">Acceuil</a></li>
            <li><a href="/#about">A propos</a></li>
            <li><a href="/#service">Nos Services</a></li>
            <li><a href="/roomlist">Nos chambres</a></li>
            <li><a href="/contact">Contactez-nous</a></li>
        </ul>
        <a href="/roomlist"><button class="btn nav__btn">Réserver Maintenant</button></a>

    </nav>
    <header class="header">

        <div class="section__container header__container">
            <div class="page-heading header-text">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <span class="breadcrumb"><a href="#">Accueil</a> / Description</span>
                            <h3>Description</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->



    <!-- Donner les dates dates de réservation et le prix au script -->
    <!-- Ajoutez ces éléments cachés dans la vue HTML -->
    <span id="reserved-dates" style="display: none;">{{ json_encode($reservedDates) }}</span>
    <span id="room-price-per-night" style="display: none;">{{ $roomPricePerNight }}</span>
    <div class="single-property section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="main-image">
                        <img src="{{ asset('assets/img/' . $room->main_image) }}" alt="">
                    </div>
                    <div class="main-content">
                        <h5><span class="category">
                                <h5>{{ $room->name }}</h5>
                            </span> {{ $room->amount }} €</h5>
                        <h5><br><br>Description</h5>
                        <p>
                            {{ $room->description }}
                        </p>
                    </div>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button large-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="border: none; background-color: white;">
                                    Quelques images de la chambre
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @foreach($room->images as $image)
                                    <img src="{{ asset('assets/img/' . $image) }}" alt="{{ $room->name }}"> <br><br>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <a href="/payment">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="large-button btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="border: none; background-color: chocolate; color:white;" id="reva">
                                        Cliquez ici pour réserver

                                    </button>
                                </h2>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="info-table">
                        <ul>
                            @foreach ($room->facilities as $facility => $data)
                            <li>
                                <i class="{{ $data['icon'] }}"> <span style="font-family: Arial, sans-serif;">{{ $facility }}</span></i>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer" id="contact">
        <div class="section__container footer__container">
            <div class="footer__col">
                <div class="logo">
                    <a href="#home"><img src="{{ asset('assets/img/logo-river.png') }}" alt="logo" /></a>
                </div>
                <p class="section__description">
                    Découvrez un monde de confort, de luxe et d'aventure en explorant nos chambres soigneusement concu
                    pour vous.
                </p>

            </div>
            <div class="footer__col">
                <h4>Liens rapides</h4>
                <ul class="footer__links">
                    <li><a href="#">Acceuil</a></li>
                    <li><a href="#">Nos chambres</a></li>
                </ul>
            </div>
            <div class="footer__col">
                <h4>NOS SERVICES</h4>
                <ul class="footer__links">

                    <li><a href="#">Assistance Concierge</a></li>
                    <li><a href="#">Options de Réservation Flexibles</a></li>
                    <li><a href="#">Bien-être & Loisirs</a></li>

                </ul>
            </div>
            <div class="footer__col">
                <h4>CONTACTEZ-NOUS</h4>
                <ul class="footer__links">
                    <li><a href="#">contact@riveroflove-residence.com</a></li>
                </ul>
                <div class="footer__socials">
                    <a href="#"><img src="{{ asset('assets/img/facebook.png') }}" alt="facebook" /></a>
                    <a href="#"><img src="{{ asset('assets/img/instagram.png') }}" alt="instagram" /></a>
                    <a href="#"><img src="{{ asset('assets/img/youtube.png') }}" alt="youtube" /></a>
                    <a href="#"><img src="{{ asset('assets/img/twitter.png') }}" alt="twitter" /></a>
                </div>
            </div>
        </div>
        <div class="footer__bar">
            Copyright © 2024 River Of Land. All rights reserved.
        </div>
    </footer>
    <!-- Scripts -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('assets/js/counter.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js')}} "></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="{{ asset('assets/js/main.js')}}"></script>

</body>

</html>
