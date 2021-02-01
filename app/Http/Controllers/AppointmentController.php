<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Appointment;

class AppointmentController extends Controller
{
    /**
     * Store a new property.
     *
     * @param  Request  $request
     * @return Response
     */
    public function createAppointment(Request $request) {
         //validate incoming request 
         $this->validate($request, [
            'appointmentDate' => 'required|date', 
            'appointmentAgent' => 'required|string',
            'appointmentMotif' => 'required|string',
            'appointmentType' => 'required|integer',
            'idUser' => 'required|integer',
        ]);

        try {
           
            $appointment = new Appointment;
            $appointment->appointmentDate  = $request->input('appointmentDate');
            $appointment->appointmentAgent = $request->input('appointmentAgent');
            $appointment->appointmentMotif = $request->input('appointmentMotif');
            $appointment->appointmentType  = $request->input('appointmentType');
            $appointment->idUser           = $request->input('idUser');

            $appointment->save();

            //return successful response
            return response()->json(['appointment' => $appointment, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Appointment Registration Failed!'], 409);
        }
    }


    /**
     * Get all Properties.
     *
     * @return Response
     */
    public function allAppointment()
    {
        return response()->json(['appointment' =>  Appointment::all()], 200);
    }

    /**
     * Get one property.
     *
     * @return Response
     */
    public function singleAppointment($idAppointment)
    {
        try {
            $appointment = Appointment::findOrFail($idAppointment);

            return response()->json(['appointment' => $appointment], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Appointment not found!'], 404);
        }
    }
}
