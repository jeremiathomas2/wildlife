<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Blog;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $destinations = Destination::where('status', 'Published')->get();
        
        return response()->view('sitemap', compact('destinations'))
            ->header('Content-Type', 'text/xml');
    }
}
