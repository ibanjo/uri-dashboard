<?php

namespace App\Http\Controllers;

use App\Mobility as Mobility;
use App\MobilityStatus;
use App\UniversityBranch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Country as Country;
use App\Semester as Semester;
use App\User as User;
use JavaScript;
use View;

class MobilityController extends Controller
{
    use CreatesModels;

    public function createNewMobility(Request $request)
    {
        $data = $request->all();
        $mobility = $this->newMobility($data);

        return response([
            'status' => 'success',
            'message' => 'Mobilità registrata con successo! Stiamo tornando alla pagina dell\'utente',
            'mobility' => $mobility,
            'redirect' => route('view.user', ['id' => $data['user_id']])
        ], 200);
    }

    public function changeMobilityStatus(Request $request)
    {
        $data = $request->all();
        $mobility = Mobility::find($data['id']);
        $mobility->mobility_status_id = $data['new_status_id'];
        $mobility->save();
        return response([
            'status' => 'success',
            'message' => 'Stato della mobilità correttamente aggiornato'
        ], 200);
    }

    public function editMobility(Request $request)
    {
        $data = $request->all();
        $mobility = Mobility::find($data['id']);
        foreach (array_keys($data) as $key) {
            if(in_array($key, ['estimated_in', 'estimated_out', 'acknowledged_in', 'acknowledged_out']))
                $mobility[$key] = Carbon::createFromFormat('d-m-Y', $data[$key]);
            else
                $mobility[$key] = $data[$key];
        }
        $mobility->save();
        return response([
            'status' => 'success',
            'message' => 'Mobilità aggiornata correttamente'
        ], 200);
    }

    public function abortMobility(Request $request)
    {
        $data = $request->all();
        $mobility = Mobility::find($data['id']);
        $mobility->abortion_notes = $data['message'];
        $mobility->mobility_status_id = 7; // FIXME ugly, need to add an English lowercase identifier and use a query
        $mobility->save();
        return response([
            'status' => 'success',
            'message' => 'Mobilità chiusa correttamente',
            'redirect' => route('view.allusers')
        ], 200);
    }
}
