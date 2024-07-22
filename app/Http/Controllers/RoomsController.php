<?php

namespace App\Http\Controllers;

use App\Models\Room;
use FedaPay\FedaPay;
use Omnipay\Omnipay;
use FedaPay\Customer;
use FedaPay\Transaction;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Mail\ContactMarkdownMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendContactMarkdownMail;
use App\Mail\ReservationMarkdownMail;
use Illuminate\Support\Facades\Session;
use App\Jobs\SendReservationMarkdownMail;

class RoomsController extends Controller
{
    public function indexpage()
    {
        return view('welcome');
    }

    // liste des chambres
    public function roomlist()
    {
        return view('rooms/roomslist');
    }

    // public function roomlist2()
    // {
    //     $id = Session::get('id');
    //     $room = Room::findOrFail($id);
    //     // Récupéretion des dates de réservation
    //     $reservations = Reservation::where('room_id', $id)
    //         ->select('check_in', 'check_out')
    //         ->get();

    //     $reservedDates = [];
    //     foreach ($reservations as $reservation) {
    //         $period = new \DatePeriod(
    //             new \DateTime($reservation->check_in),
    //             new \DateInterval('P1D'),
    //             (new \DateTime($reservation->check_out))->modify('+1 day')
    //         );

    //         foreach ($period as $date) {
    //             $reservedDates[] = $date->format('Y-m-d');
    //         }
    //     }

    //     // Récupérer le prix par nuit de la chambre
    //     $roomPricePerNight = $room->amount;
    //     return view('rooms/payment', compact('reservedDates', 'roomPricePerNight'));
    // }

    public function roomdetails($id)
    {
        // Récupérer les informations de la chambre depuis la base de données
        $room = Room::findOrFail($id);
        Session::put('id', $id);

        // Récupéretion des dates de réservation
        $reservations = Reservation::where('room_id', $id)
            ->select('check_in', 'check_out')
            ->get();

        $reservedDates = [];
        foreach ($reservations as $reservation) {
            $period = new \DatePeriod(
                new \DateTime($reservation->check_in),
                new \DateInterval('P1D'),
                (new \DateTime($reservation->check_out))->modify('+1 day')
            );

            foreach ($period as $date) {
                $reservedDates[] = $date->format('Y-m-d');
            }
        }

        // Récupérer le prix par nuit de la chambre
        $roomPricePerNight = $room->amount;

        // Passer les données à la vue
        return view('rooms/roomsdetails', compact('room', 'reservedDates', 'roomPricePerNight'));
    }

    // contact
    public function contact()
    {
        return view('rooms/contact');
    }

    // Générer un identifiant unique
    private function generateUniqueID($length = 10)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // Réservation et paiment
    public function store(Request $request)
    {
        $request->validate([
            'date_range' => 'required|string',
            'email' => 'required|email',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'tel' => 'required|string|max:20',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
            'payment_method' => 'required|string',
            'fedapay_phone' => 'required_if:payment_method,==,fedapay|nullable|string',
            'fedapay_country' => 'required_if:payment_method,==,fedapay|nullable|string|max:2',
        ]);

        // Récupération id de la session
        $room_id = Session::get('id');
        // Calcul du total amount
        $dateRange = explode(' to ', $request->date_range);
        $check_in = new \DateTime($dateRange[0]);
        $check_out = new \DateTime($dateRange[1]);
        $daysDifference = $check_out->diff($check_in)->days;

        $room = Room::find($room_id); // Récupérer l'instance du modèle Room
        $roomPricePerNight = $room->amount; // Accéder à la propriété amount

        $totalAmount = $daysDifference * $roomPricePerNight;

        // Conversion
        $tauxDeConversion = 655.957; // Taux de conversion fixe
        $totalAmountXOF = $totalAmount * $tauxDeConversion;

        do {
            $ID_reservation = $this->generateUniqueID();
        } while (Reservation::where('id', $ID_reservation)->exists());

        // Création de la réservation
        $reservation = new Reservation([
            'id' => $ID_reservation,
            'check_in' => $check_in,
            'check_out' => $check_out,
            'email' => $request->email,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'tel' => $request->tel,
            'adults' => $request->adults,
            'children' => $request->children,
            'payment_method' => $request->payment_method,
            'amount' => $totalAmount,
            'room_id' => $room_id,
        ]);

        $paymentMethod = $request->payment_method;
        // $response = null;

        // if ($paymentMethod == 'paypal') {
        //     // PayPal payment
        //     $response = $this->gateway->purchase([
        //         'amount' => $totalAmount,
        //         'currency' => 'EUR',
        //         'returnUrl' => route('payment.success', [$reservation]),
        //         'cancelUrl' => route('payment.cancel'),
        //     ])->send();

        //     if ($response->isRedirect()) {
        //         return $response->redirect(); // Redirect de PayPal pour le paiement
        //     } else {
        //         return response()->json(['error' => $response->getMessage()], 400);
        //     }
        // } else
        if ($paymentMethod == 'fedapay') {

            // FedaPay payment
            FedaPay::setApiKey(config('fedapay.secret_key'));
            FedaPay::setEnvironment(config('fedapay.environment'));

            try {
                $transaction = Transaction::create([
                    'description' => 'Paiement de réservation',
                    'amount' => $totalAmountXOF, // Montant en XOF
                    'currency' => ['iso' => 'XOF'],
                    'customer' => [
                        'firstname' => $request->prenom,
                        'lastname' => $request->nom,
                        'email' => $request->email,
                        'phone_number' => [
                            'number' => $request->fedapay_phone, // Numéro au format international
                            'country' => $request->fedapay_country // Code ISO du pays
                        ]
                    ],
                ]);

                $transaction->sendNow();
                // Enregistrement des informations de réservation dans la base de données
                if ($transaction->status == 'approved') {
                    $mailabler = new ReservationMarkdownMail($reservation->email, $reservation->id, $reservation->nom);
                    Mail::to($reservation->email)->send($mailabler);
                    // Enregistrer la réservation dans la base de données
                    $reservation->save();
                    return redirect()->route('payment')->with('success', 'Votre paiement a été traité avec succès.');
                } else {
                    // Gérer les autres statuts de transaction (pending, declined, etc.)
                    return redirect()->route('payment')->with('error', 'La transaction est en attente de validation.');
                }
            } catch (\Exception $e) {
                return redirect()->route('payment')->with('error', 'Une erreur est survenue : ' . $e->getMessage());
            }
        }
    }

    public function paymentSuccess($reservation)
    {
        // payment success et sauvegarde reservation
        $mailabler = new ReservationMarkdownMail($reservation->email, $reservation->id, $reservation->nom);
        Mail::to($reservation->email)->send($mailabler);
        $reservation->save();
        return redirect()->route('payment')->with('success', 'Votre paiement a été traité avec succès.');
    }

    public function paymentCancel()
    {
        return redirect()->route('payment')->with('error', 'Votre paiement a été annulé.');
    }
    public function makePayment()
    {
        $id = Session::get('id');
        $room = Room::findOrFail($id);
        // Récupéretion des dates de réservation
        $reservations = Reservation::where('room_id', $id)
            ->select('check_in', 'check_out')
            ->get();

        $reservedDates = [];
        foreach ($reservations as $reservation) {
            $period = new \DatePeriod(
                new \DateTime($reservation->check_in),
                new \DateInterval('P1D'),
                (new \DateTime($reservation->check_out))->modify('+1 day')
            );

            foreach ($period as $date) {
                $reservedDates[] = $date->format('Y-m-d');
            }
        }

        // Récupérer le prix par nuit de la chambre
        $roomPricePerNight = $room->amount;
        return view('rooms/payment', compact('reservedDates', 'roomPricePerNight'));
    }

    public function contactform(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|email',
            'subject' => 'required|min:3',
            'message' => 'required|min:10',
        ]);
        $mailablec = new ContactMarkdownMail($request->name, $request->email, $request->subject, $request->message);
        try {
            // Envoyer la tâche à la file d'attente
            Mail::to('riverofland@contact.bj')->send($mailablec);
            return redirect()
                ->back()
                ->with('success', 'Votre message a bien été transféré.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'envoi du message, veillez recommencer plus tard.');
        }
    }
}
