<?php

namespace App\Repositories\Geo;

use App\Models\Geo\Voyage;

class VoyagesRepository
{
    public static function getVoyages()
    {
        return Voyage::select('id', 'status', 'route_id', 'point_id')
            ->with(['route' => function($query) {
                $query->select('title', 'id');
            }])
            ->with(['point' => function($query) {
                $query->select('location_id', 'status', 'number', 'route_id', 'id');
            }])
            ->get();
    }

    public static function findById($id)
    {
        return Voyage::
            with(['route' => function($query) {
                $query->select('title', 'id');
            }])
            ->with(['point' => function($query) {
                $query->select('location_id', 'status', 'number', 'route_id', 'id');
            }])
            ->find($id, ['id', 'status', 'route_id', 'point_id']);
    }

    public static function getVoyagesWithPointLocation()
    {
        return Voyage::
            with(['route' => function($query) {
                $query->select('title', 'id');
            }])
            ->with(['point' => function($query) {
                $query->select('location_id', 'status', 'number', 'route_id', 'id')
                    ->with(['location' => function($query) {
                        $query->select('id', 'title');
                    }]);
            }])
            ->get(['id', 'status', 'route_id', 'point_id']);
    }
}
