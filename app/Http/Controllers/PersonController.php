<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persons;
use App\Models\Organization;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $persons = Persons::with('organizations')->get();

        return $persons;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newPerson = new Persons;
        $newPerson->fname = $request->item["fname"];
        $newPerson->mname = $request->item["mname"];
        $newPerson->lname = $request->item["lname"];
        $newPerson->email = $request->item["email"];
        $newPerson->contact = $request->item["contact"];
        $newPerson->address = $request->item["address"];
        $newPerson->save();
        $newPerson->organizations()->sync($request->item["organizations"]);
        foreach($request->item["organizations"] as $id) {
            (new Persons)->increementPersonCount($id);
        }
        $orgnaizations = Organization::find($request->item["organizations"]);
        $response [] = $newPerson;
        $response [] = $orgnaizations;
        
        return json_encode($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user)
	{
		$users = Persons::with('organizations')->find($user);

		if(!$user){
			return "NOT EXIST";
		}

        return $users;
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $person = new Persons;
        $existingPerson = Persons::find($id);
        if($existingPerson) {
            $existingPerson->fname = $request->item['fname'];
            $existingPerson->mname = $request->item['mname'];
            $existingPerson->lname = $request->item['lname'];
            $existingPerson->email = $request->item['email'];
            $existingPerson->contact = $request->item['contact'];
            $existingPerson->address = $request->item['address'];
            $existingPerson->save();
            
            $person->id = $request->item["id"];
            $person->organizations()->sync($request->item["organizations"]);

            $organizations = Organization::find($request->item["organizations"]);
            $response [] = $existingPerson;
            $response [] = $organizations;
            return json_encode($response);
        }

        return "Organization not found.";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $existingPerson = Persons::find($id);
        if($existingPerson) {
            $existingPerson->delete();

            foreach($existingPerson->organizations as $key => $org) {
                (new Persons)->decrementPersonCount($org->id);
            }
            return $existingPerson;
        }
        

        return "Item not found.";
    }
}
