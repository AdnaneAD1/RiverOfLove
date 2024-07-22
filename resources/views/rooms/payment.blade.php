<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="stylesheet" href="{{ asset('assets/css/payment.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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
    <nav style="box-shadow: 0 0px 8px rgba(0, 0, 0, 0.1);">
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
            <li><a href="/#noschambre">Nos chambres</a></li>
            <li><a href="/contact">Contactez-nous</a></li>
        </ul>
        <a href="/roomlist"><button class="btn nav__btn">Réserver Maintenant</button></a>

    </nav>
    <span id="reserved-dates" style="display: none;">{{ json_encode($reservedDates) }}</span>
    <span id="room-price-per-night" style="display: none;">{{ $roomPricePerNight }}</span>
    <div class="bg-white p-8 rounded-lg w-full max-w-6xl mx-auto form-payement">
        <div class="flex flex-col md:flex-row space-y-8 md:space-y-0 md:space-x-8 items-center">
            <div class="w-full md:w-1/2">
                <img src="{{ asset('/assets/img/10798780_4556381.svg') }}" alt="Image de Réservation" class="w-full h-auto">
            </div>
            <div class="w-full md:w-1/2 bg-white p-8 rounded-lg shadow-lg">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <h2 class="text-center text-2xl font-bold mb-6">Faites votre réservation maintenant</h2>
                <form id="reservation-form" method="POST" action="{{ route('reservation') }}">
                    @csrf
                    <div class="space-y-4" id="reservation-form-fields">
                        <div>
                            <label for="date-range" class="block text-sm font-medium text-gray-700">Date Range</label>
                            <input type="text" id="date-range" name="date_range" placeholder="Y-m-d to Y-m-d" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-chocolate">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                            <input type="email" id="email" name="email" placeholder="email" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-chocolate">
                        </div>
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" id="nom" name="nom" placeholder="nom" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-chocolate">
                        </div>
                        <div>
                            <label for="prenom" class="block text-sm font-medium text-gray-700">Prenom</label>
                            <input type="text" id="prenom" name="prenom" placeholder="prenom" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-chocolate">
                        </div>
                        <div>
                            <label for="tel" class="block text-sm font-medium text-gray-700">Numéro</label>
                            <input type="text" id="tel" name="tel" placeholder="Contact" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-chocolate">
                        </div>
                        <div>
                            <label for="adults" class="block text-sm font-medium text-gray-700">Adults</label>
                            <input type="number" id="adults" name="adults" value="1" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-chocolate">
                        </div>
                        <div>
                            <label for="children" class="block text-sm font-medium text-gray-700">Children</label>
                            <input type="number" id="children" name="children" value="0" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-chocolate">
                        </div>
                        <div class="flex justify-center">
                            <button type="button" style="background-color: aqua;" class="bg-chocolate text-white font-bold py-2 px-4 rounded-md hover:bg-dark-chocolate focus:outline-none focus:ring-2 focus:ring-chocolate focus:ring-offset-2" id="next-step">Next Step</button>
                        </div>
                    </div>

                    <div class="space-y-4" id="payment-details" style="display: none;">
                        <div>
                            <label for="montant" class="block text-sm font-medium text-gray-700">Montant total à payer:
                                <span id="amount-value"></span>€</label>
                        </div>
                        <div>
                            <label for="payment-method" class="block text-sm font-medium text-gray-700">Méthode de
                                paiement: </label>
                            <select id="payment-method" name="payment_method" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-chocolate">
                                <option value="">Sélectionner la méthode</option>
                                <!-- <option value="paypal">PayPal</option> -->
                                <option value="fedapay">FedaPay</option>
                            </select>
                        </div>
                        <div id="fedapay-fields" style="display: none;">
                            <div>
                                <label for="fedapay-country" class="block text-sm font-medium text-gray-700">Pays</label>
                                <select id="fedapay-country" name="fedapay_country" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-chocolate">
                                    <option value="">Sélectionner le pays</option>
                                    <option value="BJ">Bénin</option>
                                    <option value="BF">Burkina Faso</option>
                                    <option value="CI">Côte d'Ivoire</option>
                                    <option value="GW">Guinée-Bissau</option>
                                    <option value="ML">Mali</option>
                                    <option value="NE">Niger</option>
                                    <option value="SN">Sénégal</option>
                                    <option value="TG">Togo</option>
                                </select>
                            </div>
                            <div>
                                <label for="fedapay-phone" class="block text-sm font-medium text-gray-700">Numéro de
                                    téléphone</label>
                                <input type="text" id="fedapay-phone" name="fedapay_phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-chocolate">
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="bg-chocolate text-white font-bold py-2 px-4 rounded-md hover:bg-dark-chocolate focus:outline-none focus:ring-2 focus:ring-chocolate focus:ring-offset-2" id="payment-submit">Payment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <footer class="footer" id="contact" style="margin-top:0px;">
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

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script JS -->

</body>

</html>
