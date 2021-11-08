<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface BasicCrudInterface
{
    /**
     * all
     *  
     * Get all the resources
     * 
     * @return array
     */
    public function all();

    /**
     * paginated
     *  
     * Get paginated resources
     * @param int $perPage
     * @return array
     */
    public function paginated($perPage);
    public function findByID($id);
    public function findByCode($code);
    public function store(Request $request);
    public function update(Request $request, $id);
    public function delete(Request $request, $id);
}
