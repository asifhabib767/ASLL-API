<?php

namespace Modules\ASLLHR\Repositories;

use Illuminate\Http\Request;
use Modules\ASLLHR\Entities\Rank;

class RankRepository
{
    public function getRanks()
    {
        $ranks = Rank::where('ysnActive', true)
        ->select('intID', 'strRankName', 'priority')
        ->orderBy('priority', 'asc')
        ->get();
        return $ranks;
    }
    
    public function getRanksPrint()
    {
        $ranks = Rank::where('ysnActive', true)
        ->select(
            'intID as value', 
            'strRankName as label'
        )
        ->orderBy('priority', 'asc')
        ->get();
        return $ranks;
    }
}
