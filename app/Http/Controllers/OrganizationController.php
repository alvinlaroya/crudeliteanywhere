<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Organization::orderBy('created_at', 'DESC')->get();

        /* return Organization::with('persons')->paginate(10); */
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
        $newOrganization = new Organization;
        $newOrganization->name = $request->item["name"];
        $newOrganization->description = $request->item["description"];
        $newOrganization->person_count = $request->item["person_count"];
        $newOrganization->save();

        return $newOrganization;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function getAllUsersByOrganization($id){
        $organization = Organization::find($id);
        $users = $organization->persons;
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
        $existingOrganization = Organization::find($id);
        if($existingOrganization) {
            $existingOrganization->name = $request->item['name'];
            $existingOrganization->description = $request->item['description'];
            $existingOrganization->save();
            return $existingOrganization;
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
        $existingOrganization = Organization::find($id);

        if($existingOrganization) {
            $existingOrganization->delete();
            return $existingOrganization;
        }

        return "Item not found.";
    }
}
