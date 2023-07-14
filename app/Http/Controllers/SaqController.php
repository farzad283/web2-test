<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SAQService;

class SaqController extends Controller
{
    public function updateSAQ(SAQService $saqService)
    {
      
            // Call the getProduits function without specifying any parameters
            $results = $saqService->fetchProduit();
            return response()->json(['results' => $results]);
        
    }
}
