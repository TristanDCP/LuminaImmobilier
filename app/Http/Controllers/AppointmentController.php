<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Appointment;

/**
 * @OA\Schema(
 *      schema="Appointment",
 *      title="Appointment Model",
 *      description="Appointment",
 *      @OA\Property(
 *          property="idAppointment", description="Appointment ID",
 *          @OA\Schema(type="number", example=1)
 *      ),
 *      @OA\Property(
 *          property="appointmentDate", description="Appointment date",
 *          @OA\Schema(type="string", example="2021-01-01 14:00:00")
 *      ),
 *      @OA\Property(
 *          property="appointmentAgent", description="ID of the agent for the appointment",
 *          @OA\Schema(type="string", example="1")
 *      ),
 *      @OA\Property(
 *          property="appointmentMotif", description="Appointment Motif",
 *          @OA\Schema(type="string", example="Rendez-vous achat maison")
 *      ),
 *      @OA\Property(
 *          property="appointmentType", description="Appointment Type",
 *          @OA\Schema(type="number", example=1)
 *      ),
 *      @OA\Property(
 *          property="idUser", description="ID user related to appointment",
 *          @OA\Schema(type="number", example=1)
 *      ),
 * )
 */

class AppointmentController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/appointment",
     *      summary="Create one appointment",
     *      tags={"Appointments"},     
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          parameter="appointmentDate",
     *          name="appointmentDate",
     *          description="appointmentDate",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="date",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="appointmentAgent",
     *          name="appointmentAgent",
     *          description="appointmentAgent",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="appointmentMotif",
     *          name="appointmentMotif",
     *          description="appointmentMotif",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="appointmentType",
     *          name="appointmentType",
     *          description="appointmentType",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="idUser",
     *          name="idUser",
     *          description="idUser",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Appointment created",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idAppointment",
     *                          type="integer",
     *                          description="Appointment ID"
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentDate",
     *                          type="date",
     *                          description="Appointment Date"
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentAgent",
     *                          type="integer",
     *                          description="Agent related to the appointment",
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentMotif",
     *                          type="string",
     *                          description="Appointment Motif",
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentType",
     *                          type="integer",
     *                          description="Appointment Type",
     *                      ),
     *                      example={
     *                          "appointment": {
     *                              "idAppointment": 1,
     *                              "appointmentDate": "2020-01-01 14:00:00",
     *                              "appointmentAgent": 1,
     *                              "appointmentMotif": "RDV Achat Maison",
     *                              "appointmentType": 2,
     *                              "idUser": 1,
     *                          }
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example="Unauthorized"
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Appointment Registration Failed!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Appointment Registration Failed!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
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
            return response()->json(['appointment' => $appointment, 'message' => 'Appointment Created'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Appointment Registration Failed!'], 409);
        }
    }


    /**
     * @OA\Get(
     *      path="/api/v1/appointments",
     *      summary="Return the list of appointments",
     *      tags={"Appointments"},
     *      security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Appointments found",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idAppointment",
     *                          type="integer",
     *                          description="Appointment ID"
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentDate",
     *                          type="date",
     *                          description="Appointment Date"
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentAgent",
     *                          type="integer",
     *                          description="Agent related to the appointment",
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentMotif",
     *                          type="string",
     *                          description="Appointment Motif",
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentType",
     *                          type="integer",
     *                          description="Appointment Type",
     *                      ),
     *                      example={
     *                          "appointment": {
     *                              {
     *                                  "idAppointment": 1,
     *                                  "appointmentDate": "2020-01-01 14:00:00",
     *                                  "appointmentAgent": 1,
     *                                  "appointmentMotif": "RDV Achat Maison",
     *                                  "appointmentType": 2,
     *                                  "idUser": 1,
     *                              },
     *                              {
     *                                  "idAppointment": 1,
     *                                  "appointmentDate": "2020-01-01 14:00:00",
     *                                  "appointmentAgent": 2,
     *                                  "appointmentMotif": "RDV",
     *                                  "appointmentType": 1,
     *                                  "idUser": 1,
     *                              }
     *                          }
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example="Unauthorized"
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Appointments not Found",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Appointments not Found"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *  )
     */
    public function allAppointment()
    {
        try {
            return response()->json(['appointment' =>  Appointment::all()], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Appointments not found!'], 404);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/appointment/{idAppointment}",
     *      summary="Return one appointment info",
     *      tags={"Appointments"},
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          parameter="idAppointment",
     *          name="idAppointment",
     *          description="idAppointment",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Appointment found",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idAppointment",
     *                          type="integer",
     *                          description="Appointment ID"
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentDate",
     *                          type="date",
     *                          description="Appointment Date"
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentAgent",
     *                          type="integer",
     *                          description="Agent related to the appointment",
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentMotif",
     *                          type="string",
     *                          description="Appointment Motif",
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentType",
     *                          type="integer",
     *                          description="Appointment Type",
     *                      ),
     *                      example={
     *                          "appointment": {
     *                              {
     *                                  "idAppointment": 1,
     *                                  "appointmentDate": "2020-01-01 14:00:00",
     *                                  "appointmentAgent": 1,
     *                                  "appointmentMotif": "RDV Achat Maison",
     *                                  "appointmentType": 2,
     *                                  "idUser": 1,
     *                              },
     *                          }
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example="Unauthorized"
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Appointment not found!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Appointment not found!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
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

    /**
     * @OA\Delete(
     *      path="/api/v1/appointment/{idAppointment}",
     *      summary="Delete one appointment",
     *      tags={"Appointments"},     
     *      security={{"bearer_token":{}}}, 
     *      @OA\Parameter(
     *          parameter="idAppointment",
     *          name="idAppointment",
     *          description="idAppointment",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Appointment deleted",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Appointment deleted"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example="Unauthorized"
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Appointment not deleted!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Appointment not deleted!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function deleteAppointment($idAppointment) 
    {
        try {
            Appointment::findOrFail($idAppointment)->delete();
            return response()->json(['message' => 'Appointment deleted'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Appointment not deleted!'], 404);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/v1/appointment/{idAppointment}",
     *      summary="Update one appointment",
     *      tags={"Appointments"},     
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          parameter="idAppointment",
     *          name="idAppointment",
     *          description="idAppointment",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="appointmentDate",
     *          name="appointmentDate",
     *          description="appointmentDate",
     *          in="query",
     *          @OA\Schema(
     *              type="date",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="appointmentAgent",
     *          name="appointmentAgent",
     *          description="appointmentAgent",
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="appointmentMotif",
     *          name="appointmentMotif",
     *          description="appointmentMotif",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="appointmentType",
     *          name="appointmentType",
     *          description="appointmentType",
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="idUser",
     *          name="idUser",
     *          description="idUser",
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Appointment updated",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idAppointment",
     *                          type="integer",
     *                          description="Appointment ID"
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentDate",
     *                          type="date",
     *                          description="Appointment Date"
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentAgent",
     *                          type="integer",
     *                          description="Agent related to the appointment",
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentMotif",
     *                          type="string",
     *                          description="Appointment Motif",
     *                      ),
     *                      @OA\Property(
     *                          property="appointmentType",
     *                          type="integer",
     *                          description="Appointment Type",
     *                      ),
     *                      example={
     *                          "appointment": {
     *                              {
     *                                  "idAppointment": 1,
     *                                  "appointmentDate": "2020-01-01 14:00:00",
     *                                  "appointmentAgent": 1,
     *                                  "appointmentMotif": "RDV Achat Maison",
     *                                  "appointmentType": 2,
     *                                  "idUser": 1,
     *                              },
     *                          }
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example="Unauthorized"
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Appointment not updated!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Appointment not updated!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function updateAppointment($idAppointment, Request $request)
    {
        try {
            $appointment = Appointment::findOrFail($idAppointment);
            $appointment->update($request->all());

            return response()->json(['appointment' => $appointment], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Appointment not updated!'], 404);
        }
    }
}
