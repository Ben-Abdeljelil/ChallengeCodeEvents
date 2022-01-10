<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      title="API documentation",
 *      version="1.0.0",
 *      @OA\Contact(
 *          email="benabdeljelilaicha@gmail.com"
 *      )
 * )
 *
 * @OA\Tag(
 *     name="Code challenge (Events)",
 *     description="API Endpoints of Projects"
 * )
*/
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
