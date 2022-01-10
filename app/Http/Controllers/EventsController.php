<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Participations;
use Illuminate\Http\Request;
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
     *      operationId="getAllEvents",
     *      tags={"Code challenge (Events)"},
     *      summary="Get all events data",
     *      description="Returns all events data",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function getAllEvents()
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
            )->orderBy('participations.id')->get()->toArray();
        $totalPrice = $this->getTotalPrice($data);
        
        return [
            "data" => $data,
            "totalPrice" => $totalPrice
        ];
    }

    // Calculate total price
    private function getTotalPrice($items)
    {
        $total = 0;
        foreach ($items as $item) {
            if (isset($item->participation_fee)) {
                $total += floatval($item->participation_fee);
            }
        }
        return $total;
    }

    /**
     * @OA\Get(
     *      path="/search/events",
     *      operationId="searchEvents",
     *      tags={"Code challenge (Events)"},
     *      summary="Get filtred events",
     *      description="Returns filtred events data",
     *      @OA\Parameter(
     *         name="employeeName",
     *         in="query",
     *         description="Employee name"
     *      ),
     *      @OA\Parameter(
     *         name="eventName",
     *         in="query",
     *         description="Event name"
     *      ),
     *      @OA\Parameter(
     *         name="eventDate",
     *         in="query",
     *         example="2019-09-04",
     *         description="Event date"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function searchEvents(Request $request) {
        $queryParams = $request->all();
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
            );
        if (!empty($queryParams['employeeName'])) {
            $data = $data->where('employees.name', 'like', '%' . $queryParams['employeeName'] .'%');
        }
        if (!empty($queryParams['eventName'])) {
            $data = $data->where('events.name', 'like', '%' . $queryParams['eventName'] .'%');
        }
        if (!empty($queryParams['eventDate'])) {
            $data = $data->where('events.date', $queryParams['eventDate']);
        }
        $data = $data->orderBy('participations.id')->get()->toArray();
        $totalPrice = $this->getTotalPrice($data);
        
        return [
            "data" => $data,
            "totalPrice" => $totalPrice
        ];
    }

    // Show List of events details
    public function showEventsList() {
        $result = $this->getAllEvents();
        return view('events.list', [
            'data' => $result['data'],
            'totalPrice' => $result['totalPrice']
        ]);
    }

}