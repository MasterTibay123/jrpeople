<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    // ========================
    // WEB METHODS (Blade)
    // ========================
    public function view()
    {
        $people = Person::all();
        return view('people', compact('people'));
    }

    public function storeWeb(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ]);

        Person::create($request->only(['firstname', 'lastname']));
        return redirect()->route('people.view')->with('success', 'Person added successfully!');
    }

    public function updateWeb(Request $request, $id)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ]);

        $person = Person::findOrFail($id);
        $person->update($request->only(['firstname', 'lastname']));

        return redirect()->route('people.view')->with('success', 'Person updated successfully!');
    }

    public function destroyWeb($id)
    {
        Person::destroy($id);
        return redirect()->route('people.view')->with('success', 'Person deleted successfully!');
    }

    // ========================
    // API METHODS (JSON)
    // ========================
    public function index()
    {
        return response()->json(Person::all());
    }

    public function show($id)
    {
        $person = Person::findOrFail($id);
        return response()->json($person);
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ]);

        $person = Person::create($request->only(['firstname', 'lastname']));
        return response()->json([
            'success' => true,
            'data' => $person
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ]);

        $person = Person::findOrFail($id);
        $person->update($request->only(['firstname', 'lastname']));

        return response()->json([
            'success' => true,
            'data' => $person
        ]);
    }

    public function destroy($id)
    {
        Person::destroy($id);
        return response()->json(['success' => true]);
    }
}
