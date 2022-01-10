<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Participations;
use App\Models\Employees;
use App\Models\Events;
use DB;

class EventsController extends Controller
{

    /**
     * @OA\Post(
     *      path="/events",
     *      operationId="setEvents",
     *      tags={"Code challenge (Events)"},
     *      summary="Set events data",
     *      description="Set events data into database",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function setEvents()
    {  
        $json = file_get_contents("../database/data/events.json");
        $events = json_decode($json);
        foreach ($events as $key => $value) {
            $event_id = Events::updateOrCreate(
                ["name" => $value->event_name],
                ["date" => $value->event_date]
            )->id;
            $employee_id = Employees::updateOrCreate(
                ["email" => $value->employee_mail],
                ["name" => $value->employee_name]
            )->id;
            Participations::updateOrCreate(
                [
                    "event_id" => $event_id,
                    "employee_id" => $employee_id
                ],
                [
                    "event_id" => $event_id,
                    "employee_id" => $employee_id,
                    "fee" => isset($value->participation_fee) ? $value->participation_fee : "0",
                    "version" => isset($value->version) ? $value->version : NULL,
                ]
            );
        }
        return response('Data successfully set into database!', 200)
                  ->header('Content-Type', 'text/plain');
    }
    
    /**
     * @OA\Get(
     *      path="/events",
     *      operationId="getEvents",
     *      tags={"Code challenge (Events)"},
     *      summary="Get events data",
     *      description="Returns events data",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function getEvents()
    {
        $data = DB::table('events')
            ->join('participations', 'events.id', '=', 'participations.event_id')
            ->join('employees', 'employees.id', '=', 'participations.employee_id')
            ->select(
                'participations.id as participation_id',
                'employees.name as employee_name',
                'employees.email as employee_mail',
                'events.name as event_name',
                'events.date as event_date',
                'participations.fee as participation_fee',
                'participations.version'
            )->orderBy('participations.id')->get();

            return $data->values()->toArray();
    }

    // Show List of events details
    public function showEventsList() {
        $data = $this->getEvents();
        return view('events.list', [
            'data' => $data
        ]);
    }

}