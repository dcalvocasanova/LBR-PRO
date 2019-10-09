<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Repository;
use App\Models\TokenStore;
use App\Models\TypeCalendar;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class OutlookController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function logout()
    {
        session_destroy();
        Auth::logout();
        return redirect('login');
    }
   
}
