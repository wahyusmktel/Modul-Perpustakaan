<?php

namespace App\Http\Controllers;

use App\Services\SarprasClient;
use Illuminate\Http\Request;

class SarprasProxyController extends Controller
{
    public function institutions(Request $request, SarprasClient $api)
    {
        // forward q, page (Select2 pakai param 'term' -> map ke 'q')
        $q = $request->get('term', $request->get('q'));
        $page = (int) $request->get('page', 1);
        $data = $api->masterInstitutions(['q' => $q, 'page' => $page, 'per_page' => 20]);
        return response()->json($data);
    }

    public function buildings(Request $request, SarprasClient $api)
    {
        $q = $request->get('term', $request->get('q'));
        $page = (int) $request->get('page', 1);
        $data = $api->masterBuildings(['q' => $q, 'page' => $page, 'per_page' => 20]);
        return response()->json($data);
    }

    public function rooms(Request $request, SarprasClient $api)
    {
        $q = $request->get('term', $request->get('q'));
        $page = (int) $request->get('page', 1);
        $buildingId = $request->get('building_id'); // boleh null

        $params = ['q' => $q, 'page' => $page, 'per_page' => 20];
        if (!empty($buildingId)) {
            $params['building_id'] = $buildingId; // akan diabaikan oleh Sarpras bila kolomnya tak ada
        }

        $data = $api->masterRooms($params);
        return response()->json($data);
    }

    public function persons(Request $request, SarprasClient $api)
    {
        $q = $request->get('term', $request->get('q'));
        $page = (int) $request->get('page', 1);
        $data = $api->masterPersons(['q' => $q, 'page' => $page, 'per_page' => 20]);
        return response()->json($data);
    }

    public function faculties(Request $request, SarprasClient $api)
    {
        $q = $request->get('term', $request->get('q'));
        $page = (int) $request->get('page', 1);
        return response()->json($api->masterFaculties(['q' => $q, 'page' => $page, 'per_page' => 20]));
    }
    public function departments(Request $request, SarprasClient $api)
    {
        $q = $request->get('term', $request->get('q'));
        $page = (int) $request->get('page', 1);
        return response()->json($api->masterDepartments(['q' => $q, 'page' => $page, 'per_page' => 20]));
    }
    public function assetFunctions(Request $request, SarprasClient $api)
    {
        $q = $request->get('term', $request->get('q'));
        $page = (int) $request->get('page', 1);
        return response()->json($api->masterAssetFunctions(['q' => $q, 'page' => $page, 'per_page' => 20]));
    }
    public function fundingSources(Request $request, SarprasClient $api)
    {
        $q = $request->get('term', $request->get('q'));
        $page = (int) $request->get('page', 1);
        return response()->json($api->masterFundingSources(['q' => $q, 'page' => $page, 'per_page' => 20]));
    }
}
