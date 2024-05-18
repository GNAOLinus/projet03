<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::all();
        return view('admin.sites', compact('sites'));
    }
    
    public function create()
    {
        $site = new Site();
        return view('admin.createsites', compact('site'));
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'site' => 'required',
            'addresse' => 'required',
        ]);
    
        $site = Site::create($validatedData);
    
        return redirect()->route('sites.index')->with('success', 'Site créé avec succès');
    }
    
    public function edit(Site $site)
    {
        return view('admin.createsites', compact('site'));
    }
    
    public function update(Request $request, Site $site)
    {
        $validatedData = $request->validate([
            'site' => 'required',
            'addresse' => 'required',
        ]);
    
        $site->update($validatedData);
    
        return to_route('sites.index')->with('success', 'Site mis à jour avec succès');
    }
    
    public function destroy(Site $site)
    {
        $site->delete();
    
        return to_route('sites.index')->with('success', 'Site supprimé avec succès');
    }
}
