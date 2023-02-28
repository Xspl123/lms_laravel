<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact as CT;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Contact extends Controller
{
    //show contatcts list method
    public function showContactList()
    {
        $userId = Auth::id();
        $ct = CT::join('users', 'contacts.user_id', '=', 'users.id')
                   ->select('contacts.*')
                   ->where('users.id', $userId)
                   ->orderBy('id', 'desc')
                   ->get();
                   
        return response([
            'ct'=>$ct,
            'status'=>'success'
        ], 200);
    }
     
      public function getcountris()
      {
        $data = DB::table('tbl_countries')->get();


      }
      public function getcity(Request $request, $id)
      {

        $data = DB::table('tbl_states')->where('country_id',$id)->get();

        print_r($data); exit;
        

      }
    //Add contactdetails method
    public function addContact(Request $request)
    {
        $contactOwner = Auth::user()->uname;
        //print_r($contactOwner); die;
        $userId = Auth::id();
       // print_r($userId); die;
        $rules = [
            'firstName' => 'required',
            'accountName' => 'required',
            'email' => 'required|email|unique:contacts,email',
            'phone' => 'required',
            'otherPhone' => 'required',
            'assistant' => 'required',
            'lastName' => 'required',
            'vendorName' => 'required',
            'title' => 'required|string',
            'department' => 'required|string',
            'homePhone' => 'required',
            'fax' => 'required',
            'dateofBirth' => 'required',
            'mailingStreet' => 'required',
            'mailingCity' => 'required',
            'mailingState' => 'required',
            'mailingZip' => 'required',
            'mailingCountry' => 'required',
            'otherStreet' => 'required',
            'otherCity' => 'required',
            'otherState' => 'required',
            'otherZip' => 'required',
            'otherCountry' => 'required',
            'description' => 'required'
        ];
          
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

            $contact = new CT;

            $contact->contactOwner = $contactOwner;
            $contact->firstName = $request->firstName;
            $contact->accountName = $request->accountName;
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->otherPhone = $request->otherPhone;
            $contact->assistant = $request->assistant;
            $contact->lastName = $request->lastName;
            $contact->vendorName = $request->vendorName;
            $contact->title = $request->title;
            $contact->department = $request->department;
            $contact->homePhone = $request->homePhone;
            $contact->fax = $request->fax;
            $contact->dateofBirth = $request->dateofBirth;
            $contact->mailingStreet = $request->mailingStreet;
            $contact->mailingCity = $request->mailingCity;
            $contact->mailingState = $request->mailingState;
            $contact->mailingZip = $request->mailingZip;
            $contact->mailingCountry = $request->mailingCountry;
            $contact->otherStreet = $request->otherStreet;
            $contact->otherCity = $request->otherCity;
            $contact->otherState = $request->otherState;
            $contact->otherZip = $request->otherZip;
            $contact->otherCountry = $request->otherCountry;
            $contact->description = $request->description;
            $contact->user_id = $userId;
            $contact->save();
            return response()->json(['message' => 'Contact Added successfully'], 201);
            
    }
    //Delete contact by id method
    public function deleteContactbyId($id)
    {
        $ct = CT::find($id);

        if (!$ct) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $ct->delete();

        return response()->json(['message' => 'Contact deleted'], 200);
    }
    //update contact by id method
    public function updateContact(Request $request, $id)
    {
        $ct = CT::find($id);

        if (!$ct) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $ct->update($request->all());

        return response()->json(['message' => 'Contact updated', 'contact' => $ct], 200);
    }
    
}
