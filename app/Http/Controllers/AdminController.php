<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function dashbord()
    {

        if (!Auth::user()) {
            Auth::logout();
            return redirect()->route('login');
        }
        // Réservation de la semaine précédente
        $previousWeekReservation = Reservation::whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();

        // Réservation de cette semaine
        $currentWeekReservation = Reservation::whereBetween('created_at', [now()->subWeek(), now()])->count();

        // Calculer le pourcentage de croissance
        if ($previousWeekReservation > 0) {
            $percentageGrowth = (($currentWeekReservation - $previousWeekReservation) / $previousWeekReservation) * 100;
        } else {
            $percentageGrowth = 0; // Ou toute autre valeur appropriée
        }
        // Récupérer toutes les réservations avec les champs nécessaires et la jointure sur les noms des chambres
        $reservations = Reservation::select('reservation.id', 'reservation.check_in', 'reservation.check_out', 'reservation.amount', 'reservation.room_id', 'reservation.nom', 'reservation.prenom', 'room.name as room_name')
            ->join('room', 'reservation.room_id', '=', 'room.id')
            ->orderBy('reservation.created_at', 'desc') // Trier par la colonne created_at en ordre décroissant
            ->get();

        // Calculer le nombre total de clients
        $totalClients = Reservation::distinct('email')->count('email');

        // Calculer le montant total payé
        $totalAmountPaid = round(Reservation::sum('amount'));

        // Calculer le nombre de chambres disponibles
        $totalRooms = Room::count();
        $reservedRooms = Reservation::distinct('room_id')->count('room_id');
        $availableRooms = $totalRooms - $reservedRooms;

        // Récupérer les nouvelles réservations et les chambres réservées
        $newReservations = Reservation::where('created_at', '>=', now()->subDay())->count();
        $roomsReserved = Reservation::distinct('room_id')->count('room_id');

        // Montant total payé aujourd'hui
        $totalAmountPaidToday = round(Reservation::whereDate('created_at', '>=', now()->subDay())->sum('amount'));

        // Préparer les données pour les graphiques
        $dailySales = Reservation::selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view(
            'admin/dashbord',
            compact(
                'percentageGrowth',
                'currentWeekReservation',
                'reservations',
                'totalClients',
                'totalAmountPaid',
                'availableRooms',
                'newReservations',
                'roomsReserved',
                'totalAmountPaidToday',
                'dailySales'
            )
        );
    }

    public function deconnexion()
    {
        if (Auth::user()) {
            Auth::logout();
        }
        return redirect()->route('login');
    }

    public function createadmin()
    {
        if (Auth::check()) {
            return view('admin.registeradmin');
        } else {
            Auth::logout();
            return redirect()->route('login');
        }
    }

    public function addadmin(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($request->password === $request->confirm_password) {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $user->save();

            return redirect()->route('createadmin')->with('sucess', 'Administrateur bien enregistré.');
        } else {
            return redirect()->route('createadmin')->with('error', 'Les mots de passe ne correspondent pas.');
        }
    }
}
