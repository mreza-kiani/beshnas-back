<?php

namespace App\Http\Controllers;

use App\Models\User;


/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getIndex()
    {
        /*User::create([
            'name' => 'عزیزی',
            'email' => 'n.azizi@hinzaco.com',
            'password' => bcrypt('hinza@321'),
        ]);*/

        return redirect("/app");
    }
}
