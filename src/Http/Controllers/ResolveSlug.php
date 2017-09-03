<?php
namespace CleanSoft\Modules\Core\Http\Controllers;

use Illuminate\Routing\Controller;

class ResolveSlug extends Controller
{
    public function index($slug = null)
    {
        dd($slug);
    }
}
