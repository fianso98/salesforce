<?php

namespace App\Http\Controllers;

use App\Actions\SalesforceLoginAction;
use App\Dto\CandidatAttributeDto;
use App\Dto\CandidatDto;
use App\Services\SalesforceService;
use Illuminate\Http\Request;

class SalesforceController extends Controller
{
    public function index(SalesforceService $salesforceService)
    {
        $candidates = $salesforceService->retrieveAllCandidates();
        return view('candidates',['candidates' => $candidates]);
    }
    public function queryCandidate(SalesforceService $salesforceService, $id)
    {
        //id a004L000002gCJK
        $candidat = $salesforceService->retrieveCandidatureById($id); 
        dd($candidat);
    }

    public function addCandidate()
    {
        return view('add_condidate');
    }

    public function insertCandidate(SalesforceService $salesforceService,Request $request)
    {
        $attribute = new CandidatAttributeDto(
            url: null,
            type: 'Candidature__c'
        );
        $userDto = new CandidatDto(
            firstName : $request->firstName,
        lastName : $request->lastName,
        yearOfExperience : $request->yearOfExperience,
        year: null,
        attribute : $attribute,
        );
        $response = $salesforceService->insertCandidature($userDto);
        dd($response);
    }
    
    public function updateCandidate(SalesforceService $salesforceService, $id)
    {
        $attribute = new CandidatAttributeDto(
            url: null,
            type: 'Candidature__c'
        );
        $userDto = new CandidatDto(
            firstName : "sofiane",
            lastName : "afir",
            yearOfExperience : "1",
            year: null,
            attribute : $attribute,
        );
        $response = $salesforceService->updateCandidature($id, $userDto);
        dd($response);
    }
}
