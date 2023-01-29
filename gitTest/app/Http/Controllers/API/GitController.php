<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class GitController extends Controller
{
    public function getRepo(){
        $token = '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';
        $url = 'https://api.github.com/search/repositories?q=stars:%3E1&sort=stars&order=desc&per_page=100';

        $response = Http::withHeaders([
            'Authorization' => 'Token '.$token,
        ])->get($url);

        $responseData = [];
        if ($response->successful()) {
            $repositories = $response->json()['items'];
           // Loop through the array of repositories
                foreach ($repositories as $repository) {
                    $repoName = $repository['name'];
                    $ownerName = $repository['owner']['login'];
                    $temp_created_at = $repository['created_at'];

                    $created_at = strftime("%B %e %Y, %r", strtotime($temp_created_at));


                   // Get the top contributor
                    $contributorUrl = "https://api.github.com/repos/".$ownerName."/".$repoName."/contributors?sort=contributions&direction=desc&per_page=1";

                    $contributors = Http::withHeaders([
                        'Authorization' => 'Token '.$token,
                    ])->get($contributorUrl);

                   // $top_contributor = $contributors->json()[0];

                    if(count($contributors->json()) > 0){
                        $top_contributor = $contributors->json()[0];
                    } else {
                        dd($i);
                    }

                    $contributorData = ['login' => $top_contributor['login'], 'id' => $top_contributor['id'], 'contributions' => $top_contributor['id']];
                    $dataToPush = [
                        'id' => $repository['id'],
                        'name' => $repository['name'],
                        'owner' => $repository['owner'],
                        'html_url' => $repository['html_url'],
                        'contributorData' => $contributorData,
                        'created_at' => $created_at
                    ];
                   array_push($responseData, $dataToPush);
                   $i++;
                }
        } else {
            return response()->json([
                'error' => [
                    'code' => $response->status(),
                    'message' => 'Something Went Wrong !!'
                ]
            ], 400);
        }
        return $responseData;
    }
}
